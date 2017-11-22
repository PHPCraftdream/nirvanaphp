<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	interface FieldsFactoryInterface {
		public function newId(string $name = 'id'): FieldInterface;

		public function newString(string $name): StringFieldInterface;

		public function newInt(string $name): FieldInterface;

		public function newVirual(string $name): FieldInterface;

		public function newIsDeleted(): FieldInterface;

		public function newForeignKey(string $name, string $entity,
			string $titleField, array $fields = []): ForeignKeyInterface;
	}
}