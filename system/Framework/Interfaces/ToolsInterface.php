<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use PHPCraftdream\NirvanaPHP\Bridges\Twig\EnvironmentInterface;
	use PHPCraftdream\NirvanaPHP\Framework\SetupInterface;
	use PHPCraftdream\NirvanaPHP\Tools\DirCopyInterface;
	use PHPCraftdream\NirvanaPHP\Tools\HelperInterface;

	interface ToolsInterface {
		public function getHelper(): HelperInterface;

		public function getSetup(): SetupInterface;

		public function getDirCopy(): DirCopyInterface;

		public static function newAppAutoload(string $appNamespace, string $appSystemDir): callable;

		public static function newAppInit(string $appEnvDir, string $appPublicDir): callable;

		public function getTwigString(): EnvironmentInterface;
	}
}