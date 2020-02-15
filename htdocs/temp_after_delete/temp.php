<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('idem.realty');

//Tags
/* "1":1598,
        "2":1606,
        "3":1602,
        "5":1608*/
//die();

require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/wizards/install.php");
use Idem\Realty\Wizards\Install;
$install = new Install();
$arInstall = [
    'Zhkclass',
    'Finishyear',
];
foreach ($arInstall as $installName){
    $install->CreateTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
    $install->CreateHLTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table',$installName, $installName, $installName);
}

//die();
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/import/intrum.php");
use Idem\Realty\Import\Intrum;
$intrum = new Intrum();

$arData = $intrum::getVariants(1623);
if(!empty($arData))
    $intrum->dataCollect($arData, "Zhkclass");
$arData = $intrum::getVariants(1626);
if(!empty($arData))
    $intrum->dataCollect($arData, "Finishyear");
/*
$arData = $intrum::getVariants(485);
if(!empty($arData))
    $intrum->dataCollect($arData, "Metro");

$arData = $intrum::getVariants(630);
if(!empty($arData))
    $intrum->dataCollect($arData, "Locality");

$arData = $intrum::getVariants(822);
if(!empty($arData))
    $intrum->dataCollect($arData, "Highway");*/

/*
$arData = $intrum->getCategories();
if(!empty($arData))
    $intrum->dataCollect($arData, "Foreigntype");*/
?>