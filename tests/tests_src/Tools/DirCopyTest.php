<?php

use \PHPUnit\Framework\TestCase;

use \PHPCraftdream\NirvanaPHP\Tools\DirCopy;
use \PHPCraftdream\NirvanaPHP\Tools\DirCopyInterface;
use \League\Flysystem\Filesystem;
use \League\Flysystem\FilesystemInterface;
use \League\Flysystem\Adapter\Local;

class DirCopyTest extends TestCase
{
	protected $obj = NULL;
	protected $fs = [];

	public function getObj(): DirCopyInterface
	{
		if (empty($this->obj))
			$this->obj = new DirCopy();

		return $this->obj;
	}

	public function getFs(... $pathItems): FilesystemInterface
	{
		$dir = join(DIRECTORY_SEPARATOR, $pathItems);

		if (empty($this->fs[$dir]))
			$this->fs[$dir] = new Filesystem(new Local($dir));

		return $this->fs[$dir];
	}

	//-----------------------------------------------------------------------------

	public function testEmptyCall()
	{
		try
		{
			$this->getObj()->reset();
			$this->getObj()->run();

			$this->fail('wtf?');
		}
		catch (TypeError $e)
		{
			$this->assertTrue(true);
		}
	}

	public function testCopy()
	{
		$fs1 = $this->getFs(__DIR__, 'tmp', 'dir_copy', 'dir1');
		$fs2 = $this->getFs(__DIR__, 'tmp', 'dir_copy', 'dir2');
		$fs3 = $this->getFs(__DIR__, 'tmp', 'dir_copy', 'dir3');

		$fs1->put('/path1/doc1/file_a.txt', 'data1');
		$fs1->put('/path1/doc2/file_b.txt', 'data2');

		$dc = $this->getObj();

		$dc->from($fs1, '/path1/');
		$dc->to($fs2, '/copied_from_fs1/');
		$dc->run();

		$this->assertEquals('data1', $fs2->read('/copied_from_fs1/doc1/file_a.txt'));
		$this->assertEquals('data2', $fs2->read('/copied_from_fs1/doc2/file_b.txt'));

		//---------------------------------------
		$that = $this;

		$modifer = function ($from, $to, array &$item, string $content, array $data) use ($that)
		{
			$that->assertTrue($from instanceof FilesystemInterface);
			$that->assertTrue($to instanceof FilesystemInterface);

			$this->assertArrayHasKey('addExt', $data);
			$this->assertArrayHasKey('new_path', $item);
			$item['new_path'] .= $data['addExt'];

			return $content . '::' . md5($content);
		};

		$data = ['addExt' => '.md5.txt'];

		$dc->from($fs1, '/');
		$dc->to($fs3, '/copied_from_fs1_mod/');
		$dc->run($modifer, $data);

		$this->assertEquals(
			'data1' . '::' . md5('data1'),
			$fs3->read('/copied_from_fs1_mod/path1/doc1/file_a.txt.md5.txt')
		);

		$this->assertEquals(
			'data2' . '::' . md5('data2'),
			$fs3->read('/copied_from_fs1_mod/path1/doc2/file_b.txt.md5.txt')
		);

		$fs1->deleteDir('path1');
		$fs2->deleteDir('copied_from_fs1');
		$fs3->deleteDir('copied_from_fs1_mod');
	}
}
