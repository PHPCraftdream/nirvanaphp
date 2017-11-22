<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\FilesystemInterface;

	class DirCopy implements DirCopyInterface {
		protected $fromFS = NULL;
		protected $fromSubDir = NULL;

		protected $toFS = NULL;
		protected $toSubDir = NULL;

		//------------------------------------------------------------------------------------------------------
		public function from(FilesystemInterface $fs, string $subDir): DirCopyInterface {
			$this->fromFS = $fs;
			$this->fromSubDir = $subDir;

			return $this;
		}

		protected function getFromFs(): FilesystemInterface {
			return $this->fromFS;
		}

		//------------------------------------------------------------------------------------------------------
		public function to(FilesystemInterface $fs, string $subDir): DirCopyInterface {
			$this->toFS = $fs;
			$this->toSubDir = $subDir;

			return $this;
		}

		protected function getToFs(): FilesystemInterface {
			return $this->toFS;
		}

		//------------------------------------------------------------------------------------------------------

		public function run(callable $callback = NULL, array $callbackData = []): DirCopyInterface {
			$from = $this->getFromFs();
			$to = $this->getToFs();

			$fromSubDir = trim($this->fromSubDir, '\\/') . '/';
			$lenFromSubDir = strlen($fromSubDir);
			$toSubDir = trim($this->toSubDir, '\\/') . '/';

			$sources = $from->listContents($this->fromSubDir, true);

			foreach ($sources as $item) {
				if ($item['type'] !== 'file') {
					continue;
				}

				$content = $from->read($item['path']);

				$item['path'] = '/' . ltrim($item['path'], '\\/');

				$path = $toSubDir . substr($item['path'], $lenFromSubDir);
				$item['new_path'] = $path;

				if ($callback)
					$content = $callback($from, $to, $item, $content, $callbackData);

				if ($content === false) {
					continue;
				}

				$to->put($item['new_path'], $content);
			}

			return $this;
		}

		public function reset() {
			$this->fromFS = NULL;
			$this->fromSubDir = NULL;
			$this->toFS = NULL;
			$this->toSubDir = NULL;
		}
	}
}