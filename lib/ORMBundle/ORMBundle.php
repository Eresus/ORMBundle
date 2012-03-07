<?php
/**
 * Компонент Eresus ORM для  Symfony2
 *
 * @version 1.0.1
 *
 * @copyright 2011, Михаил Красильников, <mihalych@vsepofigu.ru>
 *
 * @package ORMBundle
 * @author Михаил Красильников <mihalych@vsepofigu.ru>
 */

namespace Eresus\ORMBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Компонент ORM
 *
 * @package ORMBundle
 * @since 1.0
 */
class ORMBundle extends Bundle
{
	/**
	 * Конструктор
	 *
	 * @return void
	 *
	 * @since 1.0.1
	 */
	public function __construct()
	{
		// Задаём уникальное имя, чтобы избежать конфликта с другими пакетами
		$this->name = 'EresusORMBundle';
	}
	//-----------------------------------------------------------------------------
}
