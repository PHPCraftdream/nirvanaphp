<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use Aura\Sql\ExtendedPdoInterface;
	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityHubInterface;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	interface DbInterface {
		public function getPDO(): ExtendedPdoInterface;

		public function getQueryFactory(): QueryFactoryInterface;

		public function getQueryEx(): QueryExInterface;

		public function getEntityHub(): EntityHubInterface;

		public function getFactoryForEntity(): FactoryForEntityInterface;
	}
}