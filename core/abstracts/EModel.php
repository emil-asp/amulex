<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 12:41
 */
namespace core\abstracts;

use core\App;
use core\interfaces\IModel;

/** Абстрактный класс модели БД на вырост))
 * Class EModel
 * @package core\abstracts
 */
abstract class EModel implements IModel{

    const TABLE_NAME = 'table'; // Наименование таблицы модели

    /** Пока как пример добавил соновной метод на олучение данных
     * @param array $params
     * @return array
     */
    static public function getData( array $params = [] ){
        $tableName = static::TABLE_NAME;
        return App::getInstance()->db->query( "SELECT * FROM {$tableName} LIMIT 10", $params )->asArray()->all();
    }

}