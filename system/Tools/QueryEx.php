<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use Aura\Sql\ExtendedPdoInterface;
	use Aura\SqlQuery\Common\DeleteInterface;
	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;
	use Aura\SqlQuery\QueryInterface;
	use PDO;

	class QueryEx implements QueryExInterface {
		protected $pdo;

		protected $fetch = PDO::FETCH_OBJ;

		public function getFetch(): int {
			return $this->fetch;
		}

		public function setFetch(int $fetch) {
			$this->fetch = $fetch;
		}

		public function setPDO(ExtendedPdoInterface $pdo): QueryExInterface {
			$this->pdo = $pdo;
			return $this;
		}

		public function getPDO(): ExtendedPdoInterface {
			return $this->pdo;
		}

		protected $lastQuery = NULL;

		protected function saveLastQuery(QueryInterface $query) {
			$this->lastQuery = (Object)[
				'sql' => $query->getStatement(),
				'params' => $query->getBindValues()
			];
		}

		public function getLastQuery() {
			return $this->lastQuery;
		}

		public function exSelect(SelectInterface $query): array {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$statement->execute($query->getBindValues());

			$result = [];
			$fetch = $this->getFetch();

			while ($item = $statement->fetch($fetch)) {
				$result[] = $item;
			}

			return $result;
		}

		public function exSelectItr(SelectInterface $query) {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$statement->execute($query->getBindValues());

			$fetch = $this->getFetch();

			while ($item = $statement->fetch($fetch)) {
				yield $item;
			}
		}

		public function exSelectItrFirst(SelectInterface $query) {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$statement->execute($query->getBindValues());

			$fetch = $this->getFetch();
			$item = $statement->fetch($fetch);

			if ($item) {
				yield $item;
			}
		}

		public function selectCount(SelectInterface $query): int {
			$query->cols(["count(*) as '__cnt__'"]);

			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$statement->execute($query->getBindValues());

			$item = $statement->fetch(PDO::FETCH_OBJ);

			$count = intval($item->__cnt__);

			return $count;
		}

		public function exInsert(InsertInterface $query, $idField = 'id'): int {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$statement->execute($query->getBindValues());

			$id = intval($pdo->lastInsertId($idField));

			return $id;
		}

		public function exUpdate(UpdateInterface $query): bool {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$res = boolval($statement->execute($query->getBindValues()));

			return $res;
		}

		public function exDelete(DeleteInterface $query): bool {
			$pdo = $this->getPDO();

			$this->saveLastQuery($query);
			$statement = $pdo->prepare($query->getStatement());
			$res = boolval($statement->execute($query->getBindValues()));

			return $res;
		}

		public function ex(string $sql, array $args): bool {
			$pdo = $this->getPDO();

			$this->lastQuery = (Object)[
				'sql' => $sql,
				'params' => $args
			];

			$statement = $pdo->prepare($sql);
			$res = boolval($statement->execute($args));

			return $res;
		}

		public function exFetch(string $sql, array $args): array {
			$pdo = $this->getPDO();

			$this->lastQuery = (Object)[
				'sql' => $sql,
				'params' => $args
			];

			$statement = $pdo->prepare($sql);
			$statement->execute($args);

			$result = [];
			$fetch = $this->getFetch();

			while ($item = $statement->fetch($fetch)) {
				$result[] = $item;
			}

			return $result;
		}

		public function exFetchItr(string $sql, array $args) {
			$pdo = $this->getPDO();

			$this->lastQuery = (Object)[
				'sql' => $sql,
				'params' => $args
			];

			$statement = $pdo->prepare($sql);
			$statement->execute($args);

			$fetch = $this->getFetch();

			while ($item = $statement->fetch($fetch)) {
				yield $item;
			}
		}
	}
}