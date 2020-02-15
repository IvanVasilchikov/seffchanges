<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = array();

/*
 * тут будет получение ответов пользователя и формирование ссылки на фильтр каталога*/

echo json_encode($arResult);
die();