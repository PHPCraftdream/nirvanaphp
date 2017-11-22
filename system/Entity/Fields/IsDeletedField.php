<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class IsDeletedField extends Field {
		protected $data = [
			'name' => 'isDeleted',
			'title' => 'isDeleted',
			'placeholder' => 'isDeleted',
			'type' => 'bool',
			'onCreate' => [
				'delete' => true
			],
			'onSave' => [],
			'onRead' => [],
			'onUpdate' => [
				'delete' => true
			],
			'onDelete' => [
				'now' => true
			],
			'attrs' => [],
		];

		protected $sqlData = [
			'type' => 'TINYINT',
			'length' => '1',
			'default' => '0',
			'null' => false,
			'index' => 'INDEX `:name` (`:name`)',
		];
	}
}