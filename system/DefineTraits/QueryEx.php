<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Tools\QueryEx as QE;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	trait QueryEx {
		use FrameworkTrait;

		protected $queryEx;

		public function getQueryEx(): QueryExInterface {
			if (!empty($this->queryEx)) {
				return $this->queryEx;
			}

			$queryEx = new QE();
			$queryEx->setPDO($this->getThis()->getPDO());

			$this->queryEx = $queryEx;

			return $queryEx;
		}
	}
}