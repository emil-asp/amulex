<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 27.01.15
 * Time: 21:22
 */

ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

include_once(realpath('.').'/autoload.php');

$config =  require(__DIR__ . '/config/main.php');

/** @var $app core\App */
$app = core\App::getInstance()->init( $config );

