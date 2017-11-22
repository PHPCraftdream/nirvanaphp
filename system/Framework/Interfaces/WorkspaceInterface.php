<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use League\Route\RouteCollectionInterface;
	use PHPCraftdream\FigCookies\CookiesInterface;
	use PHPCraftdream\NirvanaPHP\Bridges\ConsoleApplication\ConsoleApplicationInterface;
	use Whoops\Handler\HandlerInterface;
	use Whoops\RunInterface;
	use League\Event\EmitterInterface;

	interface WorkspaceInterface {
		public function getConsole(): ConsoleApplicationInterface;

		public function getCookies(): CookiesInterface;

		public function getEventsSystem(): EmitterInterface;

		public function getRouter(): RouteCollectionInterface;

		public function getWhoopsHandler(): HandlerInterface;

		public function getWhoops(): RunInterface;
	}
}