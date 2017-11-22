<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use Aura\Sql\ExtendedPdoInterface;
	use Aura\SqlQuery\Common\DeleteInterface;
	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;

	interface QueryExInterface {
		public function getLastQuery();

		public function getFetch(): int;

		public function setFetch(int $fetch);

		public function setPDO(ExtendedPdoInterface $pdo): QueryExInterface;

		public function getPDO(): ExtendedPdoInterface;

		public function exSelect(SelectInterface $query): array;

		public function exSelectItr(SelectInterface $query);

		public function exSelectItrFirst(SelectInterface $query);

		public function selectCount(SelectInterface $query): int;

		public function exInsert(InsertInterface $query, $idField = 'id'): int;

		public function exUpdate(UpdateInterface $query): bool;

		public function exDelete(DeleteInterface $query): bool;

		public function ex(string $sql, array $args): bool;

		public function exFetch(string $sql, array $args): array;
	}
}