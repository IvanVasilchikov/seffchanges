<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("iblock");
$listJson["title"]=$arParams["TITLE"];
foreach($arResult["arMapStruct"] as $k=>$itemParent){
    $itemMenu[$k]["title"]=$itemParent["NAME"];
    $itemMenu[$k]["url"]=$itemParent["FULL_PATH"];
    $rsSections = CIBlockSection::GetList(['sort' => 'ASC'], ['IBLOCK_CODE' => $arParams["IBLOCK_CODE"], 'ACTIVE' => 'Y','NAME'=>$itemParent["NAME"]],false,["ID","NAME","CODE"]);
    while ($arSction = $rsSections->Fetch())
    {
        $res = CIBlockElement::GetList(['sort' => 'ASC'], ['IBLOCK_CODE' => $arParams["IBLOCK_CODE"], 'ACTIVE' => 'Y','SECTION_ID'=>$arSction["ID"]], false, false, ["ID", "NAME", "CODE"]);
        while($ar_fields = $res->GetNext())
        {
            $itemMenu[$k]["links"][]=["text"=>$ar_fields['NAME'],"url"=>$ar_fields['CODE']];
        }
    }
}
$listJson["items"]=$itemMenu;

$arResult['listJson']=$listJson;