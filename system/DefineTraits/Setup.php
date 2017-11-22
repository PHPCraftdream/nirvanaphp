<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Framework\Setup as FrameworkSetup;
	use PHPCraftdream\NirvanaPHP\Framework\SetupInterface;

	trait Setup {
		use FrameworkTrait;

		protected $setup;

		public function getSetup(): SetupInterface {
			if (!empty($this->setup)) {
				return $this->setup;
			}

			$setup = new FrameworkSetup($this->getThis());
			$this->setup = $setup;

			return $setup;
		}
	}
}