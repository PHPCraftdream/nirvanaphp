<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class IntField extends Field {
		protected $data = [
			'name' => NULL,
			'title' => NULL,
			'placeholder' => NULL,
			'type' => 'int',
			'onCreate' => ['intval' => 1],
			'onSave' => [
				'intval' => 1
			],
			'onRead' => [],
			'onUpdate' => ['intval' => 1],
			'onDelete' => [],
			'attrs' => [],
		];

		protected $sqlData = [
			'type' => 'INT',
			'length' => '11',
			'default' => NULL,
			'null' => false,
			//'index' => 'INDEX `:name` (`:name`)',
			'index' => NULL,
		];
	}
}