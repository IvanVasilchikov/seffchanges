<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Idem\Realty\Realty\Data;

CModule::includeModule("idem.realty");
$arResult = [];
$data = new Data();
$arTypes = [
	[
		'listName' => 'highway',
	]
];
foreach ($arTypes as $arType) {
	$arTempData = $data->getExistVariables($arType['listName'], 3);
	if (!empty($arTempData)) {
		$arData = [
			"name" => $arType['name'],
			"description" => $arType['description'],
			"listName" => $arType['listName'],
			"inner" => []
		];
		foreach ($arTempData as $arItem)
			$arData['inner'][] = [
				"text" => $arItem['NAME'],
				"name" => $arItem['CODE'],
				"value" => $arItem['CODE']
			];
		$arResult[] = $arData;
	}
}


echo json_encode($arResult);
die();
