<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	trait FrameworkTrait {
		abstract protected function getThis(): FrameworkInterface;
	}
}