<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 13:02
 */
namespace core\interfaces;

/** Реализация контроллеров
 * Interface IController
 * @package core\interfaces
 */
interface IController
{
    /** Обязательная реализация конструктора
     * @param array $options
     */
    public function __construct( array $options = [] );

    /** работа с экшенами
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call( $name, array $arguments );

    /** Вызываем при инициализации
     * @return mixed
     */
    public function init();
}