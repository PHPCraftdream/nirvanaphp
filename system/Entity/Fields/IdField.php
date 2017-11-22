<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class IdField extends Field {
		protected $data = [
			'name' => 'id',
			'title' => 'id',
			'placeholder' => 'id',
			'type' => 'id',
			'onCreate' => [
				'assertNotExists' => true,
			],
			'onSave' => [],
			'onRead' => [],
			'onUpdate' => [
				'assertUniqueExists' => true,
				'delete' => true
			],
			'onDelete' => [],
			'attrs' => [],
		];

		protected $sqlData = [
			'type' => 'INT',
			'length' => '11',
			'default' => 'NULL',
			'autoincrement' => true,
			'null' => false,
			'index' => 'PRIMARY KEY (`:name`)',
		];
	}
}