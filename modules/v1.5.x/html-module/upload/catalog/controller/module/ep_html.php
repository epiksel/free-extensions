<?php  
class ControllerModuleEPHtml extends Controller {
	protected function index($setting) {
		
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/html_module.css');
		
		$this->data['box_status'] = $setting['box_status'];
		
    	$this->data['heading'] = html_entity_decode($setting['heading'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
    	$this->data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ep_html.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ep_html.tpl';
		} else {
			$this->template = 'default/template/module/ep_html.tpl';
		}
		
		$this->render();
	}
}
?>