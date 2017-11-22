<?php

use \PHPUnit\Framework\TestCase;
use \PHPCraftdream\NirvanaPHP\Tools\SetupParent;
use \PHPCraftdream\NirvanaPHP\Tools\SetupParentInterface;


class SetupParentTest extends TestCase implements HelperTestInterface
{
	use \PHPCraftdream\TestCase\tTestCase;

	protected $obj;

	protected function getSetupParent(): SetupParentInterface
	{
		if (empty($this->obj))
		{
			$app = new class (__DIR__ . DIRECTORY_SEPARATOR . 'tmp') extends  PHPCraftdream\NirvanaPHP\App
			{

			};

			$this->obj = new class ($app) extends SetupParent
			{

			};
		}

		return $this->obj;
	}


	public function test1()
	{
		$this->assertTrue(true);
		$obj = $this->getSetupParent();
	}
}