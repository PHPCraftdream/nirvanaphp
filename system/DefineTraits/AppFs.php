<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use League\Flysystem\FilesystemInterface;
	const DS = DIRECTORY_SEPARATOR;

	trait AppFs {
		use FrameworkTrait;

		//------------------------------------------------------------------------
		protected $appFs;

		public function appFs(): FilesystemInterface {
			if (empty($this->appFs)) {
				$this->appFs = $this->newFileSystem(
					$this->getThis()->appDir()
				);
			}

			return $this->appFs;
		}

		protected $appFsPublic;

		public function appFsPublic(): FilesystemInterface {
			if (empty($this->appFsPublic)) {
				$this->appFsPublic = $this->newFileSystem(
					$this->getThis()->appPublicDir()
				);
			}

			return $this->appFsPublic;
		}

		protected $appFsTmp;

		public function appFsTmp(): FilesystemInterface {
			if (empty($this->appFsTmp)) {
				$this->appFsTmp = $this->newFileSystem(
					$this->getThis()->appEnvDir() . 'Tmp' . DS
				);
			}

			return $this->appFsTmp;
		}

		protected $appFsVar;

		public function appFsVar(): FilesystemInterface {
			if (empty($this->appFsVar)) {
				$this->appFsVar = $this->newFileSystem(
					$this->getThis()->appEnvDir() . 'Var' . DS
				);
			}

			return $this->appFsVar;
		}

		protected $appFsUploads;

		public function appFsUploads(): FilesystemInterface {
			if (empty($this->appFsUploads)) {
				$this->appFsUploads = $this->newFileSystem(
					$this->getThis()->appEnvDir() . 'Uploads' . DS
				);
			}

			return $this->appFsUploads;
		}

		protected $appFsConfig;

		public function appFsConfig(): FilesystemInterface {
			if (empty($this->appFsConfig)) {
				$this->appFsConfig = $this->newFileSystem(
					$this->getThis()->appEnvDir() . 'Config' . DS
				);
			}

			return $this->appFsConfig;
		}

		protected $appFsConfigLocal;

		public function appFsConfigLocal(): FilesystemInterface {
			if (empty($this->appFsConfigLocal)) {
				$this->appFsConfigLocal = $this->newFileSystem(
					$this->getThis()->appEnvDir() . 'Config_local' . DS
				);
			}

			return $this->appFsConfigLocal;
		}

		protected $appFsUploadsPublic;

		public function appFsUploadsPublic(): FilesystemInterface {
			if (empty($this->appFsUploadsPublic)) {
				$this->appFsUploadsPublic = $this->newFileSystem(
					$this->getThis()->appPublicDir() . 'Uploads' . DS
				);
			}

			return $this->appFsUploadsPublic;
		}
	}
}