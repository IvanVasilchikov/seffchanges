<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->SetPageProperty('front_page', 'catalog');
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

//if($arResult["VARIABLES"]["TYPE"] != LIVE_REALTY_URL && $arResult["VARIABLES"]["TYPE"] != COMMERC_REALTY_URL && $arResult["VARIABLES"]["TYPE"] != COUNTRY_REALTY_URL && $arResult["VARIABLES"]["TYPE"] != FOREIGN_REALTY_URL)
//    show404();

$this->setFrameMode(true);
$params = [];
if ($arParams["RENT"] === true) {
    $params['deal_type'] = 'rent';
}
if ($arResult["VARIABLES"]) {
    $params = array_merge($params, $arResult["VARIABLES"]);
}
if ($arParams["SET_NEW_TYPE"] === true) {
    $params['tags'] = [NOVOSTROIKA_CODE];
}
$result = $APPLICATION->IncludeComponent(
    "custom:object.filter",
    "",
    array(
        'DEPARTAMEN_ID' => $arParams["DEPARTAMENT_ID"],
        'PARAMS' => $params
    ),
    false
);
$APPLICATION->IncludeComponent(
    "custom:catalog",
    "",
    array(
        'DEPARTAMEN_ID' => $arParams["DEPARTAMENT_ID"],
        'PARAMS' => $params,
        "FILTER" => [
            'bool' => $result['filter'],
        ],
        'json' => $result['json'],
    ),
    $component
);
