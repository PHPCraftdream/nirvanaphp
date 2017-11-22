<?php

namespace PHPCraftdream\NirvanaPHP\Bridges\QueryFactory {

	use Aura\SqlQuery\Common\DeleteInterface;
	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;

	interface QueryFactoryInterface {
		public function __construct($db, $common = null);

		public function setLastInsertIdNames(array $last_insert_id_names);

		public function newSelect(): SelectInterface;

		public function newInsert(): InsertInterface;

		public function newUpdate(): UpdateInterface;

		public function newDelete(): DeleteInterface;
	}
}