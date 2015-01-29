<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 27.01.15
 * Time: 21:41
 */

namespace core;

/** Класс для работы с БД MySQL
 * Class Db
 */
class Db
{
    /** @var resource подключени к бд */
    private $connect;
    /** @var bool отдаём результаты в виде массива или объекта */
    private $asArray = false;

    /** @var string для построителя запроса */
    private $select = '';
    /** @var string для построителя запроса */
    private $from   = '';
    /** @var string для построителя запроса */
    private $limit  = '';
    /** @var string для построителя запроса */
    private $where  = '';
    /** @var string для построителя запроса */
    private $group  = '';
    /** @var string для построителя запроса */
    private $having = '';

    /** @var bool для построителя запроса */
    private $isQuery = false;

    /** @var string собранный sql запрос*/
    private $sql = '';
    /** @var mixed результаты */
    public $result;

    /**
     * создаём подключение к БД при инициализации
     */
    public function __construct( array $options ) {

        if( !isset($options['host']) || !isset($options['user']) || !isset($options['password']) || !isset($options['database'])  )
            throw new \Exception('Не полные реквизиты доступа к MySQL');

        $this->connect = mysql_pconnect($options['host'], $options['user'], $options['password']) or die("Connect Error".mysql_error());
        mysql_select_db($options['database'], $this->connect) or die ("Error use BD".mysql_error());
    }

    /**
     * Сбрасываем построитель запроса
     */
    private function resetQuery(){
        $this->result   = NULL;
        $this->asArray  = false;
        $this->select   = '';
        $this->from     = '';
        $this->limit    = '';
        $this->where    = '';
        $this->group    = '';
        $this->having   = '';
    }

    /** Выполняем запрос к БД
     * @param string $sql
     * @param array $params
     * @return NULL|\core\Db
     */
    public function query($sql, array $params = []) {

        $this->resetQuery();

        $this->isQuery = true;
        $this->sql = self::bindParams( $sql, $params );

        if( isset($this->connect) ){
            $result = mysql_query($this->sql)or die("Error Query ".mysql_error());
            $this->result = $result;
        }
        return $this;
    }

    /** Устанавливаем SELECT для построителя запроса
     * @param array $cols
     * @return $this
     */
    public function select( $cols = [] ){

        $this->resetQuery();

        $this->isQuery  = false;

        foreach( $cols as $col ){
            $this->select .= ','.$col;
        }
        $this->select = 'SELECT '.trim($this->select, ',');
        return $this;
    }

    /** Устанавливаем FROM для построителя запроса
     * @param string $table
     * @return $this
     */
    public function from( $table ){
        $this->from = ' FROM '.$table;
        return $this;
    }

    /** Устанавливаем WHERE для построителя запроса
     * @param array $params
     * @return $this
     */
    public function where( $params = [] ){
        if(!count($params)) return $this;

        foreach( $params as $name=>$value ){
            if(!is_array($value)) $this->where .= ' AND '.$name.'='.self::escape($value);
            if(is_array($value) && count($value)==4) $this->where .= ' AND ('.$name.' '.$value[0].' '.'STR_TO_DATE('.self::escape($value[2]).', \'%d.%m.%Y\') AND  STR_TO_DATE('.self::escape($value[3]).', \'%d.%m.%Y\'))';
        }
        $this->where = ' WHERE '.trim($this->where, ' AND');
        return $this;
    }

    /** Устанавливаем GROUP BY для построителя запроса
     * @param array $by
     * @param array $having
     * @return $this
     */
    public function group( array $by, $having = [] ){

        if(!count($by)) return $this;
        foreach( $by as $name=>$value ){
            $this->group .= ','.$value;
        }

        $this->group = ' GROUP BY '.trim($this->group, ',');

        if(!count($having)) return $this;
        foreach( $having as $name=>$value ){
            $this->having .= ','.$name.'='.self::escape($value);
        }
        $this->having = ' HAVING '.trim($this->having, ',');
        return $this;
    }

    /** Устанавливаем LIMIT для построителя запроса
     * @param integer $num
     * @param integer|null $offset
     * @return $this
     */
    public function limit( $num, $offset = null ){
        $this->limit = ' LIMIT '.((isset($offset))?$offset.',':"").$num;
        return $this;
    }

    /** Устанавливаем флаг отдавать результаты в виде массива
     * @return $this
     */
    public function asArray(){
        $this->asArray = true;
        return $this;
    }

    /**
     * Собираем запрос
     */
    private function collectSql(){
        $this->sql .= $this->select;
        $this->sql .= $this->from;
        $this->sql .= $this->where;
        $this->sql .= $this->group;
        $this->sql .= $this->having;
        $this->sql .= $this->limit;
    }

    /** получаем сгенерированный построителем запрос
     * @return string
     */
    public function getSql(){
        $this->sql = '';
        $this->collectSql();
        $sql = $this->sql;
        $this->sql = '';
        return $sql;
    }

    /** Выполняем запрос и получаем результаты
     * @return array
     */
    public function all(){

        if( !$this->isQuery ) {
            $this->collectSql();
            $this->query( $this->sql );
        }

        if( !is_resource($this->result) ) return [];

        $rows = [];
        if( $this->asArray){
            while( $row = mysql_fetch_assoc($this->result) ){
                $rows[] = $row;
            }
        }else{
            while( $row = mysql_fetch_object($this->result) ){
                $rows[] = $row;
            }
        }
        $this->result = $rows;
        return $this->result;
    }

    /** Получаем первый элемент результата запроса
     * @return array|null|object|\stdClass
     */
    public function one(){
        if( !is_resource($this->result) ) return NULL;

        if( $this->asArray)
            return mysql_fetch_assoc($this->result);
        else
            return mysql_fetch_object($this->result);
    }

    /**
     * сгенерированный колонкой с AUTO_INCREMENT последним запросом INSERT к серверу
     */
    public function insertID()
    {
        return mysql_insert_id();
    }

    /** Биндим параметры к запросу
     * @param string $sql
     * @param array $params
     * @return string
     */
    static public function bindParams( $sql, array $params ){

        if( !isset($params['params']) || count($params['params']==0) )  return $sql;

        $sql .= ' WHERE ';

        foreach( $params['params'] as $name=>$value ){
            $sql = self::bindParam( $sql, $name, $value );
        }
        return $sql;
    }

    /** Биндим параметр
     * @param string $sql
     * @param string $name
     * @param string $value
     * @return string mixed
     */
    static public function bindParam( $sql, $name, $value){
        return str_replace($name, self::escape($value), $sql);
    }

    /** Чисто символическая защита, просто чтобы метод был :)
     * @param string $value
     * @return string
     */
    static public function escape( $value ){
        $value = mysql_real_escape_string($value);
        $string = false;
        if(strlen($value)!=strlen((int)$value)) $string = true;
        if($string) $value = '"'.$value.'"';
        return $value;
    }
}