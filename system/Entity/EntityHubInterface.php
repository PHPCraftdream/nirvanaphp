<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	interface EntityHubInterface {
		public function getApp(): FrameworkInterface;

		public function get(string $name): EntityInterface;

		public function define(string $name, callable $factory): EntityHubInterface;

		public function exists(string $name): bool;

		public function iterate(callable $callback);
	}
}