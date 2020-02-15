<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::includeModule("idem.realty");
$arResult = [];
$arResult['url'] = Idem\Realty\Realty\Data::createUrl($_REQUEST);
header('Content-Type: application/json');
echo json_encode($arResult);
die();
