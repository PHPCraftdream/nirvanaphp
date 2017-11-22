<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Tools\Config as ToolsConfig;
	use PHPCraftdream\NirvanaPHP\Tools\ConfigInterface;

	trait Config {
		use FrameworkTrait;

		protected $appConfigDb;

		public function appConfigDb(): ConfigInterface {
			if (empty($this->appConfigDb)) {
				$this->appConfigDb = $this->newConfig('DB');
			}

			return $this->appConfigDb;
		}

		protected $appConfigEnv;

		public function appConfigEnv(): ConfigInterface {
			if (empty($this->appConfigEnv)) {
				$this->appConfigEnv = $this->newConfig('ENV');
			}

			return $this->appConfigEnv;
		}

		protected $configs;

		public function appGetConfigByName(string $name): ConfigInterface {
			if (empty($this->configs)) {
				$this->configs = (object)[];
			}

			if (empty($this->configs->{$name})) {
				$this->configs->{$name} = $this->newConfig($name);
			}

			return $this->configs->{$name};
		}

		public function newConfig(string $name): ConfigInterface {
			$app = $this->getThis();

			$config = new ToolsConfig($name, $app->appConfigDirs());
			$config->share(['app' => $app]);

			return $config;
		}
	}
}