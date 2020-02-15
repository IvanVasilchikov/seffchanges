<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = array();
$util = new app\Util\Util();

$arData = $util->getTypicalData('clients_'.LANGUAGE_ID, false,false, [], true, [], ['PREVIEW_PICTURE']);

foreach ($arData as $key => $data){
    if($key < 6)
        continue;
    $arResult[] = [
        "url" => "#",
        "img" => [
            "src" => $data['PREVIEW_PICTURE'][0],
            "alt" => $data['NAME']
        ]
    ];
}

echo json_encode($arResult);
die();