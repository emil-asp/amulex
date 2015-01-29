<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 13:14
 */
namespace core\interfaces;

/** Реализация моделей(на вырост)
 * Interface IModel
 * @package core\interfaces
 */
interface IModel
{
    /** Метод пустышка
     * @param array $params
     * @return mixed
     */
    static public function getData( array $params );
}