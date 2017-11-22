<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	class ConfigRuntime implements ConfigRuntimeInterface {
		protected $data = [];

		public function __set($name, $val) {
			throw new ConfigException("__set is not allowed");
		}

		public function __get($name) {
			throw new ConfigException("__get is not allowed");
		}

		//===================================================================================

		public function __construct() {

		}

		public function share(array $arr) {
			throw new ConfigException("share is not allowed");
		}

		public function get(string $name, $default = NULL) {
			$exists = array_key_exists($name, $this->data);

			if ($exists) {
				return $this->data[$name];
			}

			$this->data[$name] = $default;

			return $default;
		}

		public function all() {
			return $this->data;
		}

		//===================================================================================

		public function set(string $name, $val) {
			$this->data[$name] = $val;
		}

		public function applyNewData(array $newData) {
			foreach ($newData as $k => $v) {
				$this->data[$k] = $v;
			}
		}

		public function setData(array $data) {
			$this->data = $data;
		}
	}
}