<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces
{

	interface DirsInterface {
		public function appDir(): string;

		public function appEnvDir(): string;

		public function appNamespace(): string;

		public function appTempDir(): string;

		public function appConfigDirs(): array;

		public function frameworkNamespace(): string;

		public function frameworkDir(): string;

		public function appPublicDir(): string;

		public function appSetPublicDir(string $dir);
	}
}