<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Commands {

	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;
	use Symfony\Component\Console\Question\Question;

	abstract class Command extends \Symfony\Component\Console\Command\Command {
		protected $app = NULL;

		public function __construct(\PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface $app) {
			$this->app = $app;
			parent::__construct();
		}

		public function getApp(): \PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface {
			return $this->app;
		}

		protected $commandsBoolQuestions = [];

		protected function askBool(string $qText, bool $default, InputInterface $input, OutputInterface $output): bool {
			$defaultText = $default ? 'y' : 'n';
			$question = new Question($qText . " (y/n) [$defaultText]:", $defaultText);

			$helper = $this->getHelper('question');
			$ans = $helper->ask($input, $output, $question);

			$res = strtolower(trim($ans)) === 'y';

			unset($question);

			return $res;
		}
	}
}