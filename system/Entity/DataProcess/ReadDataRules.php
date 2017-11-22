<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\EditableContainerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;

	class ReadDataRules implements ReadDataRulesInterface {
		protected $core;
		protected $queryEx;
		protected $queryFactory;

		public function __construct(FactoryForEntityInterface $core) {
			$this->core = $core;
		}

		protected function getCore(): FactoryForEntityInterface {
			return $this->core;
		}

		protected function assertEditableContainerInterface(EditableContainerInterface $data): EditableContainerInterface {
			return $data;
		}

		public function unserialize(EntityInterface $entity, IterateInterface $list, string $fieldName, $args) {
			foreach ($list->iterate() as $item) {
				$data = $this->assertEditableContainerInterface($item);
				$value = $data->get($fieldName);
				$value = @unserialize($value);
				$data->set($fieldName, $value);
			}
		}
	}
}