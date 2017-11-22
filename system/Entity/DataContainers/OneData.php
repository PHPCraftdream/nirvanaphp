<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class OneData implements OneDataInterface {
		use ForeignContainerTrait;

		protected $keyName;
		protected $name;
		protected $obj = NULL;
		protected $foreign = [];
		protected $sublist = [];
		protected $mainList = NULL;

		public function __construct(string $name, string $keyName, ListDataInterface $mainList = NULL) {
			$this->name = $name;
			$this->keyName = $keyName;
			$this->mainList = $mainList;
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

		protected function jsonSerializeOneData() {
			$data = [];

			$data['name'] = $this->name;
			$data['keyName'] = $this->keyName;
			$data['obj'] = $this->obj;
			$data['foreign'] = $this->foreign;
			$data['sublist'] = $this->sublist;

			return $data;
		}

		public function jsonSerialize() {
			return $this->jsonSerializeOneData();
		}

		public function setObj(EditableContainerInterface $obj): OneDataInterface {
			$this->obj = $obj;

			return $this;
		}

		public function obj(): EditableContainerInterface {
			return $this->obj;
		}

		public function exists(): bool {
			return !empty($this->obj);
		}

		public function iterate() {
			if (!empty($this->obj)) {
				yield $this->obj;
			}
		}
	}
}