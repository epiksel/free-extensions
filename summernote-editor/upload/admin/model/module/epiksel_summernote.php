<?php
/* Developer: Ekrem KAYA
Web Page: www.e-piksel.com */

class ModelModuleEpikselSummernote extends Model {
	public function install() {
		/* Update Version */
		$this->getUpdateVersion(true);
		/* Default Settings */
		$this->getDefaultSettings();
	}

	public function update() {
		/* Update Version */
		$this->getUpdateVersion(true);
		//$this->getDefaultSettings();
	}

	public function uninstall() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('epiksel_summernote');

		$this->load->model('extension/extension');
		$this->model_extension_extension->uninstall('module', 'epiksel_summernote');
	}

	protected function getUpdateVersion($update = false) {
		/* Update Version */
		if ($update && $this->config->get('epiksel_summernote_version')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = '" . EPMOD40_VERSION . "' WHERE `key` = 'epiksel_summernote_version'");
		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
			('', '0', 'epiksel_summernote', 'epiksel_summernote_version', '" . EPMOD40_VERSION . "', '0');");
		}
	}

	protected function getDefaultSettings() {
		/* Default Setting */
		if (version_compare(VERSION, '2.1.0.0', '<') == true) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
			('', '0', 'epiksel_summernote', 'epiksel_summernote_setting', 'a:8:{s:11:\"editor_lang\";s:1:\"0\";s:16:\"editor_direction\";s:1:\"0\";s:13:\"editor_height\";s:3:\"400\";s:17:\"codemirror_status\";s:1:\"1\";s:16:\"codemirror_theme\";s:7:\"monokai\";s:15:\"prettify_status\";s:1:\"1\";s:14:\"prettify_theme\";s:6:\"github\";s:6:\"status\";s:1:\"1\";}', '1');");
		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
			('', '0', 'epiksel_summernote', 'epiksel_summernote_setting', '{\"editor_lang\":\"0\",\"editor_direction\":\"0\",\"editor_height\":\"400\",\"codemirror_status\":\"1\",\"codemirror_theme\":\"monokai\",\"prettify_status\":\"1\",\"prettify_theme\":\"github\",\"status\":\"1\"}', '1');");
		}
	}
}