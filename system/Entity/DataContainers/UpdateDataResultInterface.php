<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	interface UpdateDataResultInterface extends CreateDataResultInterface {
		public function setUpdateData(array $data): UpdateDataResultInterface;

		public function getUpdateData(): array;
	}
}