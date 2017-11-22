<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {

	class FieldSet implements FieldSetInterface {
		protected $fields = [];

		protected $foreignInfo = [];

		protected function addForeignField(ForeignKeyInterface $field) {
			$this->foreignInfo[$field->getForeignEntity()] = $field;
		}

		protected function deleteForeignField(ForeignKeyInterface $field) {
			unset($this->foreignInfo[$field->getForeignEntity()]);
		}

		public function getForeignInfo(): array {
			return $this->foreignInfo;
		}

		public function getTitleField(): FieldInterface {

		}

		public function getTitleFieldName(): string {

		}

		public function add(FieldInterface $field): FieldSetInterface {
			$this->fields[$field->getName()] = $field;

			if ($field instanceof ForeignKeyInterface)
				$this->addForeignField($field);

			return $this;
		}

		public function delete(string $name): FieldSetInterface {
			if (!isset($this->fields[$name])) ;

			$field = $this->fields[$name];
			if ($field instanceof ForeignKeyInterface)
				$this->deleteForeignField($field);

			unset($this->fields[$name]);
			return $this;
		}

		public function clear(): FieldSetInterface {
			$this->foreignInfo = [];
			$this->fields[] = [];
			return $this;
		}

		public function exists(string $name): bool {
			return array_key_exists($name, $this->fields);
		}

		public function names(): array {
			return array_keys($this->fields);
		}

		public function get(string $name): FieldInterface {
			if (!array_key_exists($name, $this->fields))
				throw new FieldException("Field not found: $name");

			return $this->fields[$name];
		}

		public function assertField(FieldInterface $field): FieldInterface {
			return $field;
		}

		public function iterate() {
			foreach ($this->fields as $field)
				yield $field;
		}
	}
}