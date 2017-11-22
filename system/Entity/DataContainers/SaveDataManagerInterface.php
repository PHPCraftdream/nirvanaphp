<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {


	interface SaveDataManagerInterface {
		public function getRequestData(): ContainerInterface;

		public function getSaveData(): EditableContainerInterface;

		public function getDbData(): ContainerInterface;
	}
}