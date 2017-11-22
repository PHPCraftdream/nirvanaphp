<?php

namespace PHPCraftdream\NirvanaPHP\Tools {
	interface ConfigRuntimeInterface extends ConfigInterface {
		public function set(string $name, $val);

		public function applyNewData(array $newData);

		public function setData(array $data);
	}
}