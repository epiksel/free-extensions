<?php
class ModelCatalogCustomerSupport extends Model {
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
				cs.date_updated,
				cs.status
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
		";																																					  
		$query = $this->db->query($sql);																																				
		return $query->row;	
	}
	public function getCustomerSupports($data = array()) {
		$sql = "
			SELECT
				cs.customer_support_id,
				cs.customer_support_topic_id,
				cs.store_id,
				s.name as store_name,
				cs1cd.name AS customer_support_1st_category,
				cs2cd.name AS customer_support_2nd_category,
				cs.customer_id,
				cs.reference,
				cs.customer_support_status,
				c.firstname,
				c.lastname,
				cs.subject,
				cs.enquiry,
				cs.date_added,
				cs.date_updated,
				cs.status
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
			WHERE cs.customer_support_id IS NOT NULL
		";											
		
		if(isset($data['only_topics']) && $data['only_topics'] == true)
		{
			$sql .= " AND cs.customer_support_id = cs.customer_support_topic_id";
		}																		
		
		if(isset($data['except_topics']) && $data['except_topics'] == true)
		{
			$sql .= " AND cs.customer_support_id != cs.customer_support_topic_id";
		}											
		
		if(isset($data['customer_support_topic_id']))
		{
			$sql .= " AND cs.customer_support_topic_id = ". (int)$data['customer_support_topic_id'];
		}
									
		if(isset($data['filter_customer_support_id']) && $data['filter_customer_support_id'] != '')
		{
			$sql .= " AND cs.customer_support_id = ". (int)$data['filter_customer_support_id'];
		}							
									
		if(isset($data['filter_customer_support_status']) && $data['filter_customer_support_status'] != '')
		{
			$sql .= " AND LOWER(cs.customer_support_status) = '". $this->db->escape(strtolower($data['filter_customer_support_status']))."'";
		}							
									
		if(isset($data['filter_cs_category_id']) && $data['filter_cs_category_id'] != '')
		{
			$sql .= " AND (cs.customer_support_1st_category_id = ". (int)$data['filter_cs_category_id']."
						OR cs.customer_support_2nd_category_id = ". (int)$data['filter_cs_category_id'].")";
		}							
									
		if(isset($data['filter_customer_subject']) && $data['filter_customer_subject'] != '')
		{
			$sql .= " AND (cs.subject LIKE '%". $this->db->escape($data['filter_customer_subject']) ."%'
							OR cs.reference LIKE '%". $this->db->escape($data['filter_customer_subject']) ."%')";
		}							
		
		if(isset($data['filter_date_added']) && $data['filter_date_added'] != '')
		{
			$sql .= " AND cs.date_added = '". $this->db->escape($data['filter_date_added'])."'";
		}
		
		$sort_data = array(
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
	
	public function getTotalCustomerSupports() {
		$query = $this->db->query("
			SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_support 
			WHERE customer_support_id = customer_support_topic_id
		");
		
		return $query->row['total'];
	}
	
	public function addCustomerSupport($data)
	{
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "customer_support
			SET
				  customer_support_topic_id = '" . (int)$data['customer_support_topic_id'] . "' 
				, store_id = '" . (int)$data['store_id'] . "'
				, customer_id = '" . (int)$data['customer_id'] . "'
				, reference = '". $data['reference'] ."' 
				, customer_support_status = '". $data['customer_support_status'] ."' 
				, subject = '" . $this->db->escape(strip_tags($data['subject'])) . "'
				, enquiry = '" . $this->db->escape(strip_tags($data['enquiry'])) . "'
				, date_added = NOW() 
				, date_updated = NOW() 
				, customer_support_1st_category_id = '" . (int)$data['customer_support_1st_category_id'] . "' 
				, customer_support_2nd_category_id = '" . (int)$data['customer_support_2nd_category_id'] . "'
		");
		$customer_support_id = $this->db->getLastId();
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer_support
			SET
				date_updated = NOW()
				, customer_support_status ='".$data['customer_support_status']."'
			WHERE
				customer_support_id = '".(int)$data['customer_support_topic_id']."'
		");
		
		if(isset($data['notify_customer']) && $data['notify_customer'] == 'notify')
		{
			$data = $this->getCustomerSupport($customer_support_id);
			if(!empty($data))
			{
				$parent_data = $this->getCustomerSupport($data['customer_support_topic_id']);
				
				$language = new Language('english');
				$language->load('mail/customer_support');
				
				$subject = "[".$this->config->get('config_name')."] ".html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'). " - ".$language->get('text_answered');
				// HTML Mail
				$template = new Template();
				
				$template->data['title'] 			= $language->get('text_subject');
				$template->data['text_greeting'] 	= sprintf($language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				
				$template->data['text_category'] 	= $language->get('text_category');
				$template->data['text_reference'] 	= $language->get('text_reference');
				$template->data['text_subject'] 	= $language->get('text_subject');
				$template->data['text_enquiry'] 	= $language->get('text_enquiry');
				$template->data['text_lead_url'] 	= $language->get('text_lead_url');
				$template->data['text_powered_by'] 	= $language->get('text_powered_by');
				
				$template->data['store_url'] 		= $this->config->get('config_url');
				$template->data['store_name'] 		= $this->config->get('config_name');
				$template->data['subject'] 			= $data['subject'];
				$template->data['enquiry'] 			= nl2br(html_entity_decode($data['enquiry'], ENT_QUOTES, 'UTF-8'));
				$template->data['category'] 		= $data['customer_support_1st_category'].'/'.$data['customer_support_2nd_category'];
				$template->data['lead_url'] 		= $this->config->get('config_url'). 'index.php?route=account/customer_support';
				
				$template->data['logo'] 			= 'cid:' . basename($this->config->get('config_logo'));
				
				$html = $template->fetch('/mail/customer_support.tpl');
				// Text Mail
				$text  = sprintf($language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
				$text .= $language->get('text_category'). ": ". html_entity_decode($data['customer_support_1st_category'].'/'.$data['customer_support_2nd_category'], ENT_QUOTES, 'UTF-8')."\n\n";
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
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($html);
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'));
				$mail->send();	
			}
			
		}
	}
	
	public function editCustomerSupport($customer_support_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer_support
			SET
				  customer_support_topic_id = '" . (int)$data['customer_support_topic_id'] . "' 
				, store_id = '" . (int)$data['store_id'] . "'
				, customer_id = '" . (int)$data['customer_id'] . "' 
				, reference = '" . $this->db->escape(strip_tags($data['reference'])) . "'
				, customer_support_status = '" . $this->db->escape(strip_tags($data['customer_support_status'])) . "'
				, subject = '" . $this->db->escape(strip_tags($data['subject'])) . "'
				, enquiry = '" . $this->db->escape(strip_tags($data['enquiry'])) . "'
				, date_updated = NOW() 
				, customer_support_1st_category_id = '" . (int)$data['customer_support_1st_category_id'] . "' 
				, customer_support_2nd_category_id = '" . (int)$data['customer_support_2nd_category_id'] . "'
			WHERE 
				customer_support_id = '".(int)$customer_support_id."'
		");
	}
	
	public function deleteCustomerSupport($customer_support_id) {
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "customer_support 
				WHERE customer_support_topic_id = '" . (int)$customer_support_id . "'");
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