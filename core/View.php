<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28.01.15
 * Time: 14:67
 */
namespace core;

use core\interfaces\IView;

/** Класс дял рабоыт с представлениями
 * Class View
 * @package core
 */
class View implements IView{

    /** @var string путь до папки с вьюхами */
    private $pathViews;

    /** Инициализируемся и устанавливаем папку с вьюхами
     * @param array $options
     * @throws \Exception
     */
    public function __construct( array $options =[] ){

        if( !isset($options['pathViews']) )
            throw new \Exception('Please configure View');

        $this->pathViews = realpath('.'). $options['pathViews'];
    }

    /** Рендерим вьюху и выводим в неё параметры
     * @param string $template
     * @param array $params
     * @return mixed|string
     * @throws \Exception
     */
    public function render( $template, array $params = [] ){

        $_template = $this->pathViews.$template.'.php';

        if (is_file($_template)) {

            foreach( $params as $key=>$param )
                $$key = $param;

            ob_start();
            include($_template);
            $templateContent = ob_get_contents();
            ob_end_clean();

            return $templateContent;
        }

        throw new \Exception('Template file not found');
    }
}