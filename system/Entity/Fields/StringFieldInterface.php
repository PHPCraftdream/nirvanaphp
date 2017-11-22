<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {
	interface StringFieldInterface extends FieldInterface {
		public function setLength(int $val): StringFieldInterface;
	}
}