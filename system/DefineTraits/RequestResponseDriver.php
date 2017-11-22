<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Framework\RequestResponseDriver as RequestResponseDriverBridge;
	use PHPCraftdream\NirvanaPHP\Framework\RequestResponseDriverInterface;

	trait RequestResponseDriver {
		use FrameworkTrait;

		protected $requestResponseDriver;

		public function getRequestResponseDriver(): RequestResponseDriverInterface {
			if (!empty($this->requestResponseDriver)) {
				return $this->requestResponseDriver;
			}

			$requestResponseDriver = new RequestResponseDriverBridge($this->getThis());
			return $requestResponseDriver;
		}
	}
}