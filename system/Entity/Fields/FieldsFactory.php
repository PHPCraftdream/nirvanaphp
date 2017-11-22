<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class FieldsFactory implements FieldsFactoryInterface {
		public function newId(string $name = 'id'): FieldInterface {
			$field = new IdField();
			$field->setName($name);

			return $field;
		}

		public function newString(string $name): StringFieldInterface {
			$field = new StringField();
			$field->setName($name);

			return $field;
		}

		public function newInt(string $name): FieldInterface {
			$field = new IntField();
			$field->setName($name);

			return $field;
		}

		public function newVirual(string $name): FieldInterface {
			$field = new VirtualField();
			$field->setName($name);

			return $field;
		}


		public function newIsDeleted(): FieldInterface {
			$field = new IsDeletedField();

			return $field;
		}

		public function newForeignKey(string $name, string $entity,
			string $titleField, array $fields = []): ForeignKeyInterface {
			$field = new ForeignKey($name, $entity, $titleField, $fields);

			return $field;
		}

	}
}