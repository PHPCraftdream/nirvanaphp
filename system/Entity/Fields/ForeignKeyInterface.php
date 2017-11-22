<?php
namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	interface ForeignKeyInterface extends FieldInterface {
		public function getForeignEntity(): string;

		public function getForeignTitleField(): string;

		public function getForeignFields(): array;
	}
}