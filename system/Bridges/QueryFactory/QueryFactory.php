<?php

namespace PHPCraftdream\NirvanaPHP\Bridges\QueryFactory {

	use Aura\SqlQuery\Common\DeleteInterface;
	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;
	use Aura\SqlQuery\QueryFactory as AuraSqlQueryQueryFactory;

	class QueryFactory extends AuraSqlQueryQueryFactory implements QueryFactoryInterface {
		public function newSelect(): SelectInterface {
			return parent::newSelect();
		}

		public function newInsert(): InsertInterface {
			return parent::newInsert();
		}

		public function newUpdate(): UpdateInterface {
			return parent::newUpdate();
		}

		public function newDelete(): DeleteInterface {
			return parent::newDelete();
		}

	}

}