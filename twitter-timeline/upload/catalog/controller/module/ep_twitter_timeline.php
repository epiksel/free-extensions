<?php  
class ControllerModuleEPTwitterTimeline extends Controller {
	protected function index($setting) {
		$this->language->load('module/ep_twitter_timeline');
		
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/tt_module.css');
		
    	$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
    	
		$this->data['twitter_username'] = $this->config->get('ep_twitter_timeline_username');
		$this->data['tweet_count'] = $this->config->get('ep_twitter_timeline_tweet_count');
		$this->data['widget_width'] = $this->config->get('ep_twitter_timeline_width');
		$this->data['widget_height'] = $this->config->get('ep_twitter_timeline_height');
		$this->data['shell_background'] = $this->config->get('ep_twitter_timeline_shell_background');
		$this->data['shell_color'] = $this->config->get('ep_twitter_timeline_shell_color');
		$this->data['tweet_background'] = $this->config->get('ep_twitter_timeline_tweet_background');
		$this->data['tweet_color'] = $this->config->get('ep_twitter_timeline_tweet_color');
		$this->data['tweet_links'] = $this->config->get('ep_twitter_timeline_tweet_links');
		$this->data['scrollbar'] = $this->config->get('ep_twitter_timeline_scrollbar');
		$this->data['loop'] = $this->config->get('ep_twitter_timeline_loop');
		$this->data['live'] = $this->config->get('ep_twitter_timeline_live');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ep_twitter_timeline.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ep_twitter_timeline.tpl';
		} else {
			$this->template = 'default/template/module/ep_twitter_timeline.tpl';
		}
		
		$this->render();
	}
}
?>