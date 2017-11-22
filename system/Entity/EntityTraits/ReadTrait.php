<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\SelectInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;

	trait ReadTrait {
		use MethodsTrait;

		public function getCount(callable $queryCallback = NULL): int {
			$queryEx = $this->getQueryEx();
			$selectCntQuery = $this->newSelect();

			if (is_callable($queryCallback)) {
				$queryCallback($selectCntQuery, $this);
			}

			$count = $queryEx->selectCount($selectCntQuery);

			return $count;
		}

		public function existsById($id): bool {
			$count = $this->getCount(
				function (SelectInterface $select, EntityInterface $entity) use ($id) {
					$pk = $entity->getPrimaryKey();
					$select->where("`$pk` = ?", $id);
				}
			);

			return $count > 0;
		}

		public function readPage(int $page, callable $queryCallback = NULL): PageDataInterface {
			$count = $this->getCount($queryCallback);

			$pageData = $this->getNewPageData();

			$pageData->fillCountInfo($page, $count, $this->getPageSize());

			if ($count < 1) {
				return $pageData;
			}

			$selectQuery = $this->newSelect();
			$selectQuery->offset($pageData->getOffset());
			$selectQuery->limit($pageData->getPageSize());

			if (is_callable($queryCallback)) {
				$queryCallback($selectQuery, $pageData, $this);
			}

			$this->fillListWithExSelectData($pageData, $selectQuery);
			$this->processReadItr($pageData);
			$this->onRead($pageData);

			return $pageData;
		}

		public function readById($id): OneDataInterface {
			$pk = $this->getPrimaryKey();

			$result = $this->getNewOneData();

			$selectQuery = $this->newSelect();
			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$selectQuery->where("`$pk` = ?", $id);
			$selectQuery->limit(1);

			$this->fillObjWithExSelectData($result, $selectQuery);

			if (!$result->exists()) {
				return $result;
			}

			$this->processReadItr($result);
			$this->onRead($result);

			return $result;
		}

		public function readAll(callable $queryCallback = NULL): ListDataInterface {
			$result = $this->getNewListData();

			$selectQuery = $this->newSelect();

			if (is_callable($queryCallback)) {
				$queryCallback($selectQuery, $result, $this);
			}

			$this->fillListWithExSelectData($result, $selectQuery);
			$this->processReadItr($result);
			$this->onRead($result);

			return $result;
		}

		public function readOne(callable $queryCallback = NULL): OneDataInterface {
			$result = $this->getNewOneData();

			$selectQuery = $this->newSelect();
			$selectQuery->limit(1);

			if (is_callable($queryCallback)) {
				$queryCallback($selectQuery, $result, $this->getMe());
			}

			$this->fillObjWithExSelectData($result, $selectQuery);

			if (!$result->exists()) {
				return $result;
			}

			$this->processReadItr($result);
			$this->onRead($result);

			return $result;
		}

		public function readByFieldArray(string $field, array $values, callable $queryCallback = NULL): ListDataInterface {
			$readByFieldArray = function (SelectInterface $select, ListDataInterface $result, EntityInterface $entity)
			use ($field, $values, $queryCallback) {
				/** @noinspection PhpMethodParametersCountMismatchInspection */
				$select->where("`$field` in (?)", $values);

				if (is_callable($queryCallback)) {
					$queryCallback($select, $result, $entity);
				}
			};

			$result = $this->readAll($readByFieldArray);

			return $result;
		}

		public function readByIds(array $ids, callable $queryCallback = NULL): ListDataInterface {
			$result = $this->readByFieldArray($this->getPrimaryKey(), $ids, $queryCallback);

			return $result;
		}

		public function readByField(string $field, string $value, callable $queryCallback = NULL): ListDataInterface {
			$res = $this->readAll(
				function (SelectInterface $selectQuery)
				use ($field, $value, $queryCallback) {
					/** @noinspection PhpMethodParametersCountMismatchInspection */
					$selectQuery->where("`$field` = ?", $value);

					if (is_callable($queryCallback)) {
						$passArgs = func_get_args();
						$queryCallback(... $passArgs);
					}
				}
			);

			return $res;
		}

		public function pageByField(int $page, string $field, string $value, callable $queryCallback = NULL): PageDataInterface {
			$res = $this->readPage($page,
				function (SelectInterface $selectQuery)
				use ($field, $value, $queryCallback) {
					/** @noinspection PhpMethodParametersCountMismatchInspection */
					$selectQuery->where("`$field` = ?", $value);

					if (is_callable($queryCallback)) {
						$passArgs = func_get_args();
						$queryCallback(... $passArgs);
					}
				}
			);

			return $res;
		}
	}
}