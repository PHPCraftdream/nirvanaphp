<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;

	trait CreateTrait {
		use MethodsTrait;

		protected function insert(array $data, callable $queryCallback = NULL): int {
			$insertData = $this->clearDataFields($data);
			$insertQuery = $this->newInsert();
			$insertQuery->cols($insertData);

			$queryEx = $this->getQueryEx();

			if (is_callable($queryCallback)) {
				$queryCallback($insertQuery, $this);
			}

			$id = $queryEx->exInsert($insertQuery);

			return $id;
		}

		protected function processCreateData(SaveDataManagerInterface $saveDataManager) {
			$this->onCreate($saveDataManager);
			$this->onSave($saveDataManager);
			$this->processCreateDataRules($saveDataManager);
		}

		public function create(array $data, callable $queryCallback = NULL): CreateDataResultInterface {
			$result = $this->newCreateDataResult();
			$saveDataManager = $this->newDataManager($data, $data, []);
			$saveDataManager->setResult($result);

			$this->processCreateData($saveDataManager);

			if ($result->hasError()) {
				return $result;
			}

			$data = $saveDataManager->getSaveData()->getArray();
			$insertData = $this->clearDataFields($data);

			$insertQuery = $this->newInsert();
			$insertQuery->cols($insertData);

			$queryEx = $this->getQueryEx();

			if (is_callable($queryCallback)) {
				$queryCallback($insertQuery, $this);
			}

			$id = $queryEx->exInsert($insertQuery);
			$result->setResult($id);

			return $result;
		}
	}
}