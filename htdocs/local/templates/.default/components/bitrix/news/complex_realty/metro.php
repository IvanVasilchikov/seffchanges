<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetPageProperty('front_page','catalog');
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
?>
<?
$data = new Idem\Realty\Realty\Data();
$data->check404(LIVE_REALTY_URL, "metro", $arResult["VARIABLES"]['metro']);
$arTags = $_REQUEST['tags'];
$result = $APPLICATION->IncludeComponent(
    "custom:object.filter",
    "",
    Array(
        'TYPE'=>$arParams["TYPE"],
        'SUB_TYPE'=>$arParams["SUB_TYPE"],
        'SUB_TYPE_VAL'=>FLAT_CODE,
        'SEARCH_BY_METRO'=>true,
        'SEARCH_VAL'=>$arResult["VARIABLES"]['metro'],
        'RENT'=>$arParams["RENT"] === true?true:false,
        "BASE_URL" => $arResult['BASE_URL'],
    ),
    false
);?>
<?
$APPLICATION->IncludeComponent(
    "custom:catalog",
    "",
    array(
        'TYPE'=>$arParams["TYPE"],
        'SUB_TYPE'=>$arParams["SUB_TYPE"],
        'SUB_TYPE_VAL'=>FLAT_CODE,
        'SEARCH_BY_METRO'=>true,
        'SEARCH_VAL'=>$arResult["VARIABLES"]['metro'],
        'RENT'=>$arParams["RENT"] === true?true:false,
        "FILTER" => [
            'bool'=> $result['filter'],
        ],
        'json'=> $result['json'],
        'tags'=>$arTags,
    ),
    $component
);?>
