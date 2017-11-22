<?php
namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use League\Flysystem\Adapter\Local as AdapertLocal;
	use League\Flysystem\AdapterInterface;
	use League\Flysystem\Filesystem;
	use League\Flysystem\FilesystemInterface;

	trait NewFileSystem {
		use FrameworkTrait;

		public function getLocalFSAdapter(string $dir): AdapterInterface {
			return new AdapertLocal($dir);
		}

		public function newFileSystem(string $dir): FilesystemInterface {
			if (!is_dir($dir)) {
				throw new \InvalidArgumentException("Directory '$dir' not found.");
			}

			$adapter = $this->getLocalFSAdapter($dir);
			$filesystem = new Filesystem($adapter);

			return $filesystem;
		}
	}
}