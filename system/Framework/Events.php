<?php

namespace PHPCraftdream\NirvanaPHP\Framework {
	Interface Events {
		const INSTALL_APP = 'NirvanaPHP.INSTALL_APP';
		const AFTER_INSTALL_APP = 'NirvanaPHP.AFTER_INSTALL_APP';
		const INITED_ROOT = 'NirvanaPHP.INITED_ROOT';
		const INITED_CONSOLE_FRAMEWORK = 'NirvanaPHP.INITED_CONSOLE_FRAMEWORK';
		const INITED_CONSOLE_APP = 'NirvanaPHP.INITED_CONSOLE_APP';
		const INITED_CONSOLE = 'NirvanaPHP.INITED_CONSOLE';
		const BEFORE_ROUTE = 'NirvanaPHP.BEFORE_ROUTE';
		const AFTER_ROUTE = 'NirvanaPHP.AFTER_ROUTE';
		const ROUTE_NOT_FOUND = 'NirvanaPHP.ROUTE_NOT_FOUND';
		const AFTER_EMIT = 'NirvanaPHP.AFTER_EMIT';
		const PUBLISH = 'NirvanaPHP.PUBLISH';
	}
}