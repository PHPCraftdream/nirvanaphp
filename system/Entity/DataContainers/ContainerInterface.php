<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	use JsonSerializable;

	interface ContainerInterface extends JsonSerializable {
		public function exists(string $name): bool;

		public function isEmpty(string $name): bool;

		public function get(string $name, $default = NULL);

		public function getAsIs();

		public function getObj();

		public function getArray(): array;
	}
}