<?php
// Developer: Ekrem KAYA
// Website  : http://e-piksel.com

class ControllerProductOpenSearch extends Controller {
	public function index() {
		if ($this->request->server['HTTPS']) {
			$store_link = $this->config->get('config_ssl');
		} else {
			$store_link = $this->config->get('config_url');
		}

		$store_icon = $this->config->get('config_icon');

		$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
		$output .= '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">';

		$output .= '<Image height="16" width="16" type="image/x-icon">' . $store_link . 'image/' . $store_icon . '</Image>';

		$output .= '<ShortName>' . $this->config->get('config_name') . '</ShortName>';
		$output .= '<Description>' . $this->config->get('config_meta_description') . '</Description>';
		if ($this->config->get('config_meta_keyword')) {
			$output .= '<Tags>' . $this->config->get('config_meta_keyword') . '</Tags>';
		}

		$output .= '<Url type="text/html" method="get" template="' . $store_link . 'index.php?route=search/product&amp;search={searchTerms}" />';

		$output .= '<AdultContent>false</AdultContent>';
		$output .= '<Language>' . $this->language->get('code') . '</Language>';
		$output .= '<OutputEncoding>UTF-8</OutputEncoding>';
		$output .= '<InputEncoding>UTF-8</InputEncoding>';

		$output .= '</OpenSearchDescription>';

		$this->response->addHeader('Content-Type: application/xml');
		$this->response->setOutput($output);
	}
}