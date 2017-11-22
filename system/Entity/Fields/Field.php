<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;

	class Field implements FieldInterface {
		protected $data = [
			'name' => NULL,
			'title' => NULL,
			'placeholder' => NULL,
			'type' => NULL,
			'onCreate' => [],
			'onSave' => [],
			'onRead' => [],
			'onUpdate' => [],
			'onDelete' => [],
			'attrs' => [],
		];

		protected $sqlData = [
			'type' => NULL,
			'length' => NULL,
			'default' => NULL,
			'null' => NULL,
			'index' => NULL,
			'autoincrement' => false,
		];


		//-----------------------------------------------------

		public function clearRules(): FieldInterface {
			$this->data['onCreate'] = [];
			$this->data['onSave'] = [];
			$this->data['onRead'] = [];
			$this->data['onUpdate'] = [];
			$this->data['onDelete'] = [];

			return $this;
		}

		//-----------------------------------------------------

		public function onCreate(SaveDataManagerInterface $saveDataManager) {

		}

		public function onUpdate(SaveDataManagerInterface $saveDataManager) {

		}

		public function onSave(SaveDataManagerInterface $saveDataManager) {

		}

		public function onRead(IterateInterface $list) {

		}

		public function isVirtual(): bool {
			return empty($this->sqlData);
		}

		//-----------------------------------------------------

		public function getData(): array {
			return $this->data;
		}

		public function setData(array $data): FieldInterface {
			$this->data = $data;
			return $this;
		}

		//-----------------------------------------------------

		public function getSqlData(): array {
			return $this->sqlData;
		}

		public function setSqlData(array $data): FieldInterface {
			$this->sqlData = $data;
			return $this;
		}

		//-----------------------------------------------------

		public function setSqlType($val): FieldInterface {
			$this->sqlData['type'] = $val;
			return $this;
		}

		public function getSqlType() {
			return $this->sqlData['type'];
		}

		//-----------------------------------------------------

		public function setSqlAutoincrement(bool $val): FieldInterface {
			$this->sqlData['autoincrement'] = $val;
			return $this;
		}

		public function getSqlAutoincrement(): bool {
			return $this->sqlData['autoincrement'];
		}

		//-----------------------------------------------------

		public function setSqlLength($val): FieldInterface {
			$this->sqlData['length'] = $val;
			return $this;
		}

		public function getSqlLength() {
			return $this->sqlData['length'];
		}

		//-----------------------------------------------------

		public function setSqlIndex($val): FieldInterface {
			$this->sqlData['index'] = $val;
			return $this;
		}

		public function getSqlIndex() {
			return $this->sqlData['index'];
		}

		//-----------------------------------------------------

		public function setSqlDefault($val): FieldInterface {
			$this->sqlData['default'] = $val;
			return $this;
		}

		public function getSqlDefault() {
			return $this->sqlData['default'];
		}

		//-----------------------------------------------------

		public function setSqlNull(bool $val): FieldInterface {
			$this->sqlData['null'] = $val;
			return $this;
		}

		public function getSqlNull(): bool {
			return !empty($this->sqlData['null']);
		}

		//-----------------------------------------------------

		public function getName(): string {
			return $this->data['name'];
		}

		public function setName(string $val): FieldInterface {
			$this->data['name'] = $val;
			return $this;
		}

		//-----------------------------------------------------

		public function getTitle(): string {
			return $this->data['title'];
		}

		public function setTitle(string $val): FieldInterface {
			$this->data['title'] = $val;
			return $this;
		}

		//-----------------------------------------------------

		public function getPlaceholder(): string {
			return $this->data['placeholder'];
		}

		public function setPlaceholder(string $val): FieldInterface {
			$this->data['placeholder'] = $val;
			return $this;
		}

		//-----------------------------------------------------

		public function getType(): string {
			return $this->data['type'];
		}

		public function setType(string $val): FieldInterface {
			$this->data['type'] = $val;
			return $this;
		}

		//-----------------------------------------------------

		public function clearOnCreate(): FieldInterface {
			$this->data['onCreate'] = [];
			return $this;
		}

		public function setOnCreate(string $name, $args = []): FieldInterface {
			$this->data['onCreate'][$name] = $args;
			return $this;
		}

		public function getOnCreate(): array {
			return $this->data['onCreate'];
		}

		public function unsetOnCreate(string $name): FieldInterface {
			unset($this->data['onCreate'][$name]);
			return $this;
		}

		//-----------------------------------------------------

		public function clearOnSave(): FieldInterface {
			$this->data['onSave'] = [];
			return $this;
		}

		public function setOnSave(string $name, $args = []): FieldInterface {
			$this->data['onSave'][$name] = $args;
			return $this;
		}

		public function getOnSave(): array {
			return $this->data['onSave'];
		}

		public function unsetOnSave(string $name): FieldInterface {
			unset($this->data['onSave'][$name]);
			return $this;
		}

		//-----------------------------------------------------
		public function clearOnUpdate(): FieldInterface {
			$this->data['onUpdate'] = [];
			return $this;
		}

		public function setOnUpdate(string $name, $args = []): FieldInterface {
			$this->data['onUpdate'][$name] = $args;
			return $this;
		}

		public function getOnUpdate(): array {
			return $this->data['onUpdate'];
		}

		public function unsetOnUpdate(string $name): FieldInterface {
			unset($this->data['onUpdate'][$name]);
			return $this;
		}

		//-----------------------------------------------------

		public function clearOnDelete(): FieldInterface {
			$this->data['onDelete'] = [];
			return $this;
		}

		public function setOnDelete(string $name, $args = []): FieldInterface {
			$this->data['onDelete'][$name] = $args;
			return $this;
		}

		public function getOnDelete(): array {
			return $this->data['onDelete'];
		}

		public function unsetOnDelete(string $name): FieldInterface {
			unset($this->data['onUpdate'][$name]);
			return $this;
		}

		//-----------------------------------------------------

		public function clearOnRead(): FieldInterface {
			$this->data['onRead'] = [];
			return $this;
		}

		public function setOnRead(string $name, $args = []): FieldInterface {
			$this->data['onRead'][$name] = $args;
			return $this;
		}

		public function getOnRead(): array {
			return $this->data['onRead'];
		}

		public function unsetOnRead(string $name): FieldInterface {
			unset($this->data['onRead'][$name]);
			return $this;
		}

		//-----------------------------------------------------

		public function clearAttrs(): FieldInterface {
			$this->data['attrs'] = [];
			return $this;
		}

		public function setAttr(string $name, $val): FieldInterface {
			$this->data['attrs'][$name] = $val;
			return $this;
		}

		public function getAttr(string $name) {
			$attrs = &$this->data['attrs'];
			$exists = array_key_exists($name, $attrs);
			$result = $exists ? $attrs[$name] : NULL;

			return $result;
		}

		public function getAttrs(): array {
			return $this->data['attrs'];
		}

		public function unsetAttr(string $name): FieldInterface {
			unset($this->data['attrs'][$name]);
			return $this;
		}
	}
}