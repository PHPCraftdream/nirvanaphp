<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use League\Route\RouteCollection;
	use League\Route\RouteCollectionInterface;

	trait Router {
		protected $router;

		public function getRouter(): RouteCollectionInterface {
			if (!empty($this->router)) {
				return $this->router;
			}

			$router = new RouteCollection();
			$this->router = $router;

			return $router;
		}
	}
}