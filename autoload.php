<?php
/**
 * Created by PhpStorm.
 * User: Emilasp
 * Date: 28.01.15
 * Time: 22:32
 */

/*
 * Получаем путь до файла из неймспейса и загружаем класс
 */
function slashReplace ($delimiter) {

    return function($className) use ($delimiter) {

        $extensions = explode(',', spl_autoload_extensions());

        foreach($extensions as $ext) {

            $classFile = str_replace($delimiter,DIRECTORY_SEPARATOR,$className) . $ext;

            if (is_file($classFile)) {
                include_once($classFile);
                break;
            }
        }
    };
}


spl_autoload_extensions('.php');
set_include_path(  realpath('.').'/core/'. PATH_SEPARATOR . realpath('.').'/core/interfaces/'. PATH_SEPARATOR . realpath('.').'/models/' );
spl_autoload_register(slashReplace('\\'));
