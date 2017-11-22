<?php

namespace PHPCraftdream\NirvanaPHP {

	use PHPCraftdream\NirvanaPHP\Framework\Commands\{
		BuildTables, Event, InstallApp, Publish, Serve
	};
	use PHPCraftdream\NirvanaPHP\Framework\Module\Module;
	use PHPCraftdream\NirvanaPHP\Framework\Module\ModuleInterface;

	class FrameworkInit extends Module implements ModuleInterface {
		public function moduleInit() {
			gc_disable();
		}

		public function registerRoutes() {

		}

		public function registerConsoleCommands() {
			$app = $this->getApp();
			$console = $app->getConsole();

			$console->add(new InstallApp($app));
			$console->add(new Event($app));

			if ($app->isApp()) {
				$console->add(new Serve($app));
				$console->add(new Publish($app));
				$console->add(new BuildTables($app));
			}
		}

		public function subscribeEvents() {

		}
	}
}