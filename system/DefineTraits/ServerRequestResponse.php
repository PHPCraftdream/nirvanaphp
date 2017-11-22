<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use Zend\Diactoros\Response;
	use Zend\Diactoros\Response\EmitterInterface;
	use Zend\Diactoros\Response\SapiEmitter;
	use Zend\Diactoros\ServerRequestFactory;

	trait ServerRequestResponse {
		protected $sapiEmitter;

		public function getSapiEmitter(): EmitterInterface {
			if (!empty($this->sapiEmitter)) {
				return $this->sapiEmitter;
			}

			$sapiEmitter = new SapiEmitter();
			$this->sapiEmitter = $sapiEmitter;

			return $sapiEmitter;
		}

		protected $serverRequest;

		public function getServerRequest(): ServerRequestInterface {
			if (!empty($this->serverRequest)) {
				return $this->serverRequest;
			}

			$serverRequest = ServerRequestFactory::fromGlobals(
				$_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
			);

			$this->serverRequest = $serverRequest;

			return $serverRequest;
		}

		protected $serverResponse;

		public function getServerResponse(): ResponseInterface {
			if (!empty($this->serverResponse)) {
				return $this->serverResponse;
			}

			$serverResponse = new Response();
			$this->serverResponse = $serverResponse;

			return $serverResponse;
		}
	}
}