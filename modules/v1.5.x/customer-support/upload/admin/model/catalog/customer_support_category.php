<?php
class ModelCatalogCustomerSupportCategory extends Model {
	public function addCategory($data) {
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "customer_support_category 
			SET 
				  parent_id = '" . (int)$data['parent_id'] . "'
				, sort_order = '" . (int)$data['sort_order'] . "'
				, status = '" . (int)$data['status'] . "'
				, date_modified = NOW()
				, date_added = NOW()
		");
	
		$category_id = $this->db->getLastId();
		
		
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "customer_support_category_description 
				SET 
					  category_id = '" . (int)$category_id . "'
					, language_id = '" . (int)$language_id . "'
					, name = '" . $this->db->escape($value['name']) . "'
			");
		}
		
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_support_category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->cache->delete('customer_category_category');
		
	}
	
	public function editCategory($category_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer_support_category 
			SET 
				  parent_id = '" . (int)$data['parent_id'] . "'
				, sort_order = '" . (int)$data['sort_order'] . "'
				, status = '" . (int)$data['status'] . "'
				, date_modified = NOW() 
			WHERE 
				category_id = '" . (int)$category_id . "'
		");
		
		$this->db->query("
			DELETE	FROM " . DB_PREFIX . "customer_support_category_description 
			WHERE category_id = '" . (int)$category_id . "'
		");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "customer_support_category_description 
				SET 
					category_id = '" . (int)$category_id . "'
					, language_id = '" . (int)$language_id . "'
					, name = '" . $this->db->escape($value['name']) . "'
			");
		}
		
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_support_category_to_store WHERE category_id = '" . (int)$category_id . "'");
		
		if (isset($data['category_store'])) {		
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_support_category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->cache->delete('customer_support_category');
	}
	
	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_support_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_support_category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_support_category_to_store WHERE category_id = '" . (int)$category_id . "'");
		
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "customer_support_category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}
		
		$this->cache->delete('customer_support_category');
	} 

	public function getCategory($category_id) {
		$query = $this->db->query("
			SELECT DISTINCT 
				  *
			FROM " . DB_PREFIX . "customer_support_category 
			WHERE 
				category_id = '" . (int)$category_id . "'
		");
		
		return $query->row;
	} 
	
	public function getCategories($parent_id) {
		//$category_data = $this->cache->get('customer_support_category.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		//if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("
				SELECT 
					* 
				FROM " . DB_PREFIX . "customer_support_category c 
				LEFT JOIN " . DB_PREFIX . "customer_support_category_description cd ON 
					(c.category_id = cd.category_id) 
				WHERE 
					c.parent_id = '" . (int)$parent_id . "' AND 
					cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				ORDER BY c.sort_order, cd.name ASC
			");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
			}	
	
			//$this->cache->set('customer_support_category.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		//}
		
		return $category_data;
	}
	
	public function getPath($category_id) {
		$query = $this->db->query("
			SELECT 
				name
				, parent_id 
			FROM " . DB_PREFIX . "customer_support_category c 
			LEFT JOIN " . DB_PREFIX . "customer_support_category_description cd 
				ON (c.category_id = cd.category_id) 
			WHERE 
				c.category_id = '" . (int)$category_id . "' 
				AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			ORDER BY c.sort_order, cd.name ASC
		");
		
		$category_info = $query->row;
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_support_category_description WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		
		return $category_description_data;
	}	

	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_support_category");
		
		return $query->row['total'];
	}	

	public function getCategoryStores($category_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_support_category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}
}
?>