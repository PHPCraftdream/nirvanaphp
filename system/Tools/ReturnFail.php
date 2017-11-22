<?php

namespace PHPCraftdream\NirvanaPHP\Tools {

	trait ReturnFail {
		protected $failMessage = NULL;

		protected function fail(string $failMessage): bool {
			$this->failMessage = $failMessage;

			return false;
		}

		public function getFailMessage() {
			return $this->failMessage;
		}
	}
}