<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Entity\EntityHub;
	use PHPCraftdream\NirvanaPHP\Entity\EntityHubInterface;

	trait EntityHubTrait {
		use FrameworkTrait;

		protected $entityHub;

		public function getEntityHub(): EntityHubInterface {
			if (empty($this->entityHub)) {
				$this->entityHub = new EntityHub($this->getThis());
			}

			return $this->entityHub;
		}
	}
}