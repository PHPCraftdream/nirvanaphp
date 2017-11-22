<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\FilesystemInterface;

	interface DirCopyInterface {
		public function from(FilesystemInterface $fs, string $subDir): DirCopyInterface;

		public function to(FilesystemInterface $fs, string $subDir): DirCopyInterface;

		public function run(callable $callback = NULL, array $callbackData = []): DirCopyInterface;

		public function reset();
	}
}