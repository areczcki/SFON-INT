<?php
if (isset($_SERVER['SCRIPT FILENAME'])){
    return false;
}else{
    $_SERVER['SCRIPT FILENAME'] = $_SERVER['DOCUMENT_ROOT'] .
        DIRECTORY_SEPARATOR .
        'app.php'
    ;

    require 'app.php';
}