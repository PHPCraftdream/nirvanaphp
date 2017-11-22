<?php

namespace PHPCraftdream\NirvanaPHP\Tools {
	interface ConfigInterface {
		public function share(array $arr);

		public function get(string $name, $default = NULL);

		public function all();
	}
}