<?php

namespace PHPCraftdream\NirvanaPHP\Tools {
	class EnvInfo implements EnvInfoInterface {
		use ReturnFail;

		protected $server = NULL;

		public function __construct(array $server) {
			$this->setServer($server);
		}

		//====================================================================================
		protected $env = NULL;

		protected function assertEmptyEnvYet() {
			if ($this->env === NULL) {
				return;
			}

			throw new EnvException("Env is alreadey defined.");
		}

		protected function assertNotEmptyEnv() {
			if (!empty($this->env)) {
				return;
			}

			throw new EnvException("Env is empty.");
		}

		//------------------------------------------------------------------------------------
		public function envIsset(): bool {
			return $this->env !== NULL;
		}

		public function getEnv(): string {
			$this->assertNotEmptyEnv();

			return $this->env;
		}

		//------------------------------------------------------------------------------------
		public function setEnvDev() {
			$this->assertEmptyEnvYet();
			$this->env = EnvInfoInterface::ENV_DEV;
		}

		public function envIsDev(): bool {
			return $this->getEnv() === EnvInfoInterface::ENV_DEV;
		}

		//------------------------------------------------------------------------------------
		public function setEnvTest() {
			$this->assertEmptyEnvYet();
			$this->env = EnvInfoInterface::ENV_TEST;
		}

		public function envIsTest(): bool {
			return $this->getEnv() === EnvInfoInterface::ENV_TEST;
		}

		//------------------------------------------------------------------------------------

		public function setEnvProd() {
			$this->assertEmptyEnvYet();
			$this->env = EnvInfoInterface::ENV_PROD;
		}

		public function envIsProd(): bool {
			return $this->getEnv() === EnvInfoInterface::ENV_PROD;
		}

		//====================================================================================

		public function sapiName(): string {
			return php_sapi_name();
		}

		public function getServer(): array {
			return $this->server;
		}

		protected function setServer(array $server) {
			$this->server = $server;
		}

		public function isConsole(): bool {
			return $this->sapiName() === 'cli';
		}

		public function isAjax(): bool {
			if ($this->isConsole()) {
				return $this->fail('console');
			}

			$server = $this->getServer();

			if (empty($server['HTTP_X_REQUESTED_WITH'])) {
				return $this->fail('empty');
			}

			if (strtolower($server['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
				return $this->fail('XMLHttpRequest');
			}

			return true;
		}
	}
}