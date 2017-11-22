<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\FilesystemInterface as FsI;
	use PHPCraftdream\NirvanaPHP\DefineTraits\DirCopy as DirCopyTrait;
	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;
	use Twig_Environment;

	abstract class SetupParent
		implements SetupParentInterface {
		use DirCopyTrait;
		use NewFileSystem;

		protected $app;
		protected $frameworkDir;

		public function __construct(FrameworkInterface $app) {
			$this->app = $app;
			$this->frameworkDir = $app->frameworkDir();
		}

		protected function getApp(): FrameworkInterface {
			return $this->app;
		}

		protected $twigString;

		protected function getTwigString(): Twig_Environment {
			if (!empty($this->twigString)) {
				return $this->twigString;
			}

			$app = $this->getApp();

			$this->twigString = $app->getTwigString();
			$this->twigString->addFunction(
				new \Twig_SimpleFunction(
					'randomString',
					function ($len = 32) {
						$bytes = random_bytes($len);
						return bin2hex($bytes);
					}
				)
			);

			return $this->twigString;
		}

		const TPL_EXT = 'install_tpl';

		public function processTemplate(FsI $from, FsI $to, array &$item, string $content, array $data) {
			$twigString = $this->getTwigString();

			$item['new_path_original'] = $item['new_path'];
			$item['new_path'] = $twigString->render($item['new_path'], $data);

			if (empty($item['extension'])) {
				return $content;
			}

			if (strtolower($item['extension']) !== self::TPL_EXT) {
				return $content;
			}

			$item['new_path'] = substr($item['new_path'], 0, -strlen(self::TPL_EXT) - 1);

			$content = $twigString->render($content, $data);

			return $content;
		}

		public function getProcessTemplate(): callable {
			return [$this, 'processTemplate'];
		}
	}
}