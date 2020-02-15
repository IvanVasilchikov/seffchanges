<?php

use Idem\Realty\Import\Intrum;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::includeModule("idem.realty");

$tmpResult = json_decode(file_get_contents('metro.json'), true);
$arResult = array_map(function ($item) {
	$item['dbId'] = \CUtil::translit($item['dbName'], 'ru', Intrum::TRANSLIT);
	return $item;
}, $tmpResult);
echo json_encode($arResult);
die();
