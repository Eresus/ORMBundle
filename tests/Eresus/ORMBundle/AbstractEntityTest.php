<?php
namespace Eresus\ORMBundle\Tests;

require_once __DIR__ . '/../../bootstrap.php';
require_once SRC_ROOT . '/AbstractEntity.php';

use PHPUnit_Framework_TestCase as TestCase;
use Eresus\ORMBundle\AbstractEntity;

class AbstractEntityTest extends TestCase
{
    /**
     * Тест на ошибку, приводящую к перезатиранию значения, установленнго через сеттер свойства
     * исходным значением.
     *
     * @covers Eresus\ORMBundle\AbstractEntity::setProperty
     */
    public function testIssueOverwriteProperty()
    {
        $test = new TestClass();
        $test->foo = 'foo';
        $this->assertEquals('foobar', $test->foo);
    }

    /**
     * @covers Eresus\ORMBundle\AbstractEntity::setDateProperty
     */
    public function testSetDateProperty()
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
    protected $foo;
    protected $date;

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($value)
    {
        $this->setDateProperty('date', $value);
    }

    public function setFoo($value)
    {
        $this->foo = $value . 'bar';
    }
}

