<?php
class ControllerAccountCustomerSupport extends Controller {	
	private $error = array();
	private $customer_support_status = array(
			  'Open'
			, 'Closed'
	);
	public function index() {
    	if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customer_support', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/support.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/support.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/support.css');
		}
    	
    	$this->language->load('account/customer_support');
    	
		$this->document->setTitle($this->language->get('heading_title'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
        	'href'		=> $this->url->link('common/home'),
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
        	'href'		=> $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_customer_support'),
        	'href'		=> $this->url->link('account/customer_support', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
      	
      	$this->data['heading_title'] 		= $this->language->get('heading_title');
      	
      	$this->data['button_enquiry'] 		= $this->language->get('button_enquiry');
      	$this->data['button_delete'] 		= $this->language->get('button_delete');
      	$this->data['button_submit'] 		= $this->language->get('button_submit');
      	
      	$this->data['column_no'] 			= $this->language->get('column_no');
      	$this->data['column_reference'] 	= $this->language->get('column_reference');
      	$this->data['column_customer_support_status'] 	= $this->language->get('column_customer_support_status');
      	$this->data['column_subject'] 		= $this->language->get('column_subject');
      	$this->data['column_created_at'] 	= $this->language->get('column_created_at');
      	$this->data['column_answer'] 		= $this->language->get('column_answer');
      	$this->data['column_answered'] 		= $this->language->get('column_answered');
      	$this->data['column_enquiry'] 		= $this->language->get('column_enquiry');
      	$this->data['column_category_1st'] 	= $this->language->get('column_category_1st');
      	$this->data['column_category_2nd'] 	= $this->language->get('column_category_2nd');
      	$this->data['column_action'] 		= $this->language->get('column_action');
      	
      	$this->data['text_reference'] 		= $this->language->get('text_reference');
      	$this->data['text_customer_support_status'] = $this->language->get('text_customer_support_status');
      	$this->data['text_answer_y'] 		= $this->language->get('text_answer_y');
      	$this->data['text_answer_n'] 		= $this->language->get('text_answer_n');
      	$this->data['text_no_answer'] 		= $this->language->get('text_no_answer');
      	$this->data['text_answer_date'] 	= $this->language->get('text_answer_date');
      	$this->data['text_enquiry_date'] 	= $this->language->get('text_enquiry_date');
      	$this->data['text_wait'] 			= $this->language->get('text_wait');
      	$this->data['text_confirm_delete'] 	= $this->language->get('text_confirm_delete');
      	$this->data['text_no_results'] 		= $this->language->get('text_no_results');
      	$this->data['text_none'] 			= $this->language->get('text_none');
      	
      	$this->data['error_no_subject'] 	= $this->language->get('error_no_subject');
      	$this->data['error_no_enquiry'] 	= $this->language->get('error_no_enquiry');
      	
		$this->data['new_enquiry_action'] 	= $this->url->link('account/customer_support/new_enquiry', '', 'SSL');
		$this->data['delete_enquiry_action'] = $this->url->link('account/customer_support/delete_enquiry', '', 'SSL');
      	
		$this->load->model('account/customer_support');
      		
		if (isset($this->request->get['page'])) 
		{
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['sort'])) 
		{
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cs.date_updated';
		}

		if (isset($this->request->get['order'])) 
		{
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		$url = '';
		if (isset($this->request->get['page'])) 
		{
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) 
		{
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) 
		{
			$url .= '&order=' . $this->request->get['order'];
		}
      	$data = array(
      		'customer_id'			 => $this->customer->getId(),
      		'only_topics'			 => true,
      		'status'				 => 1,	
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$this->data['customer_supports'] = array();

		$customer_support_total = $this->model_account_customer_support->getTotalCustomerSupports($data);
		
		$customer_support_results = $this->model_account_customer_support->getCustomerSupports($data);

		foreach ($customer_support_results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('account/customer_support/view', 'customer_support_id=' . $result['customer_support_id'] . $url, 'SSL')
			);

			$search_options = array(
				  'customer_support_topic_id' => $result['customer_support_topic_id']
				, 'except_topics'	=>	true
				, 'status'			=>	1
				, 'order'			=>	'ASC'
			);
			
			$this->data['customer_supports'][] = array(
				'customer_support_id'   			=> $result['customer_support_id'],
				'customer_support_topic_id'			=> $result['customer_support_topic_id'],
				'customer_support_1st_category'     => $result['customer_support_1st_category'],
				'customer_support_2nd_category'     => $result['customer_support_2nd_category'],
				'reference'       					=> $result['reference'],
				'customer_support_status' 			=> $result['customer_support_status'],
				'subject'       					=> html_entity_decode($result['subject'], ENT_QUOTES, 'UTF-8'),
				'enquiry'     			            => html_entity_decode($result['enquiry'], ENT_QUOTES, 'UTF-8'),
				'date_added' 			            => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'time_added' 			            => date($this->language->get('time_format'), strtotime($result['date_added'])),
				'date_updated' 			            => date($this->language->get('date_format_short'), strtotime($result['date_updated'])),
				'time_updated' 			            => date($this->language->get('time_format'), strtotime($result['date_updated'])),
				'action'     			            => $action,
				'customer_supports_threads'			=> $this->model_account_customer_support->getCustomerSupports($search_options)
			);
		}
		$this->data['list_customer_support_status'] = $this->customer_support_status;

		
		$pagination = new Pagination();
		$pagination->total = $customer_support_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/customer_support',  $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$cs_1st_category = $this->model_account_customer_support->getCustomerSupport1stCategory();
		
		$cs_2nd_category = array();
		
		if(!empty($cs_1st_category))
		{
			$data = array(
				'customer_support_1st_category_id' => $cs_1st_category[0]['customer_support_1st_category_id']
			);
			$cs_2nd_category = $this->model_account_customer_support->getCustomerSupport2ndCategory($data);
		}
		$this->data['cs_1st_category'] = $cs_1st_category;
		$this->data['cs_2nd_category'] = $cs_2nd_category;
      	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customer_support.tpl')) 
      	{
			$this->template = $this->config->get('config_template') . '/template/account/customer_support.tpl';
		} else {
			$this->template = 'default/template/account/customer_support.tpl';
		}
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);	
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	public function new_enquiry() {
		$json = array();
		
		$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->new_enquiry_validate()) {
			
			$t_topic_id = isset($this->request->post['t_topic_id'])?$this->request->post['t_topic_id']: '';
			if($t_topic_id != '')
			{
				// Thread
				// Get enquiry
				$customer_support = $this->model_account_customer_support->getCustomerSupport($t_topic_id);
				if(!empty($customer_support))
				{
					if($customer_support['customer_id'] == $this->customer->getId())
					{
						$new_thread = array(
							'customer_support_topic_id'	=>	$customer_support['customer_support_topic_id'],
							'reference'	=>	$customer_support['reference'],
							'customer_support_status'	=>	$this->request->post['customer_support_status'],
							'subject'	=>	"RE: ". html_entity_decode($customer_support['subject'], ENT_QUOTES, 'UTF-8'),
							'enquiry'	=>	html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8'),
							'customer_support_1st_category_id'	=>	$customer_support['customer_support_1st_category_id'],
							'customer_support_2nd_category_id'	=>	$customer_support['customer_support_2nd_category_id']
						);	
						$this->model_account_customer_support->addCustomerSupport($new_thread);
					} else {
						$json['error'] = $this->language->get('error_no_permission_enquiry');
					}
				} else {
					$json['error'] = $this->language->get('error_not_found_enquiry');
				}
			} else {
				$this->request->post['reference'] = strtoupper(substr(md5(time()),0,7));
				$this->model_account_customer_support->addCustomerSupport($this->request->post);		
			}
			
			$json['success'] = $this->language->get('text_success');
		} else {
			$json['error'] = $this->error['message'];
		}	
		
		$this->response->setOutput(json_encode($json));
	}
	
	private function new_enquiry_validate() {
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
		if(isset($this->request->post['subject']))
		{
			if ((utf8_strlen($this->request->post['subject']) < 3) || (utf8_strlen($this->request->post['subject'])) > 250) 
			{
				$this->error['message'] = $this->language->get('error_no_subject');
			}
		}
		
		if ((utf8_strlen($this->request->post['enquiry']) < 25) || (utf8_strlen($this->request->post['enquiry'])) > 2000)
		{
			$this->error['message'] = $this->language->get('error_no_enquiry');
		}
		
		if(!($this->error))
		{
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_enquiry() {
		$json = array();
		
		$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->delete_enquiry_validate()) {
			$data = array(
				'customer_support_id'	=>	$this->request->post['enquiry_id']
			);
			$this->model_account_customer_support->deleteCustomerSupport($data);
			
			$json['success'] = $this->language->get('text_success_delete');
		} else {
			$json['error'] = $this->error['message'];
		}	
		
		$this->response->setOutput(json_encode($json));
	}
	
	private function delete_enquiry_validate(){
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
		if (!isset($this->request->post['enquiry_id']) ||  $this->request->post['enquiry_id'] == "") 
		{
			$this->error['message'] = $this->language->get('error_no_enquiry_id');
		}
		
		$data = array(
			'customer_support_id'	=>	$this->request->post['enquiry_id']
		);
		
		$customer_support = $this->model_account_customer_support->getCustomerSupports($data);
		
		if(empty($customer_support))
		{
			$this->error['message'] = $this->language->get('error_not_found_enquiry');	
		} else {
			$customer_support = $customer_support[0];
			if($customer_support['customer_id'] != $this->customer->getId())
			{
				$this->error['message'] = $this->language->get('error_no_permission');
			}
		}
		
		if(!($this->error)) 
		{
			return true;
		} else {
			return false;
		}
	}

	public function get_2nd_category(){
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
    	$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		
		$output = "";
		
		$data = array(
			'customer_support_1st_category_id'	=>	$this->request->get['1st_category']
		);
		
		$cs_2nd_category_result = $this->model_account_customer_support->getCustomerSupport2ndCategory($data);
		
		foreach($cs_2nd_category_result as $result)
		{
			$output .= '<option value="'. $result['customer_support_2nd_category_id']. '"';
			
			if (isset($this->request->get['2nd_category']) && ($this->request->get['2nd_category'] == $result['customer_support_2nd_category_id'])) {
	      		$output .= ' selected="selected"';
	    	}
			
	    	$output .= '>' . $result['customer_support_2nd_category'] . '</option>';
		}
		
		if (!$cs_2nd_category_result) {
			if (isset($this->request->get['2nd_category']) && !$this->request->get['2nd_category']) {
		  		$output .= '<option value="" selected="selected">' . $this->language->get('text_none') . '</option>';
			} else {
				$output .= '<option value="">' . $this->language->get('text_none') . '</option>';
			}
		}
		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
}
?>