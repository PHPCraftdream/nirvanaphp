<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	class UpdateDataResult extends CreateDataResult implements UpdateDataResultInterface {
		protected $updateData = [];

		public function setUpdateData(array $data): UpdateDataResultInterface {
			$this->updateData = $data;

			return $this;
		}

		public function getUpdateData(): array {
			return $this->updateData;
		}
	}
}