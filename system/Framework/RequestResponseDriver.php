<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use Exception;
	use League\Event\EmitterInterface;
	use League\Route\Http\Exception\NotFoundException;
	use League\Route\RouteCollectionInterface;
	use PHPCraftdream\FigCookies\CookiesInterface;
	use Psr\Http\Message\ResponseInterface;
	use Psr\Http\Message\ServerRequestInterface;
	use Zend\Diactoros\Response\EmitterInterface as ResponseEmitterInterface;

	class RequestResponseDriver implements RequestResponseDriverInterface {
		protected $app = NULL;
		protected $response = NULL;
		protected $request = NULL;
		protected $events = NULL;
		protected $router = NULL;
		protected $sapiEmitter = NULL;
		protected $cookies = NULL;

		public function __construct(FrameworkInterface $app) {
			$this->app = $app;
		}

		public function getApp(): FrameworkInterface {
			return $this->app;
		}

		public function getEvents(): EmitterInterface {
			return $this->events;
		}

		public function getRouter(): RouteCollectionInterface {
			return $this->router;
		}

		public function getSapiEmitter(): ResponseEmitterInterface {
			return $this->sapiEmitter;
		}

		public function getCookies(): CookiesInterface {
			return $this->cookies;
		}

		protected function writeCookies() {
			$this->response = $this->getCookies()->toResponse($this->getResponse());
		}

		protected function readCookies() {
			$this->getCookies()->fromRequest($this->getRequest());
		}

		public function setResponse(ResponseInterface $response): RequestResponseDriverInterface {
			$this->response = $response;

			return $this;
		}

		public function getResponse(): ResponseInterface {
			return $this->response;
		}

		public function setRequest(ServerRequestInterface $request): RequestResponseDriverInterface {
			$this->request = $request;

			return $this;
		}

		public function getRequest(): ServerRequestInterface {
			return $this->request;
		}

		protected function loadServices() {
			$app = $this->getApp();

			$app->initAppCore();

			$this->cookies = $app->getCookies();
			$this->router = $app->getRouter();
			$this->request = $app->getServerRequest();
			$this->response = $app->getServerResponse();
			$this->events = $app->getEventsSystem();
			$this->sapiEmitter = $app->getSapiEmitter();
		}

		public function run() {
			$this->loadServices();
			$this->readCookies();
			$events = $this->getEvents();

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$events->emit(Events::BEFORE_ROUTE, $this);

			try {
				/** @noinspection PhpUndefinedMethodInspection */
				$this->response = $this->getRouter()->dispatch($this->request, $this->response);
			}
			catch (NotFoundException $e) {
				$this->notFound($e);
			}

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$events->emit(Events::AFTER_ROUTE, $this);

			$this->writeCookies();

			/** @noinspection PhpUndefinedMethodInspection */
			$this->sapiEmitter->emit($this->response);

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$events->emit(Events::AFTER_EMIT, $this);
		}

		protected function notFound(Exception $e) {
			$this->response = $this->getResponse()->withStatus(404);

			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$this->getEvents()->emit(Events::ROUTE_NOT_FOUND, $this->router, $this);

			if ($this->getResponse()->getBody()->getSize() === 0) {
				$app = $this->getApp();
				$response = $app->notFound($this->request, $this->response);
				$this->response = $response;
			}

			if ($this->getResponse()->getBody()->getSize() === 0) {
				throw $e;
			}
		}
	}
}