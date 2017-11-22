<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	interface ListDataInterface extends IterateInterface {
		public function add(EditableContainerInterface $item);

		public function getKeyName(): string;

		public function getName(): string;

		public function existsId($id): bool;

		public function getById($id): EditableContainerInterface;

		public function getCount(): int;

		public function getColumn(string $column, bool $nulls = false): array;
	}
}