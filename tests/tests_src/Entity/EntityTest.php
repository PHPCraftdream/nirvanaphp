<?php

use Aura\SqlQuery\Common\SelectInterface;
use Aura\SqlQuery\Common\UpdateInterface;
use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntity;
use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
use PHPCraftdream\NirvanaPHP\Entity\Entity;
use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;
use PHPCraftdream\NirvanaPHP\Framework;
use PHPCraftdream\NirvanaPHP\Tools\ConfigRuntime;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase {
	use \PHPCraftdream\TestCase\tTestCase;

	protected $obj;
	protected $objType;

	protected function getObj(): Entity {
		if (!empty($this->obj))
			return $this->obj;

		$app = $this->createPartialMock(Framework::class, []);

		$dbConfig = new ConfigRuntime();
		$dbConfig->setData(\Runtest\TestConfig::$dbConfig);

		$this->setProp($app, 'appConfigDb', $dbConfig);

		$core = new FactoryForEntity($app);
		$entityHub = $core->getEntityHub();

		$this->obj = new class ($core) extends Entity {
			protected $table = 'session';

			public function onSave(SaveDataManagerInterface $dataManager) {
				$saveData = $dataManager->getSaveData();

				$value = $saveData->get('pHash');
				$newVal = md5($value);

				$dataManager->getSaveData()->set('pHash', $newVal);

				$dataManager->appplyRule('pHash', 'eqLength', 32);
			}

			public function onRead(IterateInterface $list) {
				foreach ($list->iterate() as $item) {
					$data = $this->assertEditableContainerInterface($item);
					$data->set('pHashVirtual', 'MD5_ROW_' . $data->get('pHash'));
				}
			}

			public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory) {
				$set->add(
					$factory->newId()
				);

				$len = 32;
				$set->add(
					$factory->newString('sessionId')
						->setLength($len)
						->clearOnCreate()
						->clearOnUpdate()
						->setOnCreate('assertNotExists')
						->setOnCreate('required')
						->setOnCreate('eqLength', $len)
						->setOnUpdate('assertUniqueExists')
						->setOnUpdate('delete')
						->setSqlIndex('UNIQUE (`:name`)')
				);

				$set->add(
					$factory->newForeignKey(
						't_session_type',
						'session_type',
						'type_name'
					)
				);

				$len = 1024 * 8;
				$set->add(
					$factory->newString('pData')
						->setLength($len)
						->clearOnCreate()
						->clearOnUpdate()
						->setOnCreate('serialize')
						->setOnUpdate('serialize')
						->setOnCreate('maxLength', $len)
						->setOnUpdate('maxLength', $len)
						->setOnRead('unserialize')
						->setType('LONGTEXT')
						->setSqlDefault('NULL')
						->setSqlNull(true)
				);

				$len = 32;
				$set->add(
					$factory->newString('pHash')
						->setLength($len)
						->clearOnCreate()
						->clearOnUpdate()
						->setOnCreate('minLength', $len)
						->setOnCreate('maxLength', $len)
						->setOnUpdate('maxLength', $len)
				);

				$set->add(
					$factory->newVirual('pHashVirtual')
				);

				$created = $factory->newInt('dCreated')->clearRules();
				$created->setOnCreate('now')->setOnUpdate('delete');
				$set->add($created);

				$updated = $factory->newInt('dUpdated')->clearRules();
				$updated->setOnCreate('now')->setOnUpdate('now');
				$set->add($updated);

				$isDeleted = $factory->newIsDeleted();
				$set->add($isDeleted);
			}
		};

		$obj = $this->obj;
		$entityHub->define('session',
			function () use ($obj) {
				return $obj;
			}
		);

		$this->objType = new class ($core) extends Entity {
			protected $table = 'session_type';

			public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory) {
				$set->add(
					$factory->newId()
				);

				$len = 32;
				$set->add(
					$factory->newString('type_name')
						->setLength($len)
						->clearOnCreate()
						->clearOnUpdate()
						->setOnSave('minLength', 3)
						->setOnSave('maxLength', $len)
				);
			}
		};

		$objType = $this->objType;
		$entityHub->define('session_type',
			function () use ($objType) {
				return $objType;
			}
		);

		return $this->obj;
	}

	public function testCreateAndContructAndReconstructTable() {
		$obj = $this->getObj();
		$core = $obj->getEntityFactory();
		$table = $obj->getTable();
		$tableConstructor = $core->getTableConstructor();
		$queryEx = $core->getQueryEx();

		$queryEx->ex("DROP TABLE IF EXISTS `$table`;", []);
		$tableConstructor->constructTable($obj);

		//--------------------------------------------------
		$queryEx->ex("ALTER TABLE `$table` DROP INDEX `isDeleted`;", []);
		$indexesExp = [
			['id', 'PRIMARY'],
			['sessionId', 'sessionId'],
			['t_session_type', 't_session_type'],
		];
		$indexes = $obj->getTableIndexes();
		$this->assertEquals($indexesExp, $indexes);

		//--------------------------------------------------
		$tableConstructor->constructTable($obj);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'pData' => 'varchar(8192)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'isDeleted' => 'tinyint(1)',
			'pHash' => 'varchar(32)',
		];

		$indexesExp = [
			['id', 'PRIMARY'],
			['sessionId', 'sessionId'],
			['t_session_type', 't_session_type'],
			['isDeleted', 'isDeleted'],
		];

		$columns = $obj->getTableColumns();
		$indexes = $obj->getTableIndexes();

		$this->assertEquals($columnsExp, $columns);
		$this->assertEquals($indexesExp, $indexes);

		//--------------------------------------------------

		$fieldSet = $obj->getFieldSet();
		$fieldSet->delete('isDeleted');
		$tableConstructor->constructTable($obj);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'pData' => 'varchar(8192)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'pHash' => 'varchar(32)',
		];

		$indexesExp = [
			['id', 'PRIMARY'],
			['sessionId', 'sessionId'],
			['t_session_type', 't_session_type'],
		];

		$columns = $obj->getTableColumns();
		$indexes = $obj->getTableIndexes();

		$this->assertEquals($columnsExp, $columns);
		$this->assertEquals($indexesExp, $indexes);

		//--------------------------------------------------

		$queryEx->ex("ALTER TABLE `$table` DROP COLUMN `pData`;", []);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'pHash' => 'varchar(32)',
		];

		$columns = $obj->getTableColumns();
		$this->assertEquals($columnsExp, $columns);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'pData' => 'varchar(8192)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'pHash' => 'varchar(32)',
		];

		$tableConstructor->constructTable($obj);
		$columns = $obj->getTableColumns();
		$this->assertEquals($columnsExp, $columns);

		//--------------------------------------------------

		$fieldSet->get('pData')->setSqlLength(4096);
		$tableConstructor->constructTable($obj);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'pData' => 'varchar(4096)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'pHash' => 'varchar(32)',
		];

		$columns = $obj->getTableColumns();
		$this->assertEquals($columnsExp, $columns);

		//--------------------------------------------------

		$this->setProp($obj, 'fieldSet', NULL);

		$tableConstructor->constructTable($obj);

		$columnsExp = [
			'id' => 'int(11)',
			'sessionId' => 'varchar(32)',
			't_session_type' => 'int(11)',
			'pData' => 'varchar(8192)',
			'dCreated' => 'int(11)',
			'dUpdated' => 'int(11)',
			'isDeleted' => 'tinyint(1)',
			'pHash' => 'varchar(32)',
		];

		$indexesExp = [
			['id', 'PRIMARY'],
			['sessionId', 'sessionId'],
			['t_session_type', 't_session_type'],
			['isDeleted', 'isDeleted'],
		];

		$columns = $obj->getTableColumns();
		$indexes = $obj->getTableIndexes();

		$this->assertEquals($columnsExp, $columns);
		$this->assertEquals($indexesExp, $indexes);

		//--------------------------------------------------------------------

		$objType = $this->getObjType();
		$core = $objType->getEntityFactory();
		$table = $objType->getTable();
		$tableConstructor = $core->getTableConstructor();
		$queryEx = $core->getQueryEx();

		$queryEx->ex("DROP TABLE IF EXISTS `$table`;", []);
		$tableConstructor->constructTable($objType);
	}

	protected function getObjType(): Entity {
		return $this->objType;
	}

	public function testCreateReadUpdate() {
		$obj = $this->getObj();
		$objType = $this->getObjType();

		$objType->create(['id' => 10, 'type_name' => 'type1']);
		$objType->create(['id' => 20, 'type_name' => 'type2']);
		$objType->create(['id' => 30, 'type_name' => 'type3']);

		$this->assertEquals(3, $objType->getCount());

		$obj->setPageSize(2);

		$sessionId = '6btq375cbt3876546cbtq375cbt38765';
		$sessionId2 = '6btq375cbt3876546cbtq375cbt38766';
		$sessionId3 = '6btq375cbt3876546cbtq375cbt38767';
		$sessionId4 = '6btq375cbt3876546cbtq375cbt38768';

		//--------------------------------------------------------------------

		$res = $obj->readPage(1);
		$this->assertEquals(0, $res->getCount());
		$this->assertEquals('session', $res->getName());
		$this->assertEquals('id', $res->getKeyName());
		$this->assertEquals([], $res->getData()['list']);

		//--------------------------------------------------------------------

		$res = $obj->create(['sessionId' => $sessionId, 't_session_type' => 10, 'pHash' => 'qwe', 'pData' => ['qwe' => 1]]);

		$this->assertTrue($res->getResult() > 0);
		$this->assertTrue($res->isOk());
		$id = $res->getResult();

		$res = $obj->create(['sessionId' => $sessionId2, 't_session_type' => 20, 'pHash' => 'qwe2', 'pData' => ['qwe' => 2]]);
		$this->assertTrue($res->getResult() > 0);
		$this->assertTrue($res->isOk());
		$id2 = $res->getResult();

		$res = $obj->create(['sessionId' => $sessionId3, 't_session_type' => 30, 'pHash' => 'qwe3', 'pData' => ['qwe' => 3]]);
		$this->assertTrue($res->getResult() > 0);
		$this->assertTrue($res->isOk());
		$id3 = $res->getResult();

		$res = $obj->create(['sessionId' => $sessionId4, 't_session_type' => 10, 'pHash' => 'qwe4', 'pData' => ['qwe' => 4]]);
		$this->assertTrue($res->getResult() > 0);
		$this->assertTrue($res->isOk());
		$id4 = $res->getResult();

		//--------------------------------------------------------------------

		$res = $obj->create(['sessionId' => $sessionId, 't_session_type' => 20, 'pHash' => 'qwe', 'pData' => ['qwe' => 1]]);
		$this->assertEquals(NULL, $res->getResult());
		$this->assertEquals(true, $res->hasError());
		$this->assertEquals(false, $res->isOk());

		$errors = $res->getErrors();

		$this->assertEquals('alreadyExists[value]', $errors['fields']['sessionId'][0][0]);
		$this->assertEquals(['value' => $sessionId], $errors['fields']['sessionId'][0][1]);

		//--------------------------------------------------------------------

		$res = $obj->create(['sessionId' => $sessionId . '345', 't_session_type' => 10, 'pHash' => 'qwe', 'pData' => ['qwe' => 1]]);
		$this->assertEquals(NULL, $res->getResult());
		$this->assertEquals(true, $res->hasError());
		$this->assertEquals(false, $res->isOk());

		$errors = $res->getErrors();

		$this->assertEquals('eqLength[length]', $errors['fields']['sessionId'][0][0]);
		$this->assertEquals(['length' => 32], $errors['fields']['sessionId'][0][1]);

		//--------------------------------------------------------------------

		$res = $obj->readAll();
		$this->assertTrue($res->existsId($id));
		$this->assertEquals($sessionId, $res->getById($id)->get('sessionId'));
		$this->assertEquals(4, $res->getCount());

		$item = $res->getById($id);

		$this->assertEquals(['qwe' => 1], $item->get('pData'));
		$this->assertEquals('76d80224611fc919a5d54f0ff9fba446', $item->get('pHash'));
		$this->assertEquals('MD5_ROW_76d80224611fc919a5d54f0ff9fba446', $item->get('pHashVirtual'));

		//--------------------------------------------------------------------

		$item = $obj->readById($id . $id);
		$this->assertEquals(false, $item->exists());

		//--------------------------------------------------------------------

		$item = $obj->readById($id2)->obj();

		$this->assertEquals(['qwe' => 2], $item->get('pData'));
		$this->assertEquals('516b5d9924c123fecc22e0eff6c3e179', $item->get('pHash'));
		$this->assertEquals('MD5_ROW_516b5d9924c123fecc22e0eff6c3e179', $item->get('pHashVirtual'));

		//--------------------------------------------------------------------

		$this->assertEquals(true, $obj->existsById($id));
		$this->assertEquals(false, $obj->existsById($id . $id));

		//--------------------------------------------------------------------

		$res = $obj->readOne(
			function (SelectInterface $select, OneDataInterface $res) use ($sessionId) {
				$select->where("`sessionId` = ?", $sessionId);
			}
		);

		$this->assertTrue($res->exists());
		$item = $res->obj();

		$this->assertEquals(['qwe' => 1], $item->get('pData'));
		$this->assertEquals('76d80224611fc919a5d54f0ff9fba446', $item->get('pHash'));
		$this->assertEquals('MD5_ROW_76d80224611fc919a5d54f0ff9fba446', $item->get('pHashVirtual'));

		//--------------------------------------------------------------------

		$res = $obj->readPage(1);
		$this->assertEquals(2, $res->getPagesCount());
		$this->assertTrue($res->existsId($id));
		$this->assertTrue($res->existsId($id2));
		$this->assertFalse($res->existsId($id3));
		$this->assertFalse($res->existsId($id4));

		$this->assertEquals(['qwe' => 1], $res->getById($id)->get('pData'));
		$this->assertEquals(['qwe' => 2], $res->getById($id2)->get('pData'));

		$res = $obj->readPage(2);
		$this->assertEquals(2, $res->getPagesCount());
		$this->assertFalse($res->existsId($id));
		$this->assertFalse($res->existsId($id2));
		$this->assertTrue($res->existsId($id3));
		$this->assertTrue($res->existsId($id4));

		$this->assertEquals(['qwe' => 3], $res->getById($id3)->get('pData'));
		$this->assertEquals(['qwe' => 4], $res->getById($id4)->get('pData'));

		//--------------------------------------------------------------------

		$res = $obj->updateById(['pData' => ['qwe' => 100], 't_session_type' => 101], $id4);
		$this->assertTrue(!empty($res->getErrors()));

		$res = $obj->updateById(['pData' => ['qwe' => 100], 't_session_type' => 10], $id4);
		$this->assertTrue($res->getResult());
		$this->assertEquals($res->getUpdateData()['pData'], 'a:1:{s:3:"qwe";i:100;}');
		$this->assertEquals($res->getUpdateData()['t_session_type'], 10);

		$item = $obj->readById($id4)->obj();
		$this->assertEquals(['qwe' => 100], $item->get('pData'));

		//--------------------------------------------------------------------

		$res = $obj->updateBy(['pData' => ['qwe' => 300]],
			function (UpdateInterface $update) {
				$update->where('id % 2 = 1');
			}
		);

		$this->assertTrue($res->getResult());
		$this->assertEquals($res->getUpdateData()['pData'], 'a:1:{s:3:"qwe";i:300;}');

		//--------------------------------------------------------------------

		$res = $obj->updateByField(['pData' => ['qwe' => 200]], 'sessionId', $id2);

		$this->assertTrue($res->getResult());
		$this->assertEquals($res->getUpdateData()['pData'], 'a:1:{s:3:"qwe";i:200;}');

		//--------------------------------------------------------------------

		$res1 = $obj->readPage(1,
			function (SelectInterface $selectQuery) {
				$selectQuery->where('id in (?)', [1, 3]);
			}
		);

		$res1->loadForeignData();

		//--------------------------------------------------------------------

		$res2 = $obj->readByFieldArray('id', [1, 3]);
		$res3 = $obj->readByIds([1, 3]);

		foreach ([$res1, $res2, $res3] as $res) {
			$this->assertEquals(2, $res->getCount());
			$this->assertTrue($res->existsId(1));
			$this->assertTrue($res->existsId(3));
			$this->assertEquals([1, 3], $res->getColumn('id'));
		}

		//--------------------------------------------------------------------
		$cb = function (SelectInterface $selectQuery) {
			$selectQuery->where('id < (3)', 0);
		};

		$res1 = $obj->readPage(1,
			function (SelectInterface $selectQuery) use ($cb) {
				$selectQuery->where('id in (?)', [1, 3]);
				$cb($selectQuery);
			}
		);

		$res2 = $obj->readByFieldArray('id', [1, 3], $cb);
		$res3 = $obj->readByIds([1, 3], $cb);

		foreach ([$res1, $res2, $res3] as $res) {
			$this->assertEquals(1, $res->getCount());
			$this->assertTrue($res->existsId(1));
			$this->assertFalse($res->existsId(3));
			$this->assertEquals([1], $res->getColumn('id'));
		}

		//--------------------------------------------------------------------

		$count = $obj->getCount(
			function (SelectInterface $selectQuery) {
				$selectQuery->where('id in (?)', [1, 3]);
			}
		);

		$this->assertEquals(2, $count);

		//--------------------------------------------------------------------

		$res = $obj->readByField('t_session_type', 10);
		$this->assertEquals(2, $res->getCount());
		$this->assertTrue($res->existsId(1));
		$this->assertTrue($res->existsId(4));
		$this->assertEquals([1, 4], $res->getColumn('id'));

		//--------------------------------------------------------------------

		$res = $obj->readByField('t_session_type', 10, $cb);
		$this->assertEquals(1, $res->getCount());
		$this->assertTrue($res->existsId(1));
		$this->assertFalse($res->existsId(4));
		$this->assertEquals([1], $res->getColumn('id'));

		//--------------------------------------------------------------------

		$obj->setPageSize(1);

		$res = $obj->pageByField(1, 't_session_type', 10);
		$this->assertEquals(2, $res->getCount());
		$this->assertTrue($res->existsId(1));
		$this->assertFalse($res->existsId(4));
		$this->assertEquals([1], $res->getColumn('id'));

		$res = $obj->pageByField(2, 't_session_type', 10);
		$this->assertEquals(2, $res->getCount());
		$this->assertFalse($res->existsId(1));
		$this->assertTrue($res->existsId(4));
		$this->assertEquals([4], $res->getColumn('id'));
	}

}