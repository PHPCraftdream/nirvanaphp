<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use PHPCraftdream\NirvanaPHP\Framework\Events;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;


	class Publish extends Command {
		protected function configure() {
			$this
				->setName('publish')
				->setDescription('Publish resources');
		}

		protected function execute(InputInterface $input, OutputInterface $output) {
			$app = $this->app;
			$es = $app->getEventsSystem();

			$output->writeln('Process...');

			$es->emit(Events::PUBLISH);

			$output->writeln('Done.');
		}
	}
}