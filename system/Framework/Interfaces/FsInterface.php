<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use League\Flysystem\FilesystemInterface;

	interface FsInterface {
		public function appFs(): FilesystemInterface;

		public function appFsConfig(): FilesystemInterface;

		public function appFsPublic(): FilesystemInterface;

		public function appFsTmp(): FilesystemInterface;

		public function appFsVar(): FilesystemInterface;

		public function appFsUploads(): FilesystemInterface;

		public function appFsUploadsPublic(): FilesystemInterface;

		public function frameworkFs(): FilesystemInterface;

		public function newFileSystem(string $dir): FilesystemInterface;
	}
}