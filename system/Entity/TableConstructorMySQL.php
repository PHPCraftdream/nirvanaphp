<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	class TableConstructorMySQL implements TableConstructorInterface {
		protected $core;
		protected $queryEx;

		public function __construct(FactoryForEntityInterface $core) {
			$this->core = $core;
		}

		protected function getCore(): FactoryForEntityInterface {
			return $this->core;
		}

		protected function getQueryEx(): QueryExInterface {
			if (empty($this->queryEx))
				$this->queryEx = $this->getCore()->getQueryEx();

			return $this->queryEx;
		}

		protected function getFieldSql(FieldInterface $field): string {
			$sqlData = $field->getSqlData();

			if (empty($sqlData) || !is_array($sqlData)) {
				return '';
			}

			if (empty($sqlData['type'])) {
				return '';
			}

			$sql = $sqlData['type'];

			$sql .= empty($sqlData['length']) ? '' : sprintf('(%s)', $sqlData['length']);
			$sql .= empty($sqlData['null']) ? ' NOT NULL' : ' NULL';
			$sql .= isset($sqlData['default']) && is_string($sqlData['default']) ? sprintf(' DEFAULT %s', $sqlData['default']) : '';
			$sql .= !empty($sqlData['autoincrement']) ? ' AUTO_INCREMENT' : '';

			$res = sprintf('`%s` %s', $field->getName(), $sql);

			return $res;
		}

		protected function getFieldSqlKey(FieldInterface $field): string {
			$sqlData = $field->getSqlData();

			if (empty($sqlData) || !is_array($sqlData)) {
				return '';
			}

			if (empty($sqlData['index'])) {
				return '';
			}

			$sql = $sqlData['index'];
			$sql = str_ireplace(':name', $field->getName(), $sql);

			return $sql;
		}

		protected function getSqlFields(FieldSetInterface $fieldSet): array {
			$res = [];
			$keys = [];

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);

				$sql = $this->getFieldSql($field);
				$sqlKey = $this->getFieldSqlKey($field);

				if (!empty($sql)) {
					$res[] = $sql;
				}

				if (!empty($sqlKey)) {
					$keys[] = $sqlKey;
				}
			}

			$res = array_merge($res, $keys);

			return $res;
		}

		public function makeCreateTableSql(EntityInterface $entity): string {
			$table = $entity->getTable();
			$fieldSet = $entity->getFieldSet();

			$sqlFields = $this->getSqlFields($fieldSet);
			$sqlFields = join(",\n", $sqlFields);

			$sql = "CREATE TABLE IF NOT EXISTS `$table` (\n$sqlFields)\n";

			return $sql;
		}

		public function createTable(EntityInterface $entity) {
			$sql = $this->makeCreateTableSql($entity);
			$this->getQueryEx()->ex($sql, []);
		}

		public function dropAllIndexes(EntityInterface $entity): array {
			$indexes = $this->getTableIndexes($entity);
			$table = $entity->getTable();

			$sqlInit = 'ALTER TABLE ' . $table;

			$dropped = [];
			$sqlz = [];

			foreach ($indexes as $ind) {
				if (empty($ind[1])) {
					continue;
				}

				if (empty($ind[0])) {
					continue;
				}

				$keyName = $ind[1];

				if ($keyName == 'PRIMARY') {
					continue;
				}

				$dropped[] = $keyName;
				$sql = $sqlInit . ' DROP INDEX IF EXISTS `' . $keyName . '`';
				$sqlz[] = $sql;
			}

			$this->runSqlz($sqlz);

			return $dropped;
		}

		public function createIndexes(EntityInterface $entity): array {
			$fieldSet = $entity->getFieldSet();
			$sqlInit = 'ALTER TABLE ' . $entity->getTable();
			$created = [];
			$sqlz = [];

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$fieldName = $field->getName();

				if ($fieldName == 'id') {
					continue;
				}

				$field = $fieldSet->get($fieldName);
				$sqlKey = $this->getFieldSqlKey($field);

				if (empty($sqlKey)) {
					continue;
				}

				$created[] = $fieldName;
				$sql = $sqlInit . ' ADD ' . $sqlKey;

				$sqlz[] = $sql;
			}

			$this->runSqlz($sqlz);

			return $created;
		}

		public function getTableColumns(EntityInterface $entity): array {
			$table = $entity->getTable();
			$sql = sprintf('SHOW COLUMNS FROM `%s`;', $table);
			$queryEx = $this->getQueryEx();

			$dbColumns = $queryEx->exFetch($sql, []);
			$res = [];
			$ind = 0;

			foreach ($dbColumns as $column) {
				if (empty($column->Field)) {
					continue;
				}

				if (empty($column->Type)) {
					continue;
				}

				$res[$column->Field] = $column->Type;
				$ind++;
			}

			return $res;
		}

		public function getTableIndexes(EntityInterface $entity): array {
			$table = $entity->getTable();
			$sql = sprintf('SHOW INDEX FROM `%s`', $table);
			$indexes = $this->getQueryEx()->exFetch($sql, []);

			$result = [];

			foreach ($indexes as $index) {
				if (empty($index->Key_name)) {
					continue;
				}

				if (empty($index->Column_name)) {
					continue;
				}

				$result[] = [$index->Column_name, $index->Key_name];
			}

			return $result;
		}

		public function addNewColumns(EntityInterface $entity): array {
			$fieldSet = $entity->getFieldSet();
			$sqlInit = 'ALTER TABLE ' . $entity->getTable();
			$dbColumns = $this->getTableColumns($entity);

			$added = [];
			$sqlz = [];
			$after = false;

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$fieldName = $field->getName();

				$sql = $this->getFieldSql($field);

				if (empty($sql)) {
					continue;
				}

				if (isset($dbColumns[$fieldName])) {
					$after = $fieldName;
					continue;
				}

				$added[] = $fieldName;
				$sql = $sqlInit . ' ADD COLUMN ' . $sql;

				if ($after) {
					$sql .= ' AFTER `' . $after . '`';
				}

				$sqlz[] = $sql;

				$after = $fieldName;
			}

			$this->runSqlz($sqlz);

			return $added;
		}

		public function changeColumns(EntityInterface $entity): array {
			$fieldSet = $entity->getFieldSet();
			$sqlInit = 'ALTER TABLE ' . $entity->getTable();
			$dbColumns = $this->getTableColumns($entity);

			$changed = [];
			$sqlz = [];

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$fieldName = $field->getName();

				$sql = $this->getFieldSql($field);

				if (empty($sql)) {
					continue;
				}

				if (!isset($dbColumns[$fieldName])) {
					continue;
				}

				$changed[] = $fieldName;
				$sql = $sqlInit . ' CHANGE COLUMN `' . $fieldName . '` ' . $sql;

				$sqlz[] = $sql;
			}

			$this->runSqlz($sqlz);

			return $changed;
		}

		public function deleteColumns(EntityInterface $entity): array {
			$fieldSet = $entity->getFieldSet();
			$sqlInit = 'ALTER TABLE ' . $entity->getTable();
			$dbColumns = $this->getTableColumns($entity);

			$deleted = [];
			$sqlz = [];

			foreach ($dbColumns as $column => $columnOrnNum) {
				if ($fieldSet->exists($column)) {
					continue;
				}

				$deleted[] = $column;
				$sql = $sqlInit . ' DROP COLUMN IF EXISTS `' . $column . '`';

				$sqlz[] = $sql;
			}

			$this->runSqlz($sqlz);

			return $deleted;
		}

		protected function runSqlz($sqlz = NULL) {
			if (empty($sqlz) || !is_array($sqlz)) {
				return;
			}

			$queryEx = $this->getQueryEx();

			foreach ($sqlz as $sql) {
				if (!is_string($sql)) {
					continue;
				}

				$queryEx->ex($sql, []);
			}
		}

		public function constructTable(EntityInterface $entity) {
			$this->createTable($entity);
			$this->addNewColumns($entity);
			$this->dropAllIndexes($entity);
			$this->createIndexes($entity);
			$this->changeColumns($entity);
			$this->deleteColumns($entity);
		}
	}
}