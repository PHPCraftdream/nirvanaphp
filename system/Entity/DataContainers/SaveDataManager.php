<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class SaveDataManager implements SaveDataManagerInterface {
		protected $requestData;
		protected $saveData;
		protected $dbData;

		protected $currentFieldName = '';
		protected $currentArgs = [];

		protected $entity;
		protected $result;

		public function __construct(array $requestData, array $saveData, array $dbData) {
			$this->setRequestData($requestData);
			$this->setSaveData($saveData);
			$this->setDbData($dbData);
		}

		public function getRequestData(): ContainerInterface {
			return $this->requestData;
		}

		public function getSaveData(): EditableContainerInterface {
			return $this->saveData;
		}

		public function getDbData(): ContainerInterface {
			return $this->dbData;
		}

		//------------------------------------------------------------------------

		protected function setSaveData(array $data) {
			$saveData = $this->newSaveContainer($data);
			$this->saveData = $saveData;
		}

		protected function setRequestData(array $data) {
			$requestData = $this->newDataContainer($data);
			$this->requestData = $requestData;
		}

		protected function setDbData(array $data) {
			$dbData = $this->newDataContainer($data);
			$this->dbData = $dbData;
		}

		//------------------------------------------------------------------------

		protected function newDataContainer(array $data): ContainerInterface {
			return new Container($data);
		}

		protected function newSaveContainer(array $data): EditableContainerInterface {
			return new EditableContainer($data);
		}
	}
}