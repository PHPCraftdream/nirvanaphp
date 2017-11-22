<?php

namespace PHPCraftdream\NirvanaPHP\Session {

	use PHPCraftdream\NirvanaPHP\Framework\Events;
	use PHPCraftdream\NirvanaPHP\Framework\Module\Module;
	use PHPCraftdream\NirvanaPHP\Framework\Module\ModuleInterface;

	class SessionModule extends Module implements ModuleInterface {
		public function moduleInit() {
			$app = $this->getApp();
			$entityFactory = $app->getFactoryForEntity();

			$app->getEntityHub()->define('session', function () use ($entityFactory) {
				return new Session($entityFactory);
			});

			$app->getEntityHub()->define('sessionData', function () use ($entityFactory) {
				return new SessionData($entityFactory);
			});
		}

		public function registerRoutes() {

		}

		public function registerConsoleCommands() {

		}

		public function subscribeEvents() {
			$app = $this->getApp();
			$sessionModule = $app->getSession();
			$events = $app->getEventsSystem();

			$events->addListener(Events::BEFORE_ROUTE, function () use ($sessionModule) {
				$sessionModule->start();

				//$sessionModule->setValue('asdfasdf', time());
			});
		}
	}
}
