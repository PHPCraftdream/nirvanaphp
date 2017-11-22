<?php

use \PHPUnit\Framework\TestCase;

use \PHPCraftdream\NirvanaPHP\Tools\Config;

class ConfigTest extends TestCase
{
	use \PHPCraftdream\TestCase\tTestCase;

	protected $inited = false;
	protected $obj = NULL;
	protected $obj2 = NULL;

	protected $file = 'config';
	protected $dirs = NULL;

	protected function config1()
	{
		return join("\n",
			[
				'<?php',
				'$data["val1"] = 100;',
				'$data["val2"] = 200;',
				'return $data;',
			]
		);
	}

	protected function config2()
	{
		return join("\n",
			[
				'<?php',
				'$data["val1"] = 1000;',
				'$data["val3"] = 2000;',
				'$data["sharedVar"] = $sharedVar;',
				'return $data;',
			]
		);
	}

	protected function init()
	{
		$ds = DIRECTORY_SEPARATOR;

		$dir1 = join($ds, [__DIR__, 'tmp', 'config', 'dir1']) . $ds;
		$dir2 = join($ds, [__DIR__, 'tmp', 'config', 'dir2']) . $ds;

		if (!is_dir($dir1)) $this->assertTrue(mkdir($dir1, 0777, true));
		if (!is_dir($dir2)) $this->assertTrue(mkdir($dir2, 0777, true));

		$res1 = file_put_contents($dir1 . $this->file . '.php', $this->config1());
		$this->assertTrue(!!$res1);

		$res2 = file_put_contents($dir2 . $this->file . '.php', $this->config2());
		$this->assertTrue(!!$res2);

		$this->dirs = [$dir1, $dir2];
		$this->obj = new Config($this->file, $this->dirs);

		$this->obj->share(['sharedVar' => 113]);

		$this->obj2 = new Config(':not_exists:', [':not_exists_1:', ':not_exists_2:']);

		$this->inited = true;
	}

	protected function setUp()
	{
		if ($this->inited) return;

		$this->init();
	}

	//-----------------------------------------------------------------------------

	public function testParams()
	{
		$this->assertEquals($this->file, $this->getProp($this->obj, 'file'));
		$this->assertEquals($this->dirs, $this->getProp($this->obj, 'dirs'));
	}

	public function testDefalutVal()
	{
		$this->assertEquals(NULL, $this->obj->get('DONTEXISTS'));
		$this->assertEquals(15, $this->obj->get('DONTEXISTS_LETS_15', 15));
		$this->assertEquals(15, $this->obj->get('DONTEXISTS_LETS_15'));
	}

	/**
	 * @expectedException \PHPCraftdream\NirvanaPHP\Tools\ConfigException
	 */
	public function testExceptionOnSet()
	{
		$this->obj->DONTEXISTS = 1;
	}

	/**
	 * @expectedException \PHPCraftdream\NirvanaPHP\Tools\ConfigException
	 */
	public function testExceptionOnGet()
	{
		$this->obj->DONTEXISTS;
	}

	/**
	 * @expectedException \PHPCraftdream\NirvanaPHP\Tools\ConfigException
	 */
	public function testDontExistsConfig()
	{
		$this->obj2->get('a');
	}

	public function testAll()
	{
		$this->assertEquals(
			[
				'val1' => 1000,
				'val2' => 200,
				'val3' => 2000,
				'sharedVar' => 113,
			],
			$this->obj->all()
		);

		$this->assertEquals(1000, $this->obj->get('val1'));
		$this->assertEquals(200, $this->obj->get('val2'));
		$this->assertEquals(2000, $this->obj->get('val3'));
		$this->assertEquals(113, $this->obj->get('sharedVar'));
	}
}
