<?php

namespace PHPCraftdream\NirvanaPHP\Session {

	use PHPCraftdream\NirvanaPHP\Entity\Entity;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;

	class SessionData extends Entity {
		protected $table = 'sessionData';

		public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory) {
			$set->add($factory->newId());

			$set->add(
				$factory->newForeignKey('tSession', 'session', 'id')
			);

			$len = 32;
			$set->add(
				$factory->newString('pName')
					->setLength($len)
					->clearOnCreate()
					->clearOnUpdate()
					->setOnCreate('minLength', 1)
					->setOnUpdate('minLength', 1)
					->setOnCreate('maxLength', $len)
					->setOnUpdate('maxLength', $len)
					->setType('CHAR')
					->setSqlDefault('NULL')
					->setSqlNull(true)
					->setSqlIndex('UNIQUE INDEX `uniqVal` (`tSession`, `pName`)')

			);

			$len = 1024 * 8;
			$set->add(
				$factory->newString('pData')
					->setLength($len)
					->clearOnCreate()
					->clearOnUpdate()
					->setOnCreate('serialize')
					->setOnUpdate('serialize')
					->setOnCreate('maxLength', $len)
					->setOnUpdate('maxLength', $len)
					->setOnRead('unserialize')
					->setType('LONGTEXT')
					->setSqlDefault('NULL')
					->setSqlNull(true)
			);
		}
	}
}
