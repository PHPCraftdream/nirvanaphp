<?php

namespace PHPCraftdream\NirvanaPHP {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	abstract class App
		extends Framework
		implements FrameworkInterface {
		protected $appEnvDir = NULL;

		public function __construct(string $appEnvDir) {
			parent::__construct();

			if (!is_dir($appEnvDir)){
				throw new AppException("Directory not found: $appEnvDir");
			}

			$this->setAppEnvDir($appEnvDir);
		}

		protected function setAppEnvDir(string $appEnvDir) {
			$this->appEnvDir = $appEnvDir;
		}

		public function appEnvDir(): string {
			return $this->appEnvDir;
		}

		public function isApp(): bool {
			return true;
		}
	}
}