<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class StringField extends Field implements StringFieldInterface {
		protected $data = [
			'name' => NULL,
			'title' => NULL,
			'placeholder' => NULL,
			'type' => 'string',
			'onCreate' => [],
			'onSave' => [
				'maxLength' => 32
			],
			'onRead' => [],
			'onUpdate' => [],
			'onDelete' => [],
			'attrs' => [],
		];

		protected $sqlData = [
			'type' => 'VARCHAR',
			'length' => 32,
			'default' => NULL,
			'null' => false,
			'index' => NULL,
		];

		public function setLength(int $val): StringFieldInterface {
			$this->data['onCreate']['maxLength'] = $val;
			$this->data['onUpdate']['maxLength'] = $val;
			$this->sqlData['length'] = $val;

			return $this;
		}
	}
}