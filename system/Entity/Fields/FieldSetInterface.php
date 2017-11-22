<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	interface FieldSetInterface {
		public function getForeignInfo(): array;

		public function add(FieldInterface $field): FieldSetInterface;

		public function delete(string $name): FieldSetInterface;

		public function clear(): FieldSetInterface;

		public function exists(string $name): bool;

		public function names(): array;

		public function get(string $name): FieldInterface;

		public function assertField(FieldInterface $field): FieldInterface;

		public function iterate();
	}
}