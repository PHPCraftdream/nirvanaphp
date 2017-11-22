<?php

namespace PHPCraftdream\NirvanaPHP\Tools {
	class Helper implements HelperInterface {
		use NewFileSystem;

		public function checkInterface(string $className, string $interfaceName) {
			$className = ltrim($className, '\\');
			$interfaceName = ltrim($interfaceName, '\\');

			$interfaces = class_implements($className);

			$res = array_key_exists($interfaceName, $interfaces);

			return $res;
		}

		public function requireArray(array $____files____, array $____args____ = []) {
			extract($____args____, EXTR_PREFIX_SAME, 'NEW_');

			foreach ($____files____ as $____file____) {
				require $____file____;
			}
		}

		public function requireDir(string $dir, array $args, bool $recursive = NULL) {
			$pattern = realpath($dir) . DIRECTORY_SEPARATOR . '*.php';
			$files = $recursive ? $this->globRecursive($pattern) : glob($pattern);
			$this->requireArray($files, $args);
		}

		public function globRecursive($pattern, $flags = 0) {
			$ds = DIRECTORY_SEPARATOR;
			$files = glob($pattern, $flags);

			$patternBase = basename($pattern);
			$patternDir = dirname($pattern) . $ds;

			foreach (glob($patternDir . '*', GLOB_ONLYDIR) as $dir) {
				$subDir = $dir . $ds . $patternBase;
				$subFiles = $this->globRecursive($subDir, $flags);

				foreach ($subFiles as $subFile) {
					$files[] = $subFile;
				}
			}

			return $files;
		}
	}
}