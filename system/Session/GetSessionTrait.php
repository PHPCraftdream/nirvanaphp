<?php

namespace PHPCraftdream\NirvanaPHP\Session {

	use PHPCraftdream\NirvanaPHP\DefineTraits\FrameworkTrait;

	trait GetSessionTrait {
		use FrameworkTrait;

		protected $sessionManager;

		public function getSession(): SessionManagerInterface {
			if (empty($this->sessionManager)) {
				$app = $this->getThis();

				$this->sessionManager = new SessionManager(
					$app->getEntityHub(),
					$app->getCookies()
				);
			}

			return $this->sessionManager;
		}
	}
}
