<?php
/**
 * Абстрактная модель предметной области
 *
 * @copyright 2012, Михаил Красильников, <mihalych@vsepofigu.ru>
 *
 * @package ORMBundle
 *
 * @author Михаил Красильников <mihalych@vsepofigu.ru>
 */

namespace Eresus\ORMBundle;

use ArrayAccess;
use LogicException;
use InvalidArgumentException;

/**
 * Абстрактная модель предметной области
 *
 * @package ORMBundle
 * @since 1.0
 */
abstract class AbstractEntity implements ArrayAccess
{
    /**
     * Возвращает значение свойства модели
     *
     * @param string $property  имя свойства
     *
     * @return mixed  значение свойства
     *
     * @since 1.0
     */
    public function __get($property)
    {
        assert('is_string($property)');

        if ($this->isPropertyExists($property))
        {
            return $this->getProperty($property);
        }
        return null;
    }

    /**
     * Устанавливает значение свойства модели
     *
     * @param string $property  имя свойства
     * @param mixed  $value     значение свойства
     *
     * @return void
     *
     * @since 1.0
     */
    public function __set($property, $value)
    {
        assert('is_string($property)');

        if ($this->isPropertyExists($property, 'set'))
        {
            $this->setProperty($property, $value);
        }
    }

    /**
     * Возвращает true если есть свойство с указанным именем
     *
     * @param string $offset  имя свойства
     *
     * @return bool
     *
     * @since 1.0
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        assert('is_string($offset)');

        return $this->isPropertyExists($offset);
    }

    /**
     * Возвращает значение свойства
     *
     * @param string $offset  имя свойства
     *
     * @return mixed
     *
     * @since 1.0
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        assert('is_string($offset)');

        return $this->getProperty($offset);
    }

    /**
     * Всегда вбрасывает исключение LogicException
     *
     * @param string $offset  имя свойства
     * @param mixed  $value
     *
     * @throws LogicException
     *
     * @since 1.0
     * @see ArrayAccess::offsetSet()
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function offsetSet($offset, $value)
    {
        throw new LogicException;
    }

    /**
     * Всегда вбрасывает исключение LogicException
     *
     * @param string $offset  имя свойства
     *
     * @throws LogicException
     *
     * @since 1.0
     * @see ArrayAccess::offsetUnset()
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function offsetUnset($offset)
    {
        throw new LogicException;
    }

    /**
     * Возвращает объект из {@link http://symfony.com/doc/current/book/service_container.html
     * контейнера}
     *
     * @param string $id
     *
     * @return object
     *
     * @since 1.0
     */
    protected function get($id)
    {
        assert('is_string($id)');

        return $GLOBALS['kernel']->getContainer()->get($id);
    }

    /**
     * Устанавливает значение свойства типа «Дата»
     *
     * @param string $property  имя свойства
     * @param mixed  $value     значение свойства
     *
     * @throws InvalidArgumentException
     *
     * @return void
     *
     * @since 0.7.1
     */
    protected function setDateProperty($property, $value)
    {
        assert('is_string($property)');

        switch (true)
        {
            case $value instanceof \DateTime:
            case is_null($value):
                // Трансформация не требуется
                break;
            case false === $value:
            case '' === $value:
                $value = null;
                break;
            case is_string($value):
                $value = \DateTime::createFromFormat('Y-m-d', $value);
                break;
            default:
                throw new InvalidArgumentException('Can not convert value of type "'
                    . gettype($value) . '" to date');
        }
        $this->{$property} = $value;
    }

    /**
     * Проверяет, существует ли указанное свойство
     *
     * @param string $property
     * @param string $accessType  'get' или 'set'
     *
     * @return bool
     *
     * @since 1.0
     */
    private function isPropertyExists($property, $accessType = 'get')
    {
        assert('is_string($property)');
        assert('is_string($accessType)');

        $accessMethod = $accessType . $property;
        if (method_exists($this, $accessMethod))
        {
            return true;
        }
        return property_exists($this, $property);
    }

    /**
     * Возвращает значение указанного свойства
     *
     * @param string $property
     *
     * @return mixed
     *
     * @since 1.0
     */
    private function getProperty($property)
    {
        assert('is_string($property)');

        $getter = 'get' . $property;
        if (method_exists($this, $getter))
        {
            return $this->$getter();
        }
        return $this->$property;
    }

    /**
     * Устанавливает значение указанного свойства
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return void
     *
     * @since 1.0
     */
    private function setProperty($property, $value)
    {
        assert('is_string($property)');

        $setter = 'set' . $property;
        if (method_exists($this, $setter))
        {
            $this->$setter($value);
        }
        $this->$property = $value;
    }
}

