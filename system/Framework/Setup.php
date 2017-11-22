<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use PHPCraftdream\NirvanaPHP\Tools\SetupParent;

	class Setup extends SetupParent implements SetupInterface {
		protected function getData(string $appDir, string $appPublicDir, string $namespace = NULL): array {
			$ds = DIRECTORY_SEPARATOR;

			if (empty($namespace)) {
				$namespace = 'App';
			}

			$namespaceEscaped = str_replace(['\\', '/'], '\\\\', $namespace);

			$appDir = realpath($appDir) . $ds;
			$appDirEscaped = str_replace('\\', '\\\\', $appDir);

			$appPublicDir = realpath($appPublicDir) . $ds;
			$appPublicDirEscaped = str_replace('\\', '\\\\', $appPublicDir);

			$frameworkDir = realpath($this->frameworkDir) . $ds;
			$frameworkDirEscaped = str_replace('\\', '\\\\', $frameworkDir);

			$data = [
				'fs_namespace' => str_replace(['/', '\\'], '_', $namespace),
				'namespace' => $namespace,
				'namespaceEscaped' => $namespaceEscaped,
				'appDir' => $appDir,
				'appDirEscaped' => $appDirEscaped,
				'appPublicDir' => $appPublicDir,
				'appPublicDirEscaped' => $appPublicDirEscaped,
				'frameworkDir' => $frameworkDir,
				'frameworkDirEscaped' => $frameworkDirEscaped,
				'ds' => $ds,
			];

			return $data;
		}

		public function install(string $appDir, string $appPublicDir, string $namespace = NULL) {
			$data = $this->getData($appDir, $appPublicDir, $namespace);

			$dirCopy = $this->getDirCopy();
			$appFs = $this->newFileSystem($appDir);
			$appPublicFs = $this->newFileSystem($appPublicDir);
			$frameworkFs = $this->getApp()->frameworkFs();

			$processTemplate = $this->getProcessTemplate();

			$dirCopy
				->from($frameworkFs, 'install/App/')
				->to($appFs, '/')
				->run($processTemplate, $data);

			$dirCopy
				->from($frameworkFs, 'install/Public/')
				->to($appPublicFs, '/')
				->run($processTemplate, $data);

			$data['appPublicFs'] = $appPublicFs;
			$data['frameworkFs'] = $frameworkFs;

			$this->afterInstall($data);
		}

		protected function afterInstall(array $data) {
			$es = $this->getApp()->getEventsSystem();

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$es->emit(Events::INSTALL_APP, (object)$data);

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$es->emit(Events::AFTER_INSTALL_APP, (object)$data);
		}
		//====================================================================================
	}
}