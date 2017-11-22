<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class Container implements ContainerInterface {
		protected $data = NULL;
		protected $keyName = NULL;

		public function __construct($data) {
			$this->assertArrayOrObject($data);
			$this->data = $data;
		}

		public function jsonSerialize() {
			return $this->data;
		}

		protected function assertArrayOrObject($data) {
			if (is_array($data)) {
				return;
			}

			if (is_object($data)) {
				return;
			}

			throw new ContainerException('Not array and not object.');
		}

		public function exists(string $name): bool {
			$data = $this->data;

			if (is_array($data)) {
				return array_key_exists($name, $data);
			}

			if (is_object($data)) {
				return property_exists($data, $name);
			}

			throw new ContainerException('Wtf? #0');
		}

		public function isEmpty(string $name): bool {
			$data = $this->data;

			if (is_array($data)) {
				return empty($data[$name]);
			}

			if (is_object($data)) {
				return empty($data->{$name});
			}

			throw new ContainerException('Wtf? #1');
		}

		public function get(string $name, $default = NULL) {
			$data = $this->data;

			if (is_array($data)) {
				return array_key_exists($name, $data) ? $data[$name] : $default;
			}

			if (is_object($data)) {
				return property_exists($data, $name) ? $data->{$name} : $default;
			}

			throw new ContainerException('Wtf? #2');
		}

		public function getAsIs() {
			return $this->data;
		}

		public function getObj() {
			return (object)$this->data;
		}

		public function getArray(): array {
			return (array)$this->data;
		}
	}
}