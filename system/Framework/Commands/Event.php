<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;

	class Event extends Command {
		protected function configure() {
			$this
				->setName('event')
				->setDescription('Emit event by name');

			$this->addArgument('eventName', InputArgument::REQUIRED, 'Event name');
			$this->addArgument('params', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Params');
		}

		protected function execute(InputInterface $input, OutputInterface $output) {
			$app = $this->app;

			$eventName = $input->getArgument('eventName');
			$params = $input->getArgument('params');

			$es = $app->getEventsSystem();

			$output->writeln('Process...');

			$es->emit($eventName, $params, $output);

			$output->writeln('Done.');
		}
	}
}