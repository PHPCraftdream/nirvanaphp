<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Tools\DirCopy as ToolsDirCopy;
	use PHPCraftdream\NirvanaPHP\Tools\DirCopyInterface;

	trait DirCopy {
		protected $toolsDirCopy;

		public function getDirCopy(): DirCopyInterface {
			if (empty($this->toolsDirCopy)) {
				$this->toolsDirCopy = new ToolsDirCopy();
			}

			return $this->toolsDirCopy;
		}
	}
}