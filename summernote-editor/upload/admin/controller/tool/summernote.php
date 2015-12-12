<?php
class ControllerToolSummernote extends Controller {
	public function index() {
		$settings = $this->config->get('epiksel_summernote_setting');

		if ($settings['status']) {
			// Summernote Custom Language Button
			if ($settings['editor_lang']) {
				$this->document->addScript('../epiksel/summernote-editor/javascript/summernote/lang/summernote-' . $settings['editor_lang'] . '.js');
			}

			// Video Plugin
			$this->document->addScript('../epiksel/summernote-editor/javascript/summernote/plugin/summernote-ext-video.js');
			// Summernote Highlight Plugin Button
			if ($settings['prettify_status']) {
				$this->document->addScript('../epiksel/summernote-editor/javascript/summernote/plugin/summernote-ext-highlight.js');
			}
		}
	}
}