<?php

namespace PHPCraftdream\NirvanaPHP\Tools {
	interface EnvInfoInterface {
		const ENV_DEV = 'dev';
		const ENV_TEST = 'test';
		const ENV_PROD = 'prod';

		public function envIsset(): bool;

		public function getEnv(): string;

		public function setEnvDev();

		public function envIsDev(): bool;

		public function setEnvTest();

		public function envIsTest(): bool;

		public function setEnvProd();

		public function envIsProd(): bool;

		public function __construct(array $server);

		public function isConsole(): bool;

		public function isAjax(): bool;

		public function sapiName(): string;

		public function getServer(): array;
	}
}