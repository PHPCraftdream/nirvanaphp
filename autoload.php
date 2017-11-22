<?php

namespace PHPCraftdream\NirvanaPHP
{
	const DS = DIRECTORY_SEPARATOR;

	const FRAMEWORK_DIR = __DIR__ . DS;
	const FRAMEWORK_NAMESPACE = 'PHPCraftdream\\NirvanaPHP\\';
	const FRAMEWORK_SYSTEM_DIR = FRAMEWORK_DIR . 'system' . DS;
	const FRAMEWORK_VENDOR_DIR = FRAMEWORK_DIR . 'vendor' . DS;

	call_user_func_array(
		function ()
		{
			require_once FRAMEWORK_VENDOR_DIR . 'autoload.php';

			$nsLen = strlen(FRAMEWORK_NAMESPACE);

			$autoload = function ($className) use ($nsLen)
			{
				if (strlen($className) <= $nsLen) return;
				if (substr($className, 0, $nsLen) !== FRAMEWORK_NAMESPACE) return;

				$name = substr($className, $nsLen);

				$path = str_ireplace(['\\', '/'], DS, $name);

				$fullPath = FRAMEWORK_SYSTEM_DIR . $path . '.php';

				if (!is_file($fullPath)) return;

				require_once $fullPath;
			};

			spl_autoload_register($autoload, true, true);
		},
		array()
	);
}