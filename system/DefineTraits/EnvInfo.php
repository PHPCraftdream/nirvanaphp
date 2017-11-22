<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Tools\EnvInfo as ToolsEnvInfo;
	use PHPCraftdream\NirvanaPHP\Tools\EnvInfoInterface;

	trait EnvInfo {
		protected $toolsEnvInfo;

		public function getEnvInfo(): EnvInfoInterface {
			if (empty($this->toolsEnvInfo)) {
				$this->toolsEnvInfo = new ToolsEnvInfo($_SERVER);
			}

			return $this->toolsEnvInfo;
		}
	}
}