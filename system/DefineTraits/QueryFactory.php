<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactory as QueryFactoryBridge;
	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactoryInterface;


	trait QueryFactory {
		use FrameworkTrait;

		protected $queryFactory;

		public function getQueryFactory(): QueryFactoryInterface {
			if (!empty($this->queryFactory)) {
				return $this->queryFactory;
			}

			$appConfigDb = $this->getThis()->appConfigDb();
			$queryFactory = new QueryFactoryBridge($appConfigDb->get('type'));

			$this->queryFactory = $queryFactory;

			return $queryFactory;
		}
	}
}