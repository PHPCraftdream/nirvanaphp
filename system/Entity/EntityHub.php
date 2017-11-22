<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;

	class EntityHub implements EntityHubInterface {
		protected $app;
		protected $list = [];

		public function __construct(FrameworkInterface $app) {
			$this->app = $app;
		}

		public function getApp(): FrameworkInterface {
			return $this->app;
		}

		protected function assertEntityInterface(EntityInterface $entity): EntityInterface {
			return $entity;
		}

		public function get(string $name): EntityInterface {
			if (empty($this->list[$name])) {
				throw new EntityException("Module is not defined: $name");
			}

			$data = $this->list[$name];

			if (empty($data->obj)) {
				$factory = $data->factory;
				$data->obj = $factory($this->getApp(), $name);
			}

			return $data->obj;
		}

		public function define(string $name, callable $factory): EntityHubInterface {
			if (!empty($this->list[$name])) {
				throw new EntityException("Entity is already defined: $name");
			}

			$this->list[$name] = (object)[
				'name' => $name,
				'factory' => $factory,
				'obj' => NULL,
			];

			return $this;
		}

		public function exists(string $name): bool {
			return array_key_exists($name, $this->list);
		}

		public function iterate(callable $callback) {
			foreach ($this->list as $name => $item) {
				$callback($this->get($name));
			}
		}
	}
}