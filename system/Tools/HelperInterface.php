<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\FilesystemInterface;

	interface HelperInterface {
		public function newFileSystem(string $dir): FilesystemInterface;

		public function checkInterface(string $className, string $interfaceName);

		public function requireArray(array $____files____, array $____args____ = []);

		public function requireDir(string $dir, array $args, bool $recursive = NULL);

		public function globRecursive($pattern, $flags = 0);
	}
}