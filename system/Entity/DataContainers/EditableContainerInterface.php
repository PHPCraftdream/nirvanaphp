<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	interface EditableContainerInterface extends ContainerInterface {
		public function set(string $name, $value = NULL): EditableContainerInterface;

		public function delete(string $name): EditableContainerInterface;
	}
}