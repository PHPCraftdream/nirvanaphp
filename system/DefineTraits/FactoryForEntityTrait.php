<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntity;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;

	trait FactoryForEntityTrait {
		use FrameworkTrait;

		protected $factoryForEntity;

		public function getFactoryForEntity(): FactoryForEntityInterface {
			if (empty($this->factoryForEntity)) {
				$this->factoryForEntity = new FactoryForEntity($this->getThis());
			}

			return $this->factoryForEntity;
		}
	}
}