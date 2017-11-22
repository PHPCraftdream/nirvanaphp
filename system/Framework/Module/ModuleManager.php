<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Module {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	class ModuleManager implements ModuleManagerInterface {
		protected $app;
		protected $list = [];

		public function __construct(FrameworkInterface $app) {
			$this->app = $app;
		}

		public function getApp(): FrameworkInterface {
			return $this->app;
		}

		public function define(string $name, callable $factory): ModuleManagerInterface {
			if (!empty($this->list[$name])) {
				throw new ModuleException("Module is already defined: $name");
			}

			$this->list[$name] = (object)[
				'name' => $name,
				'factory' => $factory,
				'obj' => NULL,
			];

			return $this;
		}

		public function exists(string $name): bool {
			return array_key_exists($name, $this->list);
		}

		public function get(string $name): ModuleInterface {
			if (empty($this->list[$name])) {
				throw new ModuleException("Module is not defined: $name");
			}

			$data = $this->list[$name];

			if (empty($data->obj)) {
				$factory = $data->factory;
				$data->obj = $factory($this->getApp(), $name);
			}

			return $data->obj;
		}

		public function moduleInit() {
			foreach ($this->iterate() as $module) {
				$m = $this->assertModuleInterface($module);
				$m->moduleInit();
			}
		}

		public function registerRoutes() {
			foreach ($this->iterate() as $module) {
				$m = $this->assertModuleInterface($module);
				$m->registerRoutes();
			}
		}

		public function subscribeEvents() {
			foreach ($this->iterate() as $module) {
				$m = $this->assertModuleInterface($module);
				$m->subscribeEvents();
			}
		}

		public function registerConsoleCommands() {
			foreach ($this->iterate() as $module) {
				$m = $this->assertModuleInterface($module);
				$m->registerConsoleCommands();
			}
		}

		protected function assertModuleInterface(ModuleInterface $module): ModuleInterface {
			return $module;
		}

		protected function iterate() {
			$modules = array_keys($this->list);

			foreach ($modules as $name) {
				yield $this->get($name);
			}
		}
	}
}