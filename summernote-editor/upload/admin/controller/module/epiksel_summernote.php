<?php
// Developer : Ekrem KAYA
// Website   : http://e-piksel.com
// Version   : v1.0.1

define('EPMOD40_VERSION', "1.0.1");
define('OC_VERSION', "2.0.1");
define('EXTENSION_URL', "//weblenti.com/opencart-summernote-editor-full-toolbar-s1-p49");

class ControllerModuleEpikselSummernote extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/epiksel_summernote');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		$this->load->model('module/epiksel_summernote');

		if (!$this->config->get('epiksel_summernote_version')) {
			$this->response->redirect($this->url->link('module/epiksel_summernote/install', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('epiksel_summernote', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_theme_demo'] = $this->language->get('text_theme_demo');

		$data['entry_editor_lang'] = $this->language->get('entry_editor_lang');
		$data['entry_editor_direction'] = $this->language->get('entry_editor_direction');
		$data['entry_editor_height'] = $this->language->get('entry_editor_height');
		$data['entry_codemirror_status'] = $this->language->get('entry_codemirror_status');
		$data['entry_codemirror_theme'] = $this->language->get('entry_codemirror_theme');
		$data['entry_prettify_status'] = $this->language->get('entry_prettify_status');
		$data['entry_prettify_theme'] = $this->language->get('entry_prettify_theme');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_editor_lang'] = $this->language->get('help_editor_lang');
		$data['help_editor_direction'] = $this->language->get('help_editor_direction');
		$data['help_prettify_status'] = $this->language->get('help_prettify_status');

		$data['button_back_list'] = $this->language->get('button_back_list');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		/* About Tab Begin */
		$data['text_extension_name'] = $this->language->get('text_extension_name');
		$data['extension_name'] = $this->language->get('entry_extension_name');

		$data['text_extension_version'] = $this->language->get('text_extension_version');
		if ($this->config->get('epiksel_summernote_version')) {
			$data['extension_version'] = $this->config->get('epiksel_summernote_version');
		} else {
			$data['extension_version'] = EPMOD40_VERSION;
		}

		$data['text_extension_url'] = $this->language->get('text_extension_url');
		$data['extension_url'] = EXTENSION_URL;

		$data['text_extension_compat'] = $this->language->get('text_extension_compat');
		$data['extension_compat'] = sprintf($this->language->get('entry_extension_compat'), OC_VERSION);

		$data['text_extension_contact'] = $this->language->get('text_extension_contact');
		$data['extension_contact'] = $this->language->get('entry_extension_contact');

		$data['text_extension_copyright'] = $this->language->get('text_extension_copyright');
		$data['extension_copyright'] = $this->language->get('entry_extension_copyright');

		$data['update_version_check'] = $this->config->get('epiksel_summernote_version') < EPMOD40_VERSION;
		$data['button_update'] = $this->language->get('button_update');
		$data['update'] = $this->url->link('module/epiksel_summernote/update', 'token=' . $this->session->data['token'], 'SSL');

		$data['text_extension_uninstall'] = $this->language->get('text_extension_uninstall');
		$data['button_uninstall'] = $this->language->get('button_uninstall');
		$data['uninstall'] = $this->url->link('module/epiksel_summernote/uninstall', 'token=' . $this->session->data['token'], 'SSL');

		$data['tab_about'] = $this->language->get('tab_about');
		/* About Tab End */

		$errors = array('warning');

		foreach ($errors as $error) {
			if (isset($this->error[$error])) {
				$data['error_' . $error] = $this->error[$error];
			} else {
				$data['error_' . $error] = array();
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/epiksel_summernote', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (isset($this->session->data['error_warning'])) {
			$data['error_warning'] = $this->session->data['error_warning'];

			unset($this->session->data['error_warning']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['action'] = $this->url->link('module/epiksel_summernote', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['epiksel_summernote_setting'])) {
			$data['settings'] = $this->request->post['epiksel_summernote_setting'];
		} elseif ($this->config->get('epiksel_summernote_setting')) { 
			$data['settings'] = $this->config->get('epiksel_summernote_setting');
		} else {
			$data['settings'] = array(
				'editor_lang'       => false,
				'editor_direction'  => false,
				'editor_height'     => 400,
				'codemirror_status' => false,
				'codemirror_theme'  => false,
				'prettify_status'   => false,
				'prettify_theme'    => false,
				'status'            => true
			);
		}

		$data['editor_langs'] = array();

		$editor_langs = glob(DIR_APPLICATION . '../epiksel/summernote-editor/javascript/summernote/lang/*.js');

		if ($editor_langs) {
			foreach ($editor_langs as $editor_lang) {
				$data['editor_langs'][] = utf8_substr(basename($editor_lang, '.js'), 11, 11);
			}
		}

		$data['codemirror_themes'] = array();

		$codemirror_themes = glob(DIR_APPLICATION . '../epiksel/summernote-editor/javascript/codemirror/theme/*.css');

		if ($codemirror_themes) {
			foreach ($codemirror_themes as $codemirror_theme) {
				$data['codemirror_themes'][] = basename($codemirror_theme, '.css');
			}
		}

		$data['prettify_themes'] = array();

		$prettify_themes = glob(DIR_APPLICATION . '../epiksel/summernote-editor/javascript/prettify/theme/*.css');

		if ($prettify_themes) {
			foreach ($prettify_themes as $prettify_theme) {
				$data['prettify_themes'][] = basename($prettify_theme, '.css');
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/epiksel_summernote.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/epiksel_summernote')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//$settings = $this->request->post['epiksel_summernote_setting'];

		//if (isset($settings)) {
		//}

		return !$this->error;
	}

	public function install() {
		$this->load->model('module/epiksel_summernote');

		if (!$this->user->hasPermission('modify', 'module/epiksel_summernote')) {
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			if (!$this->config->get('epiksel_summernote_version')) {
				$this->model_module_epiksel_summernote->install();
				$this->clearVqmod();

				$this->response->redirect($this->url->link('module/epiksel_summernote', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
	}

	public function update() {
		$this->load->model('module/epiksel_summernote');

		if (!$this->user->hasPermission('modify', 'module/epiksel_summernote')) {
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			if ($this->config->get('epiksel_summernote_version')) {
				$this->model_module_epiksel_summernote->update();
				$this->clearVqmod();

				$this->response->redirect($this->url->link('module/epiksel_summernote', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
	}

	public function uninstall() {
		$this->load->model('module/epiksel_summernote');

		if (!$this->user->hasPermission('modify', 'module/epiksel_summernote')) {
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			if ($this->config->get('epiksel_summernote_version')) {
				$this->model_module_epiksel_summernote->uninstall();
				$this->clearVqmod(true);

				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
	}

	protected function clearVqmod($uninstall = false) {
		if ($uninstall) {
			if (is_file(DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml')) {
				rename(DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml', DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml_');
			}
		} else {
			if (is_file(DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml_')) {
				rename(DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml_', DIR_CATALOG.'../vqmod/xml/epiksel-summernote.xml');
			}
		}

		$dirSysCache = DIR_CACHE;
		foreach(glob($dirSysCache.'*.*') as $fileSysCache){ 
			if ($fileSysCache != DIR_CACHE . 'index.html') { unlink($fileSysCache); }
		}
		
		$dirCache = DIR_CATALOG.'../vqmod/vqcache/';
		foreach(glob($dirCache.'*.*') as $fileCache){ unlink($fileCache); }
	}
}