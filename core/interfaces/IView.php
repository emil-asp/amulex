<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 13:32
 */
namespace core\interfaces;

/** Интерфейс для реализации классов представлений
 * Interface IView
 * @package core\interfaces
 */
interface IView
{
    /** Делаем обязательным конструктор
     * @param array $options
     */
    public function __construct( array $options = [] );

    /** Основной метод дял рендеринга вьюх
     * @param string $template
     * @param array $params
     * @return mixed
     */
    public function render( $template, array $params = [] );
}