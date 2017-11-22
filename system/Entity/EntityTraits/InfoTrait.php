<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;

	trait InfoTrait {
		use MethodsTrait;

		protected $primaryKey = 'id';
		protected $database = '';
		protected $prefix = '';
		protected $table;

		protected $pageSize = 10;
		protected $colsSelect = ['*'];

		protected $fieldSet;
		protected $pluginSet;

		public function getPageSize(): int {
			return $this->pageSize;
		}

		public function setPageSize(int $pageSize) {
			$this->pageSize = $pageSize;
		}

		public function getPrimaryKey(): string {
			return $this->primaryKey;
		}

		public function setPrimaryKey(string $primaryKey) {
			$this->primaryKey = $primaryKey;
		}

		public function setDatabase(string $val) {
			$this->database = $val;
		}

		public function setPrefix(string $val) {
			$this->prefix = $val;
		}

		public function getName(): string {
			return $this->table;
		}

		public function getTable(): string {
			$database = empty($this->database) ? '' : $this->database . '.';

			return $database . $this->prefix . '' . $this->table;
		}

		public function setColsSelect(array $value) {
			$this->colsSelect = $value;
		}

		public function getColsSelect(): array {
			return $this->colsSelect;
		}

		public function getFieldSet(): FieldSetInterface {
			if (!empty($this->fieldSet)) {
				return $this->fieldSet;
			}

			$this->fieldSet = $this->newFieldSet();
			$fieldFactory = $this->getFieldsFactory();

			$this->fields($this->fieldSet, $fieldFactory);

			return $this->fieldSet;
		}

		//---------------------------------------------------------

		/*
		public function plugins()
		{

		}

		public function getPluginSet(): PluginSetInterface
		{
			if (!empty($this->pluginSet))
				return $this->pluginSet;

			$this->pluginSet = $this->newFieldSet();
			$pluginFactory = $this->getFieldsFactory();

			$this->plugins($this->pluginSet, $pluginFactory);

			return $this->pluginSet;
		}
		*/
	}
}