<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use Whoops\Handler\HandlerInterface;
	use Whoops\Handler\JsonResponseHandler;
	use Whoops\Handler\PlainTextHandler;
	use Whoops\Handler\PrettyPageHandler;
	use Whoops\Run;
	use Whoops\RunInterface;

	trait Whoops {
		use FrameworkTrait;

		protected $whoopsHandler;

		public function getWhoopsHandler(): HandlerInterface {
			if (!empty($this->whoopsHandler)) {
				return $this->whoopsHandler;
			}

			$envInfo = $this->getThis()->getEnvInfo();

			if ($envInfo->isConsole()) {
				$this->whoopsHandler = new PlainTextHandler();

				return $this->whoopsHandler;
			}

			if ($envInfo->isAjax()) {
				$this->whoopsHandler = new JsonResponseHandler();

				return $this->whoopsHandler;
			}

			$this->whoopsHandler = new PrettyPageHandler();

			return $this->whoopsHandler;
		}

		protected $whoops;

		public function getWhoops(): RunInterface {
			if (!empty($this->whoops)) {
				return $this->whoops;
			}

			$whoops = new Run();

			$handler = $this->getWhoopsHandler();
			$whoops->pushHandler($handler);
			$whoops->register();

			$this->whoops = $whoops;

			return $whoops;
		}
	}
}