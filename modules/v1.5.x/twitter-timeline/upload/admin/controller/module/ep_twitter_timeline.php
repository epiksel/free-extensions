<?php
class ControllerModuleEPTwitterTimeline extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->load->language('module/ep_twitter_timeline');

		$this->document->setTitle($this->language->get('heading_title_normal'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ep_twitter_timeline', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_or'] = $this->language->get('text_or');
		$this->data['text_create_paypal'] = $this->language->get('text_create_paypal');
		$this->data['text_developer'] = $this->language->get('text_developer');
		$this->data['text_tt_version'] = $this->language->get('text_tt_version');
		
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_twitter_user'] = $this->language->get('entry_twitter_user');
		$this->data['entry_tweet_count'] = $this->language->get('entry_tweet_count');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		$this->data['entry_shell_background'] = $this->language->get('entry_shell_background');
		$this->data['entry_shell_color'] = $this->language->get('entry_shell_color');
		$this->data['entry_tweet_background'] = $this->language->get('entry_tweet_background');
		$this->data['entry_tweet_color'] = $this->language->get('entry_tweet_color');
		$this->data['entry_tweet_links'] = $this->language->get('entry_tweet_links');
		$this->data['entry_scrollbar'] = $this->language->get('entry_scrollbar');
		$this->data['entry_loop'] = $this->language->get('entry_loop');
		$this->data['entry_live'] = $this->language->get('entry_live');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->data['tab_module'] = $this->language->get('tab_module');
		
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ep_twitter_timeline', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/ep_twitter_timeline', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ep_twitter_timeline_username'])) {
      		$this->data['ep_twitter_timeline_username'] = $this->request->post['ep_twitter_timeline_username'];
    	} else if ($this->config->get('ep_twitter_timeline_username')) {
      		$this->data['ep_twitter_timeline_username'] = $this->config->get('ep_twitter_timeline_username');
    	} else {
      		$this->data['ep_twitter_timeline_username'] = 'epiksel';
    	}
		
		if (isset($this->request->post['ep_twitter_timeline_tweet_count'])) {
			$this->data['ep_twitter_timeline_tweet_count'] = $this->request->post['ep_twitter_timeline_tweet_count'];
    	} else if ($this->config->get('ep_twitter_timeline_tweet_count')) {
      		$this->data['ep_twitter_timeline_tweet_count'] = $this->config->get('ep_twitter_timeline_tweet_count');
		} else {
			$this->data['ep_twitter_timeline_tweet_count'] = 7;
		}
		
		if (isset($this->request->post['ep_twitter_timeline_width'])) {
			$this->data['ep_twitter_timeline_width'] = $this->request->post['ep_twitter_timeline_width'];
    	} else if ($this->config->get('ep_twitter_timeline_width')) {
      		$this->data['ep_twitter_timeline_width'] = $this->config->get('ep_twitter_timeline_width');
		} else {
			$this->data['ep_twitter_timeline_width'] = 'auto';
		}
		
		if (isset($this->request->post['ep_twitter_timeline_height'])) {
			$this->data['ep_twitter_timeline_height'] = $this->request->post['ep_twitter_timeline_height'];
    	} else if ($this->config->get('ep_twitter_timeline_height')) {
      		$this->data['ep_twitter_timeline_height'] = $this->config->get('ep_twitter_timeline_height');
		} else {
			$this->data['ep_twitter_timeline_height'] = 300;
		}
		
		if (isset($this->request->post['ep_twitter_timeline_shell_background'])) {
			$this->data['ep_twitter_timeline_shell_background'] = $this->request->post['ep_twitter_timeline_shell_background'];
    	} else if ($this->config->get('ep_twitter_timeline_shell_background')) {
      		$this->data['ep_twitter_timeline_shell_background'] = $this->config->get('ep_twitter_timeline_shell_background');
		} else {
			$this->data['ep_twitter_timeline_shell_background'] = 333333;
		}
		
		if (isset($this->request->post['ep_twitter_timeline_shell_color'])) {
			$this->data['ep_twitter_timeline_shell_color'] = $this->request->post['ep_twitter_timeline_shell_color'];
    	} else if ($this->config->get('ep_twitter_timeline_shell_color')) {
      		$this->data['ep_twitter_timeline_shell_color'] = $this->config->get('ep_twitter_timeline_shell_color');
		} else {
			$this->data['ep_twitter_timeline_shell_color'] = 'ffffff';
		}
		
		if (isset($this->request->post['ep_twitter_timeline_tweet_background'])) {
			$this->data['ep_twitter_timeline_tweet_background'] = $this->request->post['ep_twitter_timeline_tweet_background'];
    	} else if ($this->config->get('ep_twitter_timeline_tweet_background')) {
      		$this->data['ep_twitter_timeline_tweet_background'] = $this->config->get('ep_twitter_timeline_tweet_background');
		} else {
			$this->data['ep_twitter_timeline_tweet_background'] = 'ffffff';
		}
		
		if (isset($this->request->post['ep_twitter_timeline_tweet_color'])) {
			$this->data['ep_twitter_timeline_tweet_color'] = $this->request->post['ep_twitter_timeline_tweet_color'];
    	} else if ($this->config->get('ep_twitter_timeline_tweet_color')) {
      		$this->data['ep_twitter_timeline_tweet_color'] = $this->config->get('ep_twitter_timeline_tweet_color');
		} else {
			$this->data['ep_twitter_timeline_tweet_color'] = '000000';
		}
		
		if (isset($this->request->post['ep_twitter_timeline_tweet_links'])) {
			$this->data['ep_twitter_timeline_tweet_links'] = $this->request->post['ep_twitter_timeline_tweet_links'];
    	} else if ($this->config->get('ep_twitter_timeline_tweet_links')) {
      		$this->data['ep_twitter_timeline_tweet_links'] = $this->config->get('ep_twitter_timeline_tweet_links');
		} else {
			$this->data['ep_twitter_timeline_tweet_links'] = '07aeeb';
		}
		
		if (isset($this->request->post['ep_twitter_timeline_scrollbar'])) {
			$this->data['ep_twitter_timeline_scrollbar'] = $this->request->post['ep_twitter_timeline_scrollbar'];
		} else {
			$this->data['ep_twitter_timeline_scrollbar'] = $this->config->get('ep_twitter_timeline_scrollbar');
		}
		
		if (isset($this->request->post['ep_twitter_timeline_loop'])) {
			$this->data['ep_twitter_timeline_loop'] = $this->request->post['ep_twitter_timeline_loop'];
		} else {
			$this->data['ep_twitter_timeline_loop'] = $this->config->get('ep_twitter_timeline_loop');
		}
		
		if (isset($this->request->post['ep_twitter_timeline_live'])) {
			$this->data['ep_twitter_timeline_live'] = $this->request->post['ep_twitter_timeline_live'];
		} else {
			$this->data['ep_twitter_timeline_live'] = $this->config->get('ep_twitter_timeline_live');
		}

		$this->data['modules'] = array();
		
		if (isset($this->request->post['ep_twitter_timeline_module'])) {
			$this->data['modules'] = $this->request->post['ep_twitter_timeline_module'];
		} elseif ($this->config->get('ep_twitter_timeline_module')) { 
			$this->data['modules'] = $this->config->get('ep_twitter_timeline_module');
		}	
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->template = 'module/ep_twitter_timeline.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ep_twitter_timeline')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>