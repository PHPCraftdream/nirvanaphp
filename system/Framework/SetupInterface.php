<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use PHPCraftdream\NirvanaPHP\Tools\SetupParentInterface;

	interface SetupInterface extends SetupParentInterface {
		public function install(string $appDir, string $appPublicDir, string $namespace = NULL);
	}
}