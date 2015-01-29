<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.01.15
 * Time: 21:41
 */
namespace core\abstracts;

use core\interfaces\IController;

/** Класс несущий основной функционал для контроллеров - создан скорее что бы не захламлять наследников, что бы там были только экшены
 * Class EController
 * @package core\abstracts
 */
abstract class EController implements IController{

    const ACTION_PREFIX = 'action';     // префис дял всех экшенов в контроллере
    const ACTION_ERROR  = 'error';      // экшен для вывода ошибок
    const ACTION_DEFAULT = 'index';     // экшен по умолчанию

    /** @var null|string текущий экшен */
    public $action = NULL;

    /** @var null|array массив $_POST */
    public $post = NULL;

    /** @var null|array массив $_GET */
    public $get = NULL;

    /** @var bool это AJAX запрос */
    public $isAjax = false;


    /** Инициализируем контроллер
     * @param array $options
     */
    public function __construct( array $options = [] ){
        $pathUrl = parse_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", PHP_URL_PATH);
        $this->action = trim( $pathUrl, '/' );
        $this->post = $_POST;
        $this->get = $_GET;
        if( $this->action == '' ) $this->action = static::ACTION_DEFAULT;

        $this->isAjax();
        $this->init();
    }

    /**
     * Вызываем текущий экшен
     */
    public function init(){
        $methodName = static::ACTION_PREFIX . ucfirst(strtolower($this->action));
        $this->{$methodName}();
    }

    /** Попытка вызвать экшен и если его нет перенаправляем на экшен error
     * @param string $name
     * @param array $arguments
     */
    public function __call( $name, array $arguments ){
        if( method_exists($this, $name) )
            $this->{$name};
        else
            $this->{static::ACTION_PREFIX.static::ACTION_ERROR}();
    }

    /**
     * Устанавливаем свойство isAjax
     */
    public function isAjax(){
        if(
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        )
            $this->isAjax = true;
        else
            $this->isAjax =  false;
    }

    /** Получаем нужный элемент массива $_POST
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPost( $key, $default = null ){
       return $this->getRequest('post',$key,$default);
    }

    /** Получаем нужный элемент массива $_GET
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getGet( $key, $default = null ){
        return $this->getRequest('get',$key,$default);
    }

    /** Проходим по массиву и получаем нужный элемент
     * @param string $type  'post'|'get'
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function getRequest($type, $key, $default){
        $request = $this->$type;
        if( !is_array($key) && isset($request[$key]) ) return $request[$key];

        if( is_array($key) ){
            $_val = $request;
            foreach( $key as $_key )
                if( !isset($_val[$_key]))
                    return $default;
                else
                    $_val = $_val[$_key];
            return $_val;
        }
        return $default;
    }

    /** Делаем обязательным экшен error  */
    abstract public function actionError();

}