<?php
class ModelAccountCustomerSupport extends Model {
	public function getTotalCustomerSupports($data = array()) {
      	$sql = "SELECT 
      				COUNT(*) AS total 
      			FROM `" . DB_PREFIX . "customer_support` cs
      			WHERE cs.customer_id = '". (int) $data['customer_id']."'
      				AND cs.status = 1
      	";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getCustomerSupport($customer_support_id) {
		$sql = "
			SELECT
				cs.customer_support_id,
				cs.customer_support_topic_id,
				cs.store_id,
				s.name as store_name,
				cs.customer_support_1st_category_id,
				cs.customer_support_2nd_category_id,
				cs1cd.name AS customer_support_1st_category,
				cs2cd.name AS customer_support_2nd_category,
				cs.customer_id,
				cs.reference,
				cs.customer_support_status,
				c.firstname,
				c.lastname,
				c.email AS customer_email,
				cs.subject,
				cs.enquiry,
				cs.date_added,
				cs.date_updated
			FROM " . DB_PREFIX . "customer_support cs
				LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category` cs1c ON
					cs.customer_support_1st_category_id = cs1c.category_id
					AND cs1c.parent_id = 0
				LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category_description` cs1cd ON
					cs1c.category_id = cs1cd.category_id AND cs1cd.language_id = ".(int)$this->config->get('config_language_id')."
				LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category` cs2c ON
					cs.customer_support_2nd_category_id = cs2c.category_id
					AND cs2c.parent_id = cs1c.category_id
				LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category_description` cs2cd ON
					cs2c.category_id = cs2cd.category_id AND cs2cd.language_id = ".(int)$this->config->get('config_language_id')."
				LEFT OUTER JOIN " . DB_PREFIX . "store s
					ON cs.store_id = s.store_id
				LEFT OUTER JOIN " . DB_PREFIX . "customer c
					ON cs.customer_id = c.customer_id
			WHERE 
				cs.customer_support_id = '" . (int)$this->db->escape($customer_support_id) . "'
				AND cs.status = 1
		";																																					  
		$query = $this->db->query($sql);																																				
		return $query->row;	
	}
	
	public function getCustomerSupports($data = array()) {
		$sql = "
				SELECT 
					cs.customer_support_id,
					cs.customer_support_topic_id,
					cs.customer_id,
					cs.reference,
					cs.customer_support_status,
					cs1cd.name AS customer_support_1st_category,
					cs2cd.name AS customer_support_2nd_category,
					cs.subject,
					cs.enquiry,
					cs.date_added,
					cs.date_updated
				FROM `" . DB_PREFIX . "customer_support` cs
					LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category` cs1c ON
						cs.customer_support_1st_category_id = cs1c.category_id
						AND cs1c.parent_id = 0
					LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category_description` cs1cd ON
						cs1c.category_id = cs1cd.category_id AND cs1cd.language_id = '".(int)$this->config->get('config_language_id')."'
					LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category` cs2c ON
						cs.customer_support_2nd_category_id = cs2c.category_id
						AND cs2c.parent_id = cs1c.category_id
					LEFT OUTER JOIN `". DB_PREFIX  ."customer_support_category_description` cs2cd ON
						cs2c.category_id = cs2cd.category_id AND cs2cd.language_id = '".(int)$this->config->get('config_language_id')."'
				WHERE cs.customer_support_id IS NOT NULL AND cs.status = 1
		";
		
		if(isset($data['only_topics']) && $data['only_topics'] == true)
		{
			$sql .= " AND cs.customer_support_id = cs.customer_support_topic_id";
		}																		
		
		if(isset($data['except_topics']) && $data['except_topics'] == true)
		{
			$sql .= " AND cs.customer_support_id != cs.customer_support_topic_id";
		}											
	
		if (isset($data['customer_id']) && !is_null($data['customer_id'])) {
			$sql .= " AND cs.customer_id = '" . (int)$data['customer_id'] . "'";
		}
		
		if (isset($data['customer_support_id']) && !is_null($data['customer_support_id'])) {
			$sql .= " AND cs.customer_support_id = '" . (int)$data['customer_support_id'] . "'";
		}

		if(isset($data['customer_support_topic_id']))
		{
			$sql .= " AND cs.customer_support_topic_id = ". (int)$data['customer_support_topic_id'];
		}							
		
		$sort_data = array(
			'cs.date_added',
			'cs.date_updated',
			'cs.customer_support_id',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cs.customer_support_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function addCustomerSupport($data = array()){
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "customer_support 
			SET 
				store_id = '" . (int)$this->config->get('config_store_id') . "', 
				customer_id = '" . (int)$this->customer->getId() . "', 
				customer_support_1st_category_id = '" . (int)(isset($data['customer_support_1st_category_id'])?$data['customer_support_1st_category_id']:0) . "', 
				customer_support_2nd_category_id = '" . (int)(isset($data['customer_support_2nd_category_id'])?$data['customer_support_2nd_category_id']:0) . "', 
				reference = '" . $this->db->escape(strip_tags($data['reference'])) . "', 
				customer_support_status = '" . $this->db->escape(strip_tags($data['customer_support_status'])) . "', 
				subject = '" . $this->db->escape(strip_tags($data['subject'])) . "', 
				enquiry = '" . $this->db->escape(strip_tags($data['enquiry'])) . "', 
				date_added = NOW(),
				date_updated = NOW()
			");
		
		$customer_support_id = $this->db->getLastId();
		if(isset($data['customer_support_topic_id']) && $data['customer_support_topic_id'] != '')
		{
			$this->db->query("
				UPDATE " . DB_PREFIX . "customer_support
				SET
					customer_support_topic_id = '".(int)$data['customer_support_topic_id']."'
				WHERE
					customer_support_id = '".(int)$customer_support_id."'
			");
			$this->db->query("
				UPDATE " . DB_PREFIX . "customer_support
				SET
					date_updated = NOW()
					, customer_support_status = '".$this->db->escape(strip_tags($data['customer_support_status']))."'
				WHERE
					customer_support_id = '".(int)$data['customer_support_topic_id']."'
			");
		}
		else
		{
			$this->db->query("
				UPDATE " . DB_PREFIX . "customer_support
				SET
					customer_support_topic_id = '".(int)$customer_support_id."'
				WHERE
					customer_support_id = '".(int)$customer_support_id."'
			");
				
		}
		
		$category_data = array(
			  'customer_support_1st_category_id'			=>	isset($data['customer_support_1st_category_id']) ? $data['customer_support_1st_category_id']:0	
			, 'customer_support_2nd_category_id'			=>	isset($data['customer_support_2nd_category_id']) ?$data['customer_support_2nd_category_id']:0
		);
		$tmp_data = array();
		$tmp_data = $this->getCustomerSupport1stCategory($category_data);
		$category_data['customer_support_1st_category'] = !empty($tmp_data) ? $tmp_data[0]['customer_support_1st_category']: $this->language->get('text_none');
		$tmp_data = array();
		$tmp_data = $this->getCustomerSupport2ndCategory($category_data);
		$category_data['customer_support_2nd_category'] = !empty($tmp_data) ? $tmp_data[0]['customer_support_2nd_category']: $this->language->get('text_none');
		
		$language = new Language('english');
		$language->load('mail/customer_support');
		
		$subject = "[".$this->config->get('config_name')."] ".html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8');
		// HTML Mail
		$template = new Template();
		
		$template->data['title'] 			= $language->get('text_subject');
		$template->data['text_greeting'] 	= sprintf($language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		
		$template->data['text_reference'] 	= $language->get('text_reference');
		$template->data['text_category'] 	= $language->get('text_category');
		$template->data['text_subject'] 	= $language->get('text_subject');
		$template->data['text_enquiry'] 	= $language->get('text_enquiry');
		$template->data['text_lead_url'] 	= $language->get('text_lead_url');
		$template->data['text_powered_by'] 	= $language->get('text_powered_by');
		
		$template->data['store_url'] 		= $this->config->get('config_url');
		$template->data['store_name'] 		= $this->config->get('config_name');
		$template->data['subject'] 			= $data['subject'];
		$template->data['enquiry'] 			= nl2br(html_entity_decode($data['enquiry'], ENT_QUOTES, 'UTF-8'));
		$template->data['category'] 		= $category_data['customer_support_1st_category'].'/'.$category_data['customer_support_2nd_category'];
		$template->data['lead_url'] 		= $this->config->get('config_url'). 'index.php?route=account/customer_support';
		
		$template->data['logo'] = 'cid:' . basename($this->config->get('config_logo'));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/customer_support.tpl')) {
			$html = $template->fetch($this->config->get('config_template') . '/template/mail/customer_support.tpl');
		} else {
			$html = $template->fetch('default/template/mail/customer_support.tpl');
		}
		
		// Text Mail
		$text  = sprintf($language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
		$text .= $language->get('text_category'). ": ". html_entity_decode($category_data['customer_support_1st_category'].'/'.$category_data['customer_support_2nd_category'], ENT_QUOTES, 'UTF-8')."\n\n";
		$text .= $language->get('text_reference'). ": ". html_entity_decode($data['reference'], ENT_QUOTES, 'UTF-8')."\n\n";
		$text .= $language->get('text_subject'). ": ". html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8')."\n\n";
		$text .= $language->get('text_enquiry'). ": ". nl2br(html_entity_decode($data['enquiry'], ENT_QUOTES, 'UTF-8'))."\n\n";
		$text .= $language->get('text_lead_url'). ": ". $this->config->get('config_url'). 'index.php?route=account/customer_support';
		
		$mail = new Mail(); 
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');			
		
		$mail->setSubject($subject);
		$mail->setHtml($html);
		$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
		$mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'));
		
		$mail->setTo($this->customer->getEmail());
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->send();
		
		// 	Send to additional alert emails
		$mail->setSubject("[ADMIN]". $subject);
		$mail->setTo($this->config->get('config_email'));
		$mail->setHtml($html);
		$mail->send();
	}
	
	public function deleteCustomerSupport($data = array()){
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer_support
			SET 
				status = 0,
				date_updated = NOW()
			WHERE 
				customer_support_id = '". (int)$this->db->escape($data['customer_support_id']) ."'
		");
	}
	
	public function getCustomerSupport1stCategory($data = array()) {
		$sql = "
			SELECT 
				cs1c.*
				, cs1c.category_id AS customer_support_1st_category_id
				, cs1cd.name AS customer_support_1st_category
			FROM `" . DB_PREFIX . "customer_support_category` cs1c
				LEFT OUTER JOIN `" . DB_PREFIX . "customer_support_category_description` cs1cd
					ON cs1c.category_id = cs1cd.category_id
				LEFT OUTER JOIN " . DB_PREFIX . "customer_support_category_to_store c2s ON (cs1c.category_id = c2s.category_id)
			WHERE cs1c.status = 1 
				AND cs1c.parent_id = 0
				AND cs1cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 	";
		if(isset($data['customer_support_1st_category_id']) && $data['customer_support_1st_category_id'] != "")
		{
			$sql .= " AND cs1c.category_id='". (int)$data['customer_support_1st_category_id'] ."'";
		}
		
		$sql .= "
			ORDER BY cs1c.sort_order, LCASE(cs1cd.name) 
		";
		
		$query = $this->db->query($sql);	
	
		return $query->rows;
	}
	
	public function getCustomerSupport2ndCategory($data = array()) {
		$sql = "
			SELECT 
				cs2c.* 
				, cs2c.category_id AS customer_support_2nd_category_id
				, cs2cd.name AS customer_support_2nd_category
			FROM `" . DB_PREFIX . "customer_support_category` cs2c
				LEFT OUTER JOIN `" . DB_PREFIX . "customer_support_category_description` cs2cd
					ON cs2c.category_id = cs2cd.category_id
				LEFT OUTER JOIN " . DB_PREFIX . "customer_support_category_to_store c2s ON (cs2c.category_id = c2s.category_id)
			WHERE cs2c.status = 1
				AND cs2cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
		";
		if(isset($data['customer_support_1st_category_id']) && $data['customer_support_1st_category_id'] != "")
		{
			$sql .= " AND cs2c.parent_id='". (int)$data['customer_support_1st_category_id'] ."'";
		}
		if(isset($data['customer_support_2nd_category_id']) && $data['customer_support_2nd_category_id'] != "")
		{
			$sql .= " AND cs2c.category_id='". (int)$data['customer_support_2nd_category_id'] ."'";
		}
		$sql .=" 
			ORDER BY cs2c.sort_order , LCASE(cs2cd.name)
		";	
	
		$query = $this->db->query($sql);
		
		
		return $query->rows;
	}
}
?>