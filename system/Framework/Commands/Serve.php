<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use PHPCraftdream\NirvanaPHP\Framework\FrameworkException;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;
	use Symfony\Component\Process\ProcessUtils;

	class Serve extends Command {
		protected function configure() {
			$this
				->setName('serve')
				->setDescription('Starts NirvanaPHP server');

			$this->addArgument('host', InputArgument::OPTIONAL,
				'server host', 'localhost');

			$this->addArgument('port', InputArgument::OPTIONAL,
				'server port', '8000');

			$app = $this->app;
			$this->addArgument('publicDir', InputArgument::OPTIONAL,
				'server port', $app->appPublicDir());
		}

		protected function execute(InputInterface $input, OutputInterface $output) {
			$app = $this->app;

			if (!$app->isApp())
				throw new FrameworkException("Serve command is only for application");

			$host = $input->getArgument('host');
			$port = $input->getArgument('port');
			$publicDir = $app->appPublicDir();
			$indexFile = $publicDir . 'index.php';

			$hostPortEsc = ProcessUtils::escapeArgument("{$host}:{$port}");
			$publicDirEsc = ProcessUtils::escapeArgument($publicDir);
			$indexFileEsc = ProcessUtils::escapeArgument($indexFile);

			$output->writeln("NirvanaPHP development server started on <info>http://{$host}:{$port}/</info>");
			$output->writeln("Doc root: <info> $publicDir </info>");

			$cmd = "php -S $hostPortEsc -t $publicDirEsc $indexFileEsc";

			passthru($cmd);
		}
	}
}