<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 11:44
 */
namespace core;

use core\abstracts\ESingleton;
use core\interfaces\IApplication;

/** Основное приложение и точка входа
 * Class App
 * @package core
 *
 * @property-read \core\Db $db
 * @property-read \core\Controller $controller
 * @property-read \core\View $view
 */
class App extends ESingleton implements IApplication {

    /** @var array сюда подгружается конфиг */
    private $_options = [];
    /** @var array здесь храним объекты компонентов */
    private $_objects = [];

    /** применяем конфиг и создаём обхект контроллера
     * @param array $config
     * @return \core\App $this
     */
    public function init( array $config ){
        $this->_options = $config;
        $this->controller;
        return $this;
    }

    /** Устанавливаем свойство
     * @param string $key
     * @param mixed $object
     */
    static public function set( $key, $object ) {
        self::getInstance()->_options[$key] = $object;
    }

    /** Получаем свойство
     * @param string $key
     * @return mixed
     */
    static public function get( $key ) {
        return self::getInstance()->_options[$key];
    }

    /** Пытаемся получить свойство, если не уда1тся пытаемся его создать из конфига и отдаём при успехе
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get( $name ){

        if( !isset( $this->_objects[$name]) || !is_object($this->_objects[$name]) ){

            if( isset( $this->_options[$name] ) ){

                $className  = $this->_options[$name]['class'];
                $options    = (isset($this->_options[$name]['options']))?$this->_options[$name]['options']:[];

                $this->_objects[$name] = new $className( $options );
            }else{
                throw new \Exception('Доступ к свойству запрещён, либо оно отсутствует');
            }
        }
        return $this->_objects[$name];
    }
}