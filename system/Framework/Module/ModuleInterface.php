<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Module {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	interface ModuleInterface {
		public function getApp(): FrameworkInterface;

		public function moduleInit();

		public function registerRoutes();

		public function registerConsoleCommands();

		public function subscribeEvents();
	}
}