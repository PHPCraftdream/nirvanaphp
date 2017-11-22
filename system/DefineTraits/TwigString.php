<?php

namespace PHPCraftdream\NirvanaPHP\DefineTraits {

	use PHPCraftdream\NirvanaPHP\Bridges\Twig\Environment;
	use PHPCraftdream\NirvanaPHP\Bridges\Twig\EnvironmentInterface;
	use Twig_Extension_Debug;
	use Twig_Loader_String;

	trait TwigString {
		protected $twigString;

		public function getTwigString(): EnvironmentInterface {
			if (!empty($this->twigString)) {
				return $this->twigString;
			}

			$loader = new Twig_Loader_String();
			$twigString = new Environment($loader, ['debug' => true, 'cache' => false]);
			$twigString->addExtension(new Twig_Extension_Debug());
			$this->twigString = $twigString;

			return $twigString;
		}
	}
}