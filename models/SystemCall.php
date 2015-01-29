<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 16:12
 */
namespace models;

use core\abstracts\EModel;
use core\App;

/** Модель для таблицы systemcall
 * Class SystemCall
 * @package models
 */
class SystemCall extends EModel{

    /** имя таблицы */
    const TABLE_NAME = 'systemcall';

    /** Получаем усреднённые данные в разрезе лет
     * @param array $params
     * @return mixed
     */
    static public function getDataAvgYear( array $params = [] ){

        $subQuery = App::getInstance()->db->
            select(['MAX(moment) as mnt','DATE_FORMAT(`moment`, \'%e %b %Y\') AS \'date\'','HOUR(moment) as hour','COUNT(id) as cnt'])->
            from(self::TABLE_NAME)->
            where($params)->
            group(['hour','date'])->
            getSql();

        return App::getInstance()->db->
            select(['t.hour','YEAR(t.mnt) as year','ROUND(AVG(t.cnt),1) as data'])->
            from('('.$subQuery.') as t ')->
            where([])->
            group(['year','t.hour'])->
            asArray()->all();
    }

    /** Получаем усреднённые данные в разрезе месяцов
     * @param array $params
     * @return mixed
     */
    static public function getDataAvg( array $params = [] ){

/*        $query =
<<<SQL
SELECT
  t.hour,
  MONTH(t.mnt) as month,
  AVG(t.cnt) as avg
FROM (
    SELECT
      MAX(moment) as mnt,
      DATE_FORMAT(`moment`, '%e %b %Y') AS 'date',
      HOUR(moment) as hour,
      COUNT(id) as cnt
    FROM systemcall
    WHERE type='ANSWER'
    GROUP BY hour, date) as t
 GROUP BY month, t.hour LIMIT 100 ;
SQL;
*/
        $subQuery = App::getInstance()->db
            ->select(['MAX(moment) as mnt','DATE_FORMAT(`moment`, \'%e %b %Y\') AS \'date\'','HOUR(moment) as hour','COUNT(id) as cnt'])
            -> from(self::TABLE_NAME)
            ->where($params)
            ->group(['hour','date'])
            ->getSql();

        return App::getInstance()->db
            ->select(['t.hour','MONTH(t.mnt) as month','ROUND(AVG(t.cnt),1) as data'])
            ->from('('.$subQuery.') as t ')
            ->where([])
            ->group(['month','t.hour'])
            //limit(100)->
            ->asArray()
            ->all();
    }

    /** Приводим данные к нужной структуре для highcharts
     * @param string $type
     * @param array $data
     * @return array
     */
    static public function dataToChartData( $type, array $data){
        $_arrData = [];
        foreach($data as $row){
            $_arrData[$row->hour+1][$row->$type] = $row->data;
        }
        $arrData = [];
        foreach($_arrData as $hourNum=>$hour){
            $arr = [];
            $arr['name'] = $hourNum;
            $arr['data'] = '';
            foreach($hour as $month=>$calls){
                $arr['data'][] = floatval($calls);
            }
            $arrData[] = $arr;
        }
        return $arrData;
    }

    /** Получаем переданные параметры для фильтрации
     * @param string $type
     * @param string $year
     * @param string $range
     * @param string $gateway
     * @return array
     */
    static public function parseRequestParams( $type, $year, $range, $gateway ){

        $params = [];
        if( $type ) $params['type'] = $type;
        if( $year ) $params['YEAR(moment)'] = $year;
        elseif( $range ) {
            $_range = explode(' to ',$range);
            $params['moment'] = ['BETWEEN', 'moment', $_range[0], $_range[1]];
        }
        if( $gateway ) $params['gatway'] = $gateway;

        return $params;
    }

}