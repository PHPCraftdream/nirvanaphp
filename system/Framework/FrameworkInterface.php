<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use PHPCraftdream\NirvanaPHP\Framework\Interfaces\{
		AppConfigInterface, AppInterface, DbInterface, DirsInterface, FsInterface, ServerClientInterface, ToolsInterface
	};
	use PHPCraftdream\NirvanaPHP\Framework\Interfaces\{
		WorkspaceInterface
	};
	use PHPCraftdream\NirvanaPHP\Framework\Module\GetModuleManagerInterface;
	use PHPCraftdream\NirvanaPHP\Session\GetSessionInterface;

	interface FrameworkInterface
		extends
		AppInterface,
		DirsInterface,
		FsInterface,
		AppConfigInterface,
		ServerClientInterface,
		DbInterface,
		ToolsInterface,
		GetModuleManagerInterface,
		GetSessionInterface,
		WorkspaceInterface {

	}
}