<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Module
{

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	abstract class Module implements ModuleInterface
	{
		protected $app;
		protected $name;

		public function __construct(FrameworkInterface $app, string $name)
		{
			$this->app = $app;
			$this->name = $name;
		}

		public function getApp(): FrameworkInterface
		{
			return $this->app;
		}

		public function getName(): string
		{
			return $this->name;
		}

		abstract public function moduleInit();
		abstract public function registerRoutes();
		abstract public function registerConsoleCommands();
		abstract public function subscribeEvents();
	}
}