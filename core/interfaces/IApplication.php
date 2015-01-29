<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 13:02
 */
namespace core\interfaces;

/** Интерфейс для реализации Приложения ( частично паттерн registry )
 * Interface IApplication
 * @package core\interfaces
 */
interface IApplication
{
    /** Будет получать из registry Singelton App свойства
     * @param string $key
     * @return mixed
     */
    static public function get($key);

    /** Будет устанавливать свойство для registry Singelton App
     * @param string $key
     * @param mixed $object
     */
    static public function set($key, $object);

    /** Реализуем геттер
     * @param string $name
     * @return mixed
     */
    public function __get($name);

    /** Инициализация App(инициализация контроллера и т.п.)
     * @param array $config
     * @return mixed
     */
    public function init( array $config );
}