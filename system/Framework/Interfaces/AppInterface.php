<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use PHPCraftdream\NirvanaPHP\Tools\EnvInfoInterface;

	interface AppInterface {
		public function getEnvInfo(): EnvInfoInterface;

		public function isApp(): bool;

		public function initConsole();

		public function initAppCore();

		public function run();
	}
}