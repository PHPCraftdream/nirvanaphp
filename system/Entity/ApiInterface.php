<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use Psr\Http\Message\RequestInterface;
	use Psr\Http\Message\ResponseInterface;

	Interface ApiInterface {
		public function page(RequestInterface $request, ResponseInterface $response);

		public function create(RequestInterface $request, ResponseInterface $response);

		public function read(RequestInterface $request, ResponseInterface $response);

		public function update(RequestInterface $request, ResponseInterface $response);

		public function delete(RequestInterface $request, ResponseInterface $response);
	}
}