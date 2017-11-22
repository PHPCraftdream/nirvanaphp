<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Module {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	interface ModuleManagerInterface extends ModuleInterface {
		public function getApp(): FrameworkInterface;

		public function define(string $name, callable $factory): ModuleManagerInterface;

		public function exists(string $name): bool;

		public function get(string $name): ModuleInterface;
	}
}