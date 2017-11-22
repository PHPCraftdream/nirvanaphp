<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Framework\Module\ModuleManager as MM;
	use PHPCraftdream\NirvanaPHP\Framework\Module\ModuleManagerInterface;

	trait ModuleManager {
		use FrameworkTrait;

		protected $moduleManager;

		public function getModuleManager(): ModuleManagerInterface {
			if (empty($this->moduleManager)) {
				$this->moduleManager = new MM($this->getThis());
			}

			return $this->moduleManager;
		}
	}
}