<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$APPLICATION->SetPageProperty('front_page','detail');
$this->setFrameMode(true);
?>
<?php
$APPLICATION->IncludeComponent(
    "custom:object.detail",
    "",
    array(
        //'ID'=>536949
        'ID'=>$arResult["VARIABLES"]["ID"]
    )
);?>
<?php
$APPLICATION->IncludeComponent(
    "custom:object.detail.desc",
    "",
    array(
        'ID'=>$arResult["VARIABLES"]["ID"]
    )
);?>
