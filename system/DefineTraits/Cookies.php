<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\FigCookies\Cookies as FigCookies;
	use PHPCraftdream\FigCookies\CookiesInterface;

	trait Cookies {
		protected $cookies;

		public function getCookies(): CookiesInterface {
			if (empty($this->cookies)) {
				$this->cookies = new FigCookies();
			}

			return $this->cookies;
		}
	}
}