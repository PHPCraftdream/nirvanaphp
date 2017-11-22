<?php

namespace PHPCraftdream\NirvanaPHP {

	use PHPCraftdream\NirvanaPHP\Framework\AbstractFramework;
	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;
	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;

	class Framework
		extends AbstractFramework
		implements FrameworkInterface {
		//=========================================================================
		public function appDir(): string {
			throw new Framework\FrameworkException("appDir method is only for application.");
		}

		public function appEnvDir(): string {
			throw new Framework\FrameworkException("appEnvDir method is only for application.");
		}

		public function appNamespace(): string {
			throw new Framework\FrameworkException("appNamespace method is only for application.");
		}

		public function notFound(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
			throw new Framework\FrameworkException("notFound method is only for application.");
		}

		public function isApp(): bool {
			return false;
		}

		//=========================================================================
		public function frameworkNamespace(): string {
			return FRAMEWORK_NAMESPACE;
		}

		public function frameworkDir(): string {
			return FRAMEWORK_DIR;
		}

		//=========================================================================
		protected function defineFrameworkModules() {
			$this->getModuleManager()->define('FrameworkInit',
				function (FrameworkInterface $app) {
					return new FrameworkInit($app, 'FrameworkInit');
				}
			);

			$this->getModuleManager()->define('Session',
				function (FrameworkInterface $app) {
					return new Session\SessionModule($app, 'Session');
				}
			);
		}

		protected function defineAppModules() {
			throw new Framework\FrameworkException("defineAppModules method is only for application.");
		}
	}
}