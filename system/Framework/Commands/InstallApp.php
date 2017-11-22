<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;

	class InstallApp extends Command {
		protected function configure() {
			$this
				->setName('nirvana:install-app')
				->setDescription('Installs NirvanaPHP application');

			$this->addArgument('appDir', InputArgument::REQUIRED,
				'The directory of your application.');

			$this->addArgument('appPublicDir', InputArgument::REQUIRED,
				'The public directory of your application.');

			$this->addArgument('namespace', InputArgument::OPTIONAL,
				'The namespace for your application (default is "App").', 'App');
		}

		protected function execute(InputInterface $input, OutputInterface $output) {
			$appDir = $input->getArgument('appDir');
			$appPublicDir = $input->getArgument('appPublicDir');
			$namespace = $input->getArgument('namespace');

			$output->writeln('Process...');

			$this
				->getApp()
				->getSetup()
				->install($appDir, $appPublicDir, $namespace);

			$output->writeln('Done.');
		}
	}
}