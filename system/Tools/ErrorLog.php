<?
namespace PHPCraftdream\ErrorLog;

class ErrorLog {
	public $reportingFlags = 0xffffffff;
	public $noLoggerTriggersException = '\PHPCraftdream\ErrorLog\NoLoggerTriggers';
	public $unhandledErrorException = '\PHPCraftdream\ErrorLog\UnhandledError';

	public function init() {
		$reporting = $this->reportingFlags;

		ini_set("log_errors", 'Off');
		ini_set("error_log", NULL);
		ini_set('display_errors', 'Off');
		ini_set('error_reporting', $reporting);

		set_error_handler([$this, 'onError'], $reporting);
		set_exception_handler([$this, 'onException']);
		register_shutdown_function([$this, 'onFatalError']);
	}

	public function onFatalError() {
		$error = error_get_last();

		if (empty($error)) return;
		if (empty($error['type'])) return;

		$type = $error['type'];
		$fatalErrors = [\E_ERROR => 1, \E_PARSE => 1, \E_CORE_ERROR => 1, \E_CORE_WARNING => 1, \E_COMPILE_ERROR => 1, \E_COMPILE_WARNING => 1];

		if (empty($fatalErrors[$type])) return;

		$write = print_r($error, true);
		$this->lestLogError(__FUNCTION__, $write, true);

		return true;
	}

	public function onException($exception) {
		$write = print_r($exception, true);
		$this->lestLogError(__FUNCTION__, $write);
	}

	public function onError($errno = NULL, $errstr = NULL, $errfile = NULL, $errline = NULL) {
		$error = [
			'errno' => $errno,
			'errstr' => $errstr,
			'errfile' => $errfile,
			'errline' => $errline,
		];

		$unhandledErrorException = $this->unhandledErrorException;

		throw new $unhandledErrorException($error);
	}

	public function lestLogError($name, $write, $fatal = false) {
		if (!$this->emptyEventTriggers('logError'))
			return $this->event('logError', [$name, $write]);

		if (!empty($fatal))
			return $this->exitWithMessage("NO_LOGGER_TRIGGERS! $name:" . PHP_EOL . PHP_EOL . $write);

		$noLoggerTriggersException = $this->noLoggerTriggersException;
		throw new $noLoggerTriggersException("NO_LOGGER_TRIGGERS");
	}

	public function exitWithMessage($mess) {
		echo PHP_EOL . PHP_EOL . $mess . PHP_EOL . PHP_EOL;

		$this->justExit();
	}

	public function justExit() {
		exit;
	}
}