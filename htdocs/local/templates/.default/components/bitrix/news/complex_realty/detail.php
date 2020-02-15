<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$viewDetail = true;
if ($arParams['CHECK_DETAIL_BY_EXIST'] === true) {
    $data = new Idem\Realty\Realty\Data();
    if (!$data->searchExistDetail($arResult["VARIABLES"]["CODE"]))
        $viewDetail = false;
}
if ($viewDetail) {
    $APPLICATION->SetPageProperty('front_page', 'detail');
    $APPLICATION->IncludeComponent(
        "custom:object.detail",
        "",
        array(
            'ID' => $arResult["VARIABLES"]["CODE"],
            'DEPARTAMENT_ID' => $arParams["DEPARTAMENT_ID"],
        )
    );
    $APPLICATION->IncludeComponent(
        "custom:object.detail.desc",
        "",
        array(
            'ID' => $arResult["VARIABLES"]["CODE"],
            'ID_BLOCK_TYPE' => "type_point_ru",
            'ID_BLOCK_POINT' => "binding_ru",
            'ID_BLOCK_AREA' => "areas_ru",
        )
    );
} else {
    $APPLICATION->SetPageProperty('front_page', 'catalog');
    $result = $APPLICATION->IncludeComponent(
        "custom:object.filter",
        "",
        array(
            'DEPARTAMEN_ID' => $arParams["DEPARTAMENT_ID"],
        ),
        false
    );
    $APPLICATION->IncludeComponent(
        "custom:catalog",
        "",
        array(
            'DEPARTAMEN_ID' => $arParams["DEPARTAMENT_ID"],
            "FILTER" => [
                'bool' => $result['filter'],
            ],
            'json' => $result['json'],
        )
    );
}
