<?php
/**
 * Created by PhpStorm.
 * User: damaha
 * Date: 20.12.2016
 * Time: 21:47
 */
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/damaha.directories/include/urlrewrite.php');
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/404.php'))
    include_once($_SERVER['DOCUMENT_ROOT'].'/404.php');