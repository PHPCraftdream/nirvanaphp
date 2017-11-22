<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	use JsonSerializable;

	interface IterateInterface extends JsonSerializable, ForeignContainerInterface {
		public function jsonSerialize();

		public function iterate();

		public function getData(): array;
	}
}