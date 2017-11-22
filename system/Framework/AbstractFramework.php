<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use PHPCraftdream\NirvanaPHP\DefineTraits\{
		AppFs, Config, Console, Cookies, DirCopy, EntityHubTrait, EnvInfo, EventsSystem, FrameworkFs
	};
	use PHPCraftdream\NirvanaPHP\DefineTraits\{
		FrameworkTrait, Helper, NewFileSystem, PDOTrait, QueryFactory
	};
	use PHPCraftdream\NirvanaPHP\DefineTraits\{
		FactoryForEntityTrait, ModuleManager, QueryEx, RequestResponseDriver, Router, ServerRequestResponse, Setup, Twig, TwigString, Whoops
	};
	use PHPCraftdream\NirvanaPHP\Session\GetSessionTrait;
	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;

	abstract class AbstractFramework implements FrameworkInterface {
		use FrameworkTrait;
		//====================================================================================
		use AppFs;
		use Config;
		use Console;
		use Cookies;
		use DirCopy;
		use EnvInfo;
		use EventsSystem;
		use FrameworkFs;
		use PDOTrait;
		use Helper;
		use RequestResponseDriver;
		use ServerRequestResponse;
		use Setup;
		use TwigString;
		use Router;
		use QueryFactory;
		use Whoops;
		use QueryEx;
		use EntityHubTrait;
		use NewFileSystem;
		use FactoryForEntityTrait;
		use ModuleManager;
		use GetSessionTrait;

		//====================================================================================

		public function __construct() {

		}

		protected function getThis(): FrameworkInterface {
			return $this;
		}

		//====================================================================================

		abstract protected function defineFrameworkModules();

		abstract protected function defineAppModules();

		abstract public function isApp(): bool;

		abstract public function appDir(): string;

		abstract public function appEnvDir(): string;

		abstract public function frameworkNamespace(): string;

		abstract public function frameworkDir(): string;

		abstract public function notFound(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

		//====================================================================================

		public function run() {
			$requestResponseDriver = $this->getRequestResponseDriver();
			$requestResponseDriver->run();
		}

		//====================================================================================
		protected $appPublicDir = NULL;

		public function appPublicDir(): string {
			return $this->appPublicDir;
		}

		public function appSetPublicDir(string $dir) {
			if (!is_dir($dir)) {
				throw new \InvalidArgumentException("Directory '$dir' not found.");
			}

			$this->appPublicDir = $dir;
		}

		public function appTempDir(): string {
			$ds = DIRECTORY_SEPARATOR;
			$tempDir = $this->appEnvDir() . 'Tmp' . $ds;

			return $tempDir;
		}

		public function appConfigDirs(): array {
			$ds = DIRECTORY_SEPARATOR;

			$appEnvDir = $this->appEnvDir();

			$fwConfigDir = $this->frameworkDir() . 'Config' . $ds;
			$appConfigDir = $this->appDir() . 'Config' . $ds;
			$appEnvConfigDir = $appEnvDir . 'Config' . $ds;
			$appEnvConfigLocalDir = $appEnvDir . 'Config_local' . $ds;

			return [$fwConfigDir, $appConfigDir, $appEnvConfigDir, $appEnvConfigLocalDir];
		}

		protected function requireDir(string $dir, array $args) {
			$helper = $this->getHelper();
			$helper->requireDir($dir, $args, true);
		}

		//====================================================================================
		protected function initRoot() {
			$this->getWhoops();
			$this->defineFrameworkModules();
			$this->getModuleManager()->subscribeEvents();
			$this->getModuleManager()->moduleInit();

			$this->getEventsSystem()->emit(Events::INITED_ROOT);
		}

		protected function setErrorLogsForConsole() {
			ini_set('log_errors', 0);
			ini_set('display_errors', 0);
		}

		public function initConsole() {
			$this->setErrorLogsForConsole();
			$this->initRoot();
			$this->getModuleManager()->registerConsoleCommands();

			$this->getEventsSystem()->emit(Events::INITED_CONSOLE);
		}

		public function initAppCore() {
			$this->initRoot();
			$this->defineAppModules();
			$this->getModuleManager()->registerRoutes();
		}

		//====================================================================================
		public static function newAppAutoload(string $appNamespace, string $appSystemDir): callable {
			$ns = $appNamespace;
			$ns = trim($ns, '\\') . '\\';
			$nsLen = strlen($ns);

			$autoload = function ($className) use ($ns, $nsLen, $appSystemDir) {
				if (strlen($className) <= $nsLen) {
					return;
				}

				if (substr($className, 0, $nsLen) !== $ns) {
					return;
				}

				$name = substr($className, $nsLen);
				$path = str_ireplace(['\\', '/'], DIRECTORY_SEPARATOR, $name);
				$fullPath = $appSystemDir . $path . ".php";

				if (!is_file($fullPath)) {
					return;
				}

				require_once $fullPath;
			};

			return $autoload;
		}

		public static function newAppInit(string $appEnvDir, string $appPublicDir): callable {
			$appInit = function (string $envDir = NULL, string $publicDir = NULL) use ($appEnvDir, $appPublicDir) {
				$envDir = empty($envDir) ? $appEnvDir : $envDir;
				$envDir = realpath($envDir) . DIRECTORY_SEPARATOR;

				$publicDir = empty($publicDir) ? $appPublicDir : $publicDir;
				$publicDir = realpath($publicDir) . DIRECTORY_SEPARATOR;

				$file = $envDir . 'init.php';

				if (!is_dir($envDir)) {
					throw new FrameworkException("Directory not found: $envDir");
				}

				if (!is_file($file)) {
					throw new FrameworkException("File not found: $file");
				}

				$loadInit = function ($envDir, $publicDir) {
					return require $envDir . 'init.php';
				};

				return $loadInit($envDir, $publicDir);
			};

			return $appInit;
		}
		//====================================================================================
	}
}