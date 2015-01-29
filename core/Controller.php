<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 14:41
 */
namespace core;

use core\abstracts\EController;
use models\SystemCall;

/** Контроллер приложения
 * Class Controller
 * @package core
 */
class Controller extends EController{

    /**
     * Дефолтовый экшен
     */
    public function actionIndex(){
        echo App::getInstance()->view->render('amulex');
    }

    /**
     * Экшен для вывода ошибок
     */
    public function actionError(){
        echo App::getInstance()->view->render('error',['error'=>'Страница не найдена']);
    }

    /** AJAX экшен -  Получаем данные для построения графика по месяцам
     * @throws \Exception
     */
    public function actionData(){
        if( !$this->isAjax ) throw new \Exception('Не Аякс запрос');
        header("Content-type: text/json");

        $type       = $this->getGet('type');
        $year       = $this->getGet('year');
        $range      = $this->getGet('daterange');
        $gateway    = $this->getGet('gatway');

        $data = SystemCall::getDataAvg( SystemCall::parseRequestParams( $type, $year, $range, $gateway ) );
        echo json_encode( SystemCall::dataToChartData('month',$data) );
    }

    /** AJAX экшен -  Получаем данные для построения графика по году
     * @throws \Exception
     */
    public function actionDatayear(){
        if( !$this->isAjax ) throw new \Exception('Не Аякс запрос');
        header("Content-type: text/json");

        $type       = $this->getGet('type');
        $year       = $this->getGet('year');
        $range      = $this->getGet('daterange');
        $gateway    = $this->getGet('gatway');

        $data = SystemCall::getDataAvgYear( SystemCall::parseRequestParams( $type, $year, $range, $gateway ) );
        echo json_encode( SystemCall::dataToChartData('year',$data) );
    }

}