<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;
	use PHPCraftdream\NirvanaPHP\Framework\FrameworkException;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;

	class BuildTables extends Command {
		protected function configure() {
			$this
				->setName('BuildTables')
				->setDescription('Duild enrirty tables');

			$this->addArgument('entity', InputArgument::OPTIONAL,
				'entity name', NULL);
		}

		protected function execute(InputInterface $input, OutputInterface $output) {
			$app = $this->app;

			if (!$app->isApp()) {
				throw new FrameworkException("Serve command is only for application");
			}

			$entityHub = $app->getEntityHub();

			$factoryForEntity = $app->getFactoryForEntity();
			$tableConstructor = $factoryForEntity->getTableConstructor();

			$entityHub->iterate(function (EntityInterface $entity) use ($tableConstructor) {
				$tableConstructor->constructTable($entity);
			});
		}
	}
}