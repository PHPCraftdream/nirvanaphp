<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Bridges\ConsoleApplication\ConsoleApplication;
	use PHPCraftdream\NirvanaPHP\Bridges\ConsoleApplication\ConsoleApplicationInterface;

	trait Console {
		protected $console;

		public function getConsole(): ConsoleApplicationInterface {
			if (empty($this->console)) {
				$this->console = new ConsoleApplication();
			}

			return $this->console;
		}
	}
}