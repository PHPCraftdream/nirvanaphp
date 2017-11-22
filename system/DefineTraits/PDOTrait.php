<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use Aura\Sql\ExtendedPdo;
	use Aura\Sql\ExtendedPdoInterface;

	trait PDOTrait {
		use FrameworkTrait;

		protected function getNewPDO($dns, $user, $pass, $opts, $attrs): ExtendedPdoInterface {
			$pdo = new ExtendedPdo($dns, $user, $pass, $opts, $attrs);

			return $pdo;
		}

		protected $pdo;

		public function getPDO(): ExtendedPdoInterface {
			if (!empty($this->pdo)) {
				return $this->pdo;
			}

			$app = $this->getThis();

			$appConfigDb = $app->appConfigDb();

			$options = $appConfigDb->get('options');
			$options = empty($options) || !is_array($options) ? [] : $options;

			$attrs = $appConfigDb->get('attrs');
			$attrs = empty($attrs) || !is_array($attrs) ? [] : $attrs;

			$this->pdo = $this->getNewPDO(
				$appConfigDb->get('dsn'),
				$appConfigDb->get('user'),
				$appConfigDb->get('password'),
				$options,
				$attrs
			);

			return $this->pdo;
		}
	}
}