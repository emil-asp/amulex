<?php
/**
 * Created by PhpStorm.
 * User: emilasp
 * Date: 28.01.15
 * Time: 12:22
 *
 * Конфиг вынес в отдельный файл (по заданию)
 */

$config = [
    'db'=>[
        'class' => '\core\Db',
        'options' => [
            'host'=>'localhost',
            'user'=>'root',
            'password'=>'cry5yy29',
            'database'=>'amulex',
        ],
    ],
    'controller'=>[
        'class' => '\core\Controller',
    ],
    'view'=>[
        'class' => '\core\View',
        'options' => [
            'pathViews' => '/view/'
        ],
    ]
];

return $config;