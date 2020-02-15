<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Idem\Realty\Realty\Data;

CModule::includeModule("idem.realty");
$arResult = [];
$data = new Data();
$arTypes = [
    [
        'name' => 'Кольцевые автодороги',
        'description' => 'Новая москва',
        'listName' => 'transport_ring',
    ],
    [
        'name' => 'Округа',
        'description' => 'Новая москва',
        'listName' => 'district',
    ],
    [
        'name' => 'ЦАО',
        'description' => '',
        'listName' => 'locality',
    ]
];
foreach ($arTypes as $arType) {
    if($arType['listName'] == 'locality'){
        $arTempData = $data->getExistVariables($arType['listName'], [1, 2],false,[],false,true);
    }else{
        $arTempData = $data->getExistVariables($arType['listName'], [1, 2]);
    }
    if (!empty($arTempData)) {
        $arData = [
            "name" => $arType['name'],
            "description" => $arType['description'],
            "listName" => $arType['listName'],
            "inner" => []
        ];
        foreach ($arTempData as $arItem){ 
            if($arType['listName'] == 'locality'){
                if($arItem['DISTRICT'] == "tsao"){
                    $arData['inner'][] = [
                        "text" => $arItem['NAME'],
                        "name" => $arItem['CODE'],
                        "value" => $arItem['CODE']
                    ];
                }                
            }else{
                $arData['inner'][] = [
                    "text" => $arItem['NAME'],
                    "name" => $arItem['CODE'],
                    "value" => $arItem['CODE']
                ];
            }            
        }
            
        $arResult[] = $arData;
    }
}
echo json_encode($arResult);
die();
