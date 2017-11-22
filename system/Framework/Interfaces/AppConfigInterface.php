<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use PHPCraftdream\NirvanaPHP\Tools\ConfigInterface;

	interface AppConfigInterface {
		public function appConfigDb(): ConfigInterface;

		public function appConfigEnv(): ConfigInterface;

		public function appGetConfigByName(string $name): ConfigInterface;
	}
}