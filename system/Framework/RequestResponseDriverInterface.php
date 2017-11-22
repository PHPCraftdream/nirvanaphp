<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;

	interface RequestResponseDriverInterface {
		public function setResponse(ResponseInterface $response): RequestResponseDriverInterface;

		public function getResponse(): ResponseInterface;

		public function setRequest(ServerRequestInterface $request): RequestResponseDriverInterface;

		public function getRequest(): ServerRequestInterface;

		public function run();
	}
}