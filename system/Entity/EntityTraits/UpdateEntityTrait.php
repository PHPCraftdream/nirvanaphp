<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\UpdateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;

	trait UpdateEntityTrait {
		use MethodsTrait;

		protected function updateNowById(array $updateData, $id): bool {
			$pk = $this->getPrimaryKey();

			$updateQuery = $this->newUpdate();
			$updateQuery->cols($updateData);
			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$updateQuery->where("`$pk` = ?", $id);

			$queryEx = $this->getQueryEx();
			$res = $queryEx->exUpdate($updateQuery);

			return $res;
		}

		protected function updateNowBy(array $updateData, callable $queryCallback): bool {
			$updateQuery = $this->newUpdate();
			$updateQuery->cols($updateData);

			$queryEx = $this->getQueryEx();

			$queryCallback($updateQuery);
			$res = $queryEx->exUpdate($updateQuery);

			return $res;
		}

		protected function processUpdateData(SaveDataManagerInterface $saveDataManager) {
			$this->onUpdate($saveDataManager);
			$this->onSave($saveDataManager);
			$this->processUpdateDataRules($saveDataManager);
		}

		public function updateById(array $data, $id): UpdateDataResultInterface {
			$result = $this->newUpdateDataResult();
			$dbData = $this->readById($id);

			if (!$dbData->exists()) {
				return $result->addCommonError('Entity.not_found',
					['key' => $this->getPrimaryKey(), 'value' => $id]
				);
			}

			$saveDataManager = $this->newDataManager($data, $data, $dbData->getData());
			$saveDataManager->setResult($result);

			$this->processUpdateData($saveDataManager);

			if ($result->hasError()) {
				return $result;
			}

			$data = $saveDataManager->getSaveData()->getArray();
			$updateData = $this->clearDataFields($data);
			$result->setUpdateData($updateData);

			$res = $this->updateNowById($updateData, $id);
			$result->setResult($res);

			return $result;
		}

		public function updateBy(array $data, callable $queryCallback): UpdateDataResultInterface {
			$result = $this->newUpdateDataResult();

			$saveDataManager = $this->newDataManager($data, $data, []);
			$saveDataManager->setResult($result);

			$this->onUpdate($saveDataManager);
			$this->onSave($saveDataManager);
			$this->processUpdateData($saveDataManager);

			if ($result->hasError()) {
				return $result;
			}

			$data = $saveDataManager->getSaveData()->getArray();
			$updateData = $this->clearDataFields($data);
			$result->setUpdateData($updateData);

			$res = $this->updateNowBy($updateData, $queryCallback);
			$result->setResult($res);

			return $result;
		}

		public function updateByField(array $data, string $field, string $value): UpdateDataResultInterface {
			$res = $this->updateBy($data,
				function (UpdateInterface $update) use ($field, $value) {
					$update->where("`$field` = ?", $value);
				}
			);

			return $res;
		}

	}
}