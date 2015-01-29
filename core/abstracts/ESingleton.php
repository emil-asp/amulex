<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 12:45
 */

namespace core\abstracts;

/** Абстратный класс позволяет наследникам реализовывать паттерн Singelton
 * Class ESingleton
 * @package core\abstracts
 */
abstract class ESingleton {

    /** @var null|ESingleton */
    static protected $_instance = null;

    /** проверяем и инициализируеем инстанс
     * @return ESingleton|null
     */
    static public function getInstance() {
        if ( is_null(static::$_instance) ) {
            static::$_instance = new static();
        }
        return static::$_instance;
    }

    /** Запрещаем восстанавливать*/
    private function __wakeup() { }

    /** Запрещаем инициализацию класса из вне(кроме наследников) */
    protected function __construct() { }

    /** Запрещаем клонировать */
    private function __clone() { }

}