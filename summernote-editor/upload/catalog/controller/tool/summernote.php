<?php
class ControllerToolSummernote extends Controller {
	public function index() {
		$settings = $this->config->get('epiksel_summernote_setting');

		if ($settings['status'] && $settings['prettify_status']) {
			if ($settings['prettify_theme']) {
				$this->document->addStyle('epiksel/summernote-editor/javascript/prettify/theme/' . $settings['prettify_theme'] . '.css');
			} else {
				$this->document->addStyle('epiksel/summernote-editor/javascript/prettify/theme/prettify.css');
			}

			$this->document->addScript('epiksel/summernote-editor/javascript/prettify/prettify.js');
		}
	}
}