<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\SelectInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;

	trait ReadToolsTrait {
		use MethodsTrait;

		protected function processReadItr(IterateInterface $data) {
			$dataRules = $this->getReadDataRules();
			$fieldSet = $this->getFieldSet();

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$field->onRead($data);
				$rules = $field->getOnRead();

				if (empty($rules)) {
					continue;
				}

				foreach ($rules as $ruleName => $args) {
					$this->assertMethodExists($dataRules, $ruleName);

					$dataRules->{$ruleName}($this, $data, $field->getName(), $args);
				}
			}
		}

		protected function fillListWithExSelectData(ListDataInterface $result, SelectInterface $selectQuery) {
			$queryEx = $this->getQueryEx();

			foreach ($queryEx->exSelectItr($selectQuery) as $item) {
				$dataContainer = $this->newEditableContainer($item);
				$result->add($dataContainer);
			}
		}

		protected function fillObjWithExSelectData(OneDataInterface $result, SelectInterface $selectQuery) {
			$queryEx = $this->getQueryEx();

			foreach ($queryEx->exSelectItr($selectQuery) as $item) {
				$dataContainer = $this->newEditableContainer($item);
				$result->setObj($dataContainer);

				break;
			}
		}
	}
}