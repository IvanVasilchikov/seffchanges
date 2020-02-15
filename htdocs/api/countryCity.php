<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Idem\Realty\Realty\Data;

CModule::includeModule("idem.realty");
$arResult = [];
$data = new Data();

$arTempData = $data->getExistVariables('country', 5);
if (!empty($arTempData)) {
    $arData = [
        "name" => 'Страны',
        "listName" => "country",
        "inner"=>[]
    ];
    foreach ($arTempData as $arItem)
        $arData['inner'][] = [
            "text" => $arItem['NAME'],
            "value" => $arItem['CODE']
        ];
    $arResult[] = $arData;
}
$arTempDataCity = $data->getExistVariables('city', 5, false, [], false, false, true);
if (!empty($arTempData)) {
    foreach($arTempData as $k=>$country){
        $arResult[$k+1] = [
            "name" => $country["NAME"],
            "listName" => "city",
            "inner"=>[]
        ];
        foreach($arTempDataCity as $city){
            if($country["CODE"] == $city["COUNTRY"]){
                $arResult[$k+1]['inner'][] = [
                    "text" => $city['NAME'],
                    "value" => $city['CODE']
                ];

            }
        }   
    }       
}
echo json_encode($arResult);
die();
