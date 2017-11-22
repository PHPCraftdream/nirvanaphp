<?php

namespace PHPCraftdream\NirvanaPHP\Session {

	use PHPCraftdream\NirvanaPHP\Entity\Entity;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;

	class Session extends Entity {
		protected $table = 'session';

		public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory) {
			$set->add($factory->newId());

			$len = 32;
			$set->add(
				$factory->newString('sessionId')
					->setLength($len)
					->clearOnCreate()
					->clearOnUpdate()
					->setOnCreate('assertNotExists')
					->setOnCreate('required')
					->setOnCreate('eqLength', $len)
					->setOnUpdate('assertUniqueExists')
					->setOnUpdate('delete')
					->setSqlIndex('UNIQUE (`:name`)')
			);

			$created = $factory->newInt('dCreated')->clearRules();
			$created->setOnCreate('now')->setOnUpdate('delete');
			$set->add($created);

			$updated = $factory->newInt('dUpdated')->clearRules();
			$updated->setOnCreate('now')->setOnUpdate('now');
			$set->add($updated);
		}

		public function subEntities() {

		}
	}
}
