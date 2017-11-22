<?php

namespace PHPCraftdream\NirvanaPHP\Bridges\ConsoleApplication;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


interface ConsoleApplicationInterface {
	public function run(InputInterface $input = null, OutputInterface $output = null);

	public function doRun(InputInterface $input, OutputInterface $output);

	public function setHelperSet(HelperSet $helperSet);

	public function getHelperSet();

	public function setDefinition(InputDefinition $definition);

	public function getDefinition();

	public function getHelp();

	public function areExceptionsCaught();

	public function setCatchExceptions($boolean);

	public function isAutoExitEnabled();

	public function setAutoExit($boolean);

	public function getName();

	public function setName($name);

	public function getVersion();

	public function setVersion($version);

	public function getLongVersion();

	public function register($name);

	public function addCommands(array $commands);

	public function add(Command $command);

	public function get($name);

	public function has($name);

	public function getNamespaces();

	public function findNamespace($namespace);

	public function find($name);

	public function all($namespace = null);

	public static function getAbbreviations($names);

	public function renderException(\Exception $e, OutputInterface $output);

	public function getTerminalDimensions();

	public function setTerminalDimensions($width, $height);

	public function setDefaultCommand($commandName, $isSingleCommand = false);
}