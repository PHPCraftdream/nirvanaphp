<?php

use \PHPUnit\Framework\TestCase;
use \PHPCraftdream\NirvanaPHP\Tools\Helper;
use \PHPCraftdream\NirvanaPHP\Tools\HelperInterface;

interface HelperTestInterface
{
}

class HelperTest extends TestCase implements HelperTestInterface
{
	use \PHPCraftdream\TestCase\tTestCase;

	protected $obj;

	protected function getHelper(): HelperInterface
	{
		if (empty($this->obj))
			$this->obj = new Helper();

		return $this->obj;
	}

	public function testNewDir()
	{
		$obj = $this->getHelper();
		$fs = $obj->newFileSystem(__DIR__);

		$content1 = file_get_contents(__FILE__);
		$content2 = $fs->read(basename(__FILE__));

		$this->assertEquals($content1, $content2);
	}

	public function testCheckInterface()
	{
		$obj = $this->getHelper();

		$this->assertTrue($obj->checkInterface('HelperTest', 'HelperTestInterface'));
		$this->assertFalse($obj->checkInterface('HelperTest', 'HelperTestInterface2'));
	}

	protected $loadedPhpFile = [];
	public function loadedPhpFile(string $log)
	{
		$this->loadedPhpFile[] = $log;
	}

	protected function phpFile0()
	{
		return '<?php $tester->loadedPhpFile("wow");';
	}

	protected function phpFile1()
	{
		return '<?php $tester->loadedPhpFile("hello");';
	}

	protected function phpFile2()
	{
		return '<?php $tester->loadedPhpFile("World");';
	}

	protected function makeTestFiles()
	{
		$ds = DIRECTORY_SEPARATOR;

		$dir = join($ds, [__DIR__, 'tmp', 'helper']) . $ds;
		if (!is_dir($dir)) $this->assertTrue(mkdir($dir, 0777, true));

		$dir1 = join($ds, [__DIR__, 'tmp', 'helper', 'dir1']) . $ds;
		if (!is_dir($dir1)) $this->assertTrue(mkdir($dir1, 0777, true));

		$dir2 = join($ds, [__DIR__, 'tmp', 'helper', 'dir2']) . $ds;
		if (!is_dir($dir2)) $this->assertTrue(mkdir($dir2, 0777, true));

		$file0 = $dir . 'file0.php';
		$file1 = $dir1 . 'file1.php';
		$file2 = $dir2 . 'file2.php';

		$res0 = file_put_contents($file0, $this->phpFile0());
		$this->assertTrue(!!$res0);

		$res1 = file_put_contents($file1, $this->phpFile1());
		$this->assertTrue(!!$res1);

		$res2 = file_put_contents($file2, $this->phpFile2());
		$this->assertTrue(!!$res2);

		return [$file0, $file1, $file2, $dir, $dir1, $dir2];
	}

	public function testRequireArray()
	{
		list ($file0, $file1, $file2, $dir, $dir1, $dir2) = $this->makeTestFiles();

		$obj = $this->getHelper();
		$obj->requireArray([$file1, $file2, $file0], ['tester' => $this]);

		$this->assertEquals(['hello', 'World', 'wow'], $this->loadedPhpFile);
	}

	public function testGlobRecursive()
	{
		$ds = DIRECTORY_SEPARATOR;

		list ($file0, $file1, $file2, $dir, $dir1, $dir2) = $this->makeTestFiles();
		$obj = $this->getHelper();

		$res = $obj->globRecursive($dir . '*.php');

		$exp = [
			$dir . 'file0.php',
			$dir . 'dir1' . $ds . 'file1.php',
			$dir . 'dir2' . $ds . 'file2.php',
		];

		$this->assertEquals($exp, $res);
	}

	public function testRequireDir()
	{
		$ds = DIRECTORY_SEPARATOR;

		list ($file0, $file1, $file2, $dir, $dir1, $dir2) = $this->makeTestFiles();
		$obj = $this->getHelper();

		$this->loadedPhpFile = [];
		$obj->requireDir($dir, ['tester' => $this], false);
		$this->assertEquals(['wow'], $this->loadedPhpFile);

		$this->loadedPhpFile = [];
		$obj->requireDir($dir, ['tester' => $this], true);
		$this->assertEquals(['wow', 'hello', 'World'], $this->loadedPhpFile);
	}

	public function testNewFileSystem()
	{
		list ($file0, $file1, $file2, $dir, $dir1, $dir2) = $this->makeTestFiles();
		$obj = $this->getHelper();
		$fs = $obj->newFileSystem($dir);
		$list = $fs->listContents('', true);

		$res = [];

		foreach ($list as $item)
			$res[] = $item['path'];

		$exp = ['dir1', 'dir1/file1.php', 'dir2', 'dir2/file2.php', 'file0.php'];

		$this->assertEquals($exp, $res);

		$this->assertTrue(unlink($file0));
		$this->assertTrue(unlink($file1));
		$this->assertTrue(unlink($file2));
	}
}