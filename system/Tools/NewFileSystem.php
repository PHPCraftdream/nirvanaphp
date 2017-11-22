<?php
namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\Adapter\Local as AdapertLocal;
	use League\Flysystem\Filesystem;
	use League\Flysystem\FilesystemInterface;

	trait NewFileSystem {
		public function newFileSystem(string $dir): FilesystemInterface {
			if (!is_dir($dir))
				throw new \InvalidArgumentException("Directory '$dir' not found.");

			$adapter = new AdapertLocal($dir);
			$filesystem = new Filesystem($adapter);

			return $filesystem;
		}
	}
}