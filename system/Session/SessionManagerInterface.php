<?php

namespace PHPCraftdream\NirvanaPHP\Session {
	interface SessionManagerInterface {
		public function start();

		public function getSessionKeyName();

		public function getSessionId(): string;

		public function setValue(string $name, $value);
	}
}
