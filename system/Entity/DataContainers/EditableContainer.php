<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	class EditableContainer extends Container implements EditableContainerInterface {
		protected $data = [];
		protected $lockedFields = [];

		public function set(string $name, $value = NULL): EditableContainerInterface {
			if (is_array($this->data)) {
				$this->data[$name] = $value;

				return $this;
			}

			if (is_object($this->data)) {
				$this->data->{$name} = $value;

				return $this;
			}

			throw new ContainerException('Wtf?');
		}

		public function delete(string $name): EditableContainerInterface {
			if (is_array($this->data)) {
				unset($this->data[$name]);

				return $this;
			}

			if (is_object($this->data)) {
				unset($this->data->{$name});

				return $this;
			}

			throw new ContainerException('Wtf?');
		}
	}
}