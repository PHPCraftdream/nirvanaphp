<?php

namespace PHPCraftdream\NirvanaPHP\Framework\Interfaces {

	use PHPCraftdream\NirvanaPHP\Framework\RequestResponseDriverInterface;
	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use Zend\Diactoros\Response\EmitterInterface as SapiEmitterInterface;

	interface ServerClientInterface {
		public function getServerRequest(): ServerRequestInterface;

		public function getServerResponse(): ResponseInterface;

		public function getSapiEmitter(): SapiEmitterInterface;

		public function notFound(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

		public function getRequestResponseDriver(): RequestResponseDriverInterface;
	}
}