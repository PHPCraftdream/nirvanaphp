<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	class VirtualField extends Field implements FieldInterface {
		protected $data = [
			'name' => NULL,
			'title' => NULL,
			'placeholder' => NULL,
			'type' => 'string',
			'onCreate' => [],
			'onSave' => [],
			'onRead' => [],
			'onUpdate' => [],
			'onDelete' => [],
			'attrs' => [],
		];

		protected $sqlData = [];
	}
}