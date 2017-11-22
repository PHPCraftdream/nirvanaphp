<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use League\Flysystem\FilesystemInterface;

	trait FrameworkFs {
		use FrameworkTrait;

		protected $frameworkFs;

		public function frameworkFs(): FilesystemInterface {
			$app = $this->getThis();

			if (empty($this->frameworkFs)) {
				$this->frameworkFs = $app->newFileSystem($app->frameworkDir());
			}

			return $this->frameworkFs;
		}
	}
}