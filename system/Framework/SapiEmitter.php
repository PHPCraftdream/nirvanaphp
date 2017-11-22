<?php

namespace PHPCraftdream\NirvanaPHP\Framework {

	use Psr\Http\Message\ResponseInterface;
	use Zend\Diactoros\Response\EmitterInterface;

	class SapiEmitter
		extends \Zend\Diactoros\Response\SapiEmitter
		implements EmitterInterface {
		public function emit(ResponseInterface $response, $maxBufferLevel = null) {
			parent::emit($response, $maxBufferLevel);
			flush();
		}
	}
}