<?php
namespace Eresus\ORMBundle\Tests;

require_once __DIR__ . '/bootstrap.php';
require_once SRC_ROOT . '/AbstractEntity.php';

use Eresus\ORMBundle\AbstractEntity;

class AbstractEntity_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers Eresus\ORMBundle\AbstractEntity::setDateProperty
	 */
	public function test_setDateProperty()
	{
		$test = new TestClass();
		$test->setDate(new \DateTime());
		$this->assertInstanceOf('DateTime', $test->getDate());

		$test = new TestClass();
		$test->setDate(null);
		$this->assertNull($test->getDate());

		$test = new TestClass();
		$test->setDate(false);
		$this->assertNull($test->getDate());

		$test = new TestClass();
		$test->setDate('');
		$this->assertNull($test->getDate());
	}
}



class TestClass extends AbstractEntity
{
	protected $date;

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($value)
	{
		$this->setDateProperty('date', $value);
	}
}