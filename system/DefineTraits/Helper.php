<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Tools\Helper as ToolsHelper;
	use PHPCraftdream\NirvanaPHP\Tools\HelperInterface;

	trait Helper {
		protected $helper;

		public function getHelper(): HelperInterface {
			if (empty($this->helper)) {
				$this->helper = new ToolsHelper();
			}

			return $this->helper;
		}
	}
}