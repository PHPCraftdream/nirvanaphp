<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class ListData implements ListDataInterface {
		use ForeignContainerTrait;

		protected $keyName;
		protected $name;
		protected $foreign = [];
		protected $sublist = [];

		protected $listData = [
			'list' => [],
			'idByIndex' => [],
			'indexById' => [],
			'ids' => [],
		];

		public function __construct(string $name, string $keyName, ListDataInterface $mainList = NULL) {
			$this->name = $name;
			$this->keyName = $keyName;
			$this->mainList = $mainList;
		}

		public function getCount(): int {
			return count($this->listData['list']);
		}

		public function getKeyName(): string {
			return $this->keyName;
		}

		public function getName(): string {
			return $this->name;
		}

		public function getData(): array {
			return $this->jsonSerialize();
		}

		public function add(EditableContainerInterface $item) {
			$id = $item->get($this->getKeyName());

			if (empty($id)) {
				throw new ContainerException('Empty ID field');
			}

			$this->listData['list'][] = $item;
			end($this->listData['list']);
			$lastListId = key($this->listData['list']);

			$this->listData['indexById'][$id] = $lastListId;
			$this->listData['idByIndex'][$lastListId] = $id;
			$this->listData['ids'][] = $id;
		}

		public function existsId($id): bool {
			return array_key_exists($id, $this->listData['indexById']);
		}

		public function getById($id): EditableContainerInterface {
			if (!$this->existsId($id)) {
				throw new ContainerException('Item does not exist');
			}

			$index = $this->listData['indexById'][$id];

			if (!array_key_exists($index, $this->listData['list'])) {
				throw new ContainerException('Wtf?');
			}

			return $this->listData['list'][$index];
		}

		protected function jsonSerializeListData(): array {
			$data = $this->listData;

			$data['name'] = $this->name;
			$data['keyName'] = $this->keyName;

			if ($this->isMain()) {
				$data['foreign'] = $this->foreign;
				$data['sublist'] = $this->sublist;
			}

			return $data;
		}

		public function jsonSerialize() {
			return $this->jsonSerializeListData();
		}

		public function iterate() {
			foreach ($this->listData['list'] as $item) {
				yield $item;
			}
		}

		protected function assertEditableContainerInterface(EditableContainerInterface $item): EditableContainerInterface {
			return $item;
		}

		public function getColumn(string $column, bool $nulls = false): array {
			$result = [];

			foreach ($this->listData['list'] as $item) {
				$itm = $this->assertEditableContainerInterface($item);
				if (!$itm->exists($column)) {
					continue;
				}

				$val = $itm->get($column);
				if (!$nulls && $val === NULL) {
					continue;
				}

				$result[$val] = 1;
			}

			return array_keys($result);
		}
	}
}