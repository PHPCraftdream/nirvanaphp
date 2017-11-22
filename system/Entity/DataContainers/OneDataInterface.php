<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	interface OneDataInterface extends IterateInterface {
		public function getKeyName(): string;

		public function getName(): string;

		public function setObj(EditableContainerInterface $obj): OneDataInterface;

		public function obj(): EditableContainerInterface;

		public function exists(): bool;
	}
}