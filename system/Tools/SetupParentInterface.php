<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	use League\Flysystem\FilesystemInterface as FsInt;

	interface SetupParentInterface {
		public function processTemplate(FsInt $from, FsInt $to, array &$item, string $content, array $data);

		public function getProcessTemplate(): callable;
	}
}