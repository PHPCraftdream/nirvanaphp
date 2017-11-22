<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	class Config implements ConfigInterface {
		protected $data = [];
		protected $dirs = [];
		protected $share = [];
		protected $file = NULL;

		public function __set($name, $val) {
			throw new ConfigException("__set is not allowed");
		}

		public function __get($name) {
			throw new ConfigException("__get is not allowed");
		}

		//===================================================================================

		public function __construct(string $file, array $dirs) {
			$this->file = $file;
			$this->dirs = $dirs;
		}

		public function share(array $arr) {
			if (empty($arr)) {
				return;
			}

			foreach ($arr as $key => $value) {
				$this->share[$key] = $value;
			}
		}

		public function get(string $name, $default = NULL) {
			$this->readOnce();

			$exists = array_key_exists($name, $this->data);

			if ($exists) {
				return $this->data[$name];
			}

			$this->data[$name] = $default;

			return $default;
		}

		public function all() {
			$this->readOnce();

			return $this->data;
		}

		//===================================================================================
		protected $readDone = false;

		protected function readOnce() {
			if (!empty($this->readDone)) {
				return;
			}

			$this->readDone = true;
			$this->reRead($this->file);
		}

		protected function reRead($file) {
			$loaded = false;

			foreach ($this->dirs as $dir) {
				$loaded = $this->readFile($dir, $file) | $loaded;
			}

			if (!$loaded) {
				throw new ConfigException("Config not found: $file");
			}
		}

		protected function getDataFromInclude($fileFullPath, array $data) {
			$share = $this->share;
			extract($share, EXTR_PREFIX_SAME, 'extract_');

			$newData = include $fileFullPath;

			return $newData;
		}

		protected function applyNewData(array $newData) {
			foreach ($newData as $k => $v) {
				$this->data[$k] = $v;
			}
		}

		protected $ext = '.php';

		protected function readFile($dir, $file) {
			$fileFullPath = $dir . $file . $this->ext;

			if (!is_file($fileFullPath)) {
				return false;
			}

			$newData = $this->getDataFromInclude($fileFullPath, $this->data);

			if (is_array($newData)) {
				$this->data = $newData;
			}

			return true;
		}
	}
}