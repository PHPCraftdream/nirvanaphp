<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\CreateTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\FactoryTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\InfoTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\ReadToolsTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\ReadTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\SaveToolsTrait;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\UpdateEntityTrait;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;

	class Entity implements EntityInterface {
		use InfoTrait;
		use FactoryTrait;
		use SaveToolsTrait;
		use CreateTrait;
		use ReadToolsTrait;
		use ReadTrait;
		use UpdateEntityTrait;

		protected $entityFactory;

		public function __construct(FactoryForEntityInterface $core) {
			$this->entityFactory = $core;
		}

		protected function getMe(): EntityInterface {
			return $this;
		}

		public function getEntityFactory(): FactoryForEntityInterface {
			return $this->entityFactory;
		}

		//-------------------------------------------------------------

		protected function onRead(IterateInterface $list) {

		}

		protected function onSave(SaveDataManagerInterface $saveDataManager) {

		}

		protected function onCreate(SaveDataManagerInterface $saveDataManager) {

		}

		protected function onUpdate(SaveDataManagerInterface $saveDataManager) {

		}

		//-------------------------------------------------------------

		public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory) {
			throw new EntityException('Please, redefine fields method');

			// $set->add($factory->newId());
		}

		public function subData(): array {
			return [
				//'entity' =>  //selectCallback
				//	function (SelectInterface $select, ListDataInterface $result, EntityInterface $entity) { },
			];
		}

		public function getLastQuery() {
			return $this->getQueryEx()->getLastQuery();
		}

		/*
		 * move globals to container with interface
		 *
		 * foreignKeyInfo in results
		 * title key info in lists
		 *
		 * delete
		 * insert batch
		 * sub entities
		 * many to many
		 *
		 * load foreign data optional
		 * Entity-value with auto creating, with field
		 * sqlIndex sqlUnique methods
		 */

		//-----------------------------------------------------------------------------------------


	}
}