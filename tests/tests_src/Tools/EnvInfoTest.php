<?php

use \PHPUnit\Framework\TestCase;
use \PHPCraftdream\NirvanaPHP\Tools\EnvInfo;
use \PHPCraftdream\NirvanaPHP\Tools\EnvException;

class EnvInfoTest extends TestCase
{
	use \PHPCraftdream\TestCase\tTestCase;

	/**
	 * @expectedException \PHPCraftdream\NirvanaPHP\Tools\EnvException
	 */
	public function testGetEnv()
	{
		$obj = new EnvInfo([]);

		$this->assertFalse($obj->envIsset());

		$obj->getEnv();
	}

	public function testSetEnvDev()
	{
		$obj = new EnvInfo([]);

		$this->assertFalse($obj->envIsset());
		$obj->setEnvDev();
		$this->assertTrue($obj->envIsset());

		$this->assertTrue($obj->envIsDev());
		$this->assertFalse($obj->envIsTest());
		$this->assertFalse($obj->envIsProd());

		try
		{
			$obj->setEnvDev();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvTest();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvProd();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}
	}

	public function testSetEnvTest()
	{
		$obj = new EnvInfo([]);

		$this->assertFalse($obj->envIsset());
		$obj->setEnvTest();
		$this->assertTrue($obj->envIsset());

		$this->assertFalse($obj->envIsDev());
		$this->assertTrue($obj->envIsTest());
		$this->assertFalse($obj->envIsProd());

		try
		{
			$obj->setEnvDev();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvTest();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvProd();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}
	}

	public function testSetEnvProd()
	{
		$obj = new EnvInfo([]);

		$this->assertFalse($obj->envIsset());
		$obj->setEnvProd();
		$this->assertTrue($obj->envIsset());

		$this->assertFalse($obj->envIsDev());
		$this->assertFalse($obj->envIsTest());
		$this->assertTrue($obj->envIsProd());

		try
		{
			$obj->setEnvDev();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvTest();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}

		try
		{
			$obj->setEnvProd();
			$this->fail('wtf?');
		}
		catch (EnvException $e)
		{
		}
	}

	public function testSapiName()
	{
		$obj = new EnvInfo([]);

		$this->assertEquals(php_sapi_name(), $obj->sapiName());
	}

	public function testGetServer()
	{
		$obj = new EnvInfo(['a' => 'qwe']);
		$this->assertEquals(['a' => 'qwe'], $obj->getServer());

		$this->setProp($obj, 'server', ['a' => 'zxc']);
		$this->assertEquals(['a' => 'zxc'], $obj->getServer());
	}

	public function testIsCli()
	{
		$obj = $this->createPartialMock(EnvInfo::class, ['sapiName']);

		$obj->expects($this->at(0))->method('sapiName')->willReturn('foo');
		$obj->expects($this->at(1))->method('sapiName')->willReturn('cli');

		$this->assertFalse($obj->isConsole());
		$this->assertTrue($obj->isConsole());
	}

	public function testIsAjax()
	{
		$obj = $this->createPartialMock(EnvInfo::class, ['isConsole', 'getServer']);
		$obj->expects($this->once())->method('isConsole')->willReturn(true);
		$obj->expects($this->never())->method('getServer');
		$this->assertFalse($obj->isAjax());
		$this->assertEquals('console', $obj->getFailMessage());

		$obj = $this->createPartialMock(EnvInfo::class, ['isConsole', 'getServer']);
		$obj->expects($this->once())->method('isConsole')->willReturn(false);
		$obj->expects($this->once())->method('getServer')->willReturn([]);
		$this->assertFalse($obj->isAjax());
		$this->assertEquals('empty', $obj->getFailMessage());

		$obj = $this->createPartialMock(EnvInfo::class, ['isConsole', 'getServer']);
		$obj->expects($this->once())->method('isConsole')->willReturn(false);
		$obj->expects($this->once())->method('getServer')->willReturn(['HTTP_X_REQUESTED_WITH' => 'qwe']);
		$this->assertFalse($obj->isAjax());
		$this->assertEquals('XMLHttpRequest', $obj->getFailMessage());

		$obj = $this->createPartialMock(EnvInfo::class, ['isConsole', 'getServer']);
		$obj->expects($this->once())->method('isConsole')->willReturn(false);
		$obj->expects($this->once())->method('getServer')->willReturn(['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest']);
		$this->assertTrue($obj->isAjax());
	}
}