<?php

namespace Idem\Realty\Utilities;
use Bitrix\Main\Loader;
Loader::includeModule('form');

class Migration
{
    private static $included = false;

    public static $errors = [];

    public static function createType($type,$data)
    {
        if (!($iblockType = \CIBlockType::GetByID($type)->Fetch())) {
            $obBlocktype = new \CIBlockType;
            $obBlocktype->Add($data);
            if($obBlocktype->LAST_ERROR){
                self::$errors[] = $obBlocktype->LAST_ERROR;
            }
        }
    }

    public static function deleteType($type)
    {
        \CIBlockType::Delete($type);
    }

    public static function updateType($type,$data)
    {
        $obBlocktype = new \CIBlockType;
        $obBlocktype->Update($type, $data);
        if($obBlocktype->LAST_ERROR){
            self::$errors[] = $obBlocktype->LAST_ERROR;
        }
    }

    public static function createIBlock($data)
    {
        $ib = new \CIBlock;
        $ib->Add($data);
        if($ib->LAST_ERROR){
            self::$errors[] = $ib->LAST_ERROR;
        }
    }

    public static function deleteIBlock($code,$site = 's1')
    {
        $id = self::getIBlockIdByFilter(['CODE' => $code,'SITE_ID' => $site]);
        \CIBlock::Delete($id);
    }

    public static function updateIBlock($id,$data)
    {
        $ib = new \CIBlock;
        $ib->Update($id, $data);
        if($ib->LAST_ERROR){
            self::$errors[] = $ib->LAST_ERROR;
        }
    }

    public static function getPropertyIDByCode($iblockId,$code)
    {
        $id = 0;
        $properties = \CIBlockProperty::GetList(Array(), Array("CODE"=>$code, "IBLOCK_ID"=>$iblockId));
        if ($prop_fields = $properties->GetNext())
        {
            $id = $prop_fields["ID"];
        }
        return $id;
    }

    public static function createProperties($data)
    {
        $iblockproperty = new \CIBlockProperty;
        $PropertyID = $iblockproperty->Add($data);
        if($iblockproperty->LAST_ERROR){
            self::$errors[] = $iblockproperty->LAST_ERROR;
        }
    }

    public static function deleteProperties($id)
    {
        \CIBlockProperty::Delete($id);
    }

    public static function updateProperties($id,$data)
    {
        $ibp = new \CIBlockProperty;
        $ibp->Update($id, $data);
        if($ibp->LAST_ERROR){
            self::$errors[] = $ibp->LAST_ERROR;
        }
    }

    public static function createElement($data)
    {
        $el = new \CIBlockElement;
        $ID = $el->Add($data);
        if($el->LAST_ERROR){
            self::$errors[] = $el->LAST_ERROR;
        }
        
        return $ID;
    }
    public static function addPropsEl($idEl, $idBloc, $data,$codeProp)
    {
        $ibp = new \CIBlockElement;
        $ibp->SetPropertyValues($idEl, $idBloc, $data,$codeProp);
        if($ibp->LAST_ERROR){
            self::$errors[] = $ibp->LAST_ERROR;
        }
    }

    public static function deleteElement($id)
    {
        \CIBlockElement::Delete($id);
    }

    public static function updateElement($id,$data)
    {
        $el = new \CIBlockElement;
        $el->Update($id, $data);
        if($el->LAST_ERROR){
            self::$errors[] = $el->LAST_ERROR;
        }
    }

    public static function getIBlockIdByFilter($filter)
    {
        $id = null;
        $res = \CIBlock::GetList([],$filter, false);
        if($item = $res->Fetch()){
            $id = $item['ID'];
        }
        return $id;
    }

    public static function getSectionIdByFilter($filter)
    {
        $id = null;
        $res = \CIBlockSection::GetList([],$filter, false);
        if($item = $res->Fetch()){
            $id = $item['ID'];
        }
        return $id;
    }
    public static function getElementIdByFilter($filter)
    {
        $id = null;
        $res = \CIBlockElement::GetList([],$filter, false);
        if($item = $res->Fetch()){
            $id = $item['ID'];
        }
        return $id;
    }

    public static function removeAllInIBlock($iBlockCode)
    {
        $dbRes = \CIBlockElement::GetList([],['IBLOCK_CODE' => $iBlockCode],false,false,['ID']);
        while ($item = $dbRes->Fetch()){
            \CIBlockElement::Delete($item['ID']);
        }

    }

    public static function createSection($data)
    {
        $section = new \CIBlockSection();
        $section->Add($data);
        if($section->LAST_ERROR){
            self::$errors[] = $section->LAST_ERROR;
        }
    }

    public static function updateSection($id,$data)
    {
        $section = new \CIBlockSection();
        $section->Update($id,$data);
        if($section->LAST_ERROR){
            self::$errors[] = $section->LAST_ERROR;
        }
    }
    public static function createForm($data)
    {
        $NEW_ID = \CForm::Set($data);
        if ($NEW_ID<=0)
        {
            global $strError;
            self::$errors[] = $strError;
        }
    }
    public static function createPropForm($data)
    {
        $NEW_ID = \CFormField::Set($data);
        if ($NEW_ID<=0)
        {
            global $strError;
            self::$errors[] = $strError;
        }
    }
    public static function deletePropForm($id)
    {
        \CFormField::Delete($id);
    }

    public static function deleteSection($id)
    {
        \CIBlockSection::Delete($id);
    }
    public static function removeAllSectInIBlock($iBlockCode)
    {
        $dbRes = \CIBlockSection::GetList([],['IBLOCK_CODE' => $iBlockCode],false,['ID']);
        while ($item = $dbRes->Fetch()){
            \CIBlockSection::Delete($item['ID']);
        }
    }



    public static function getPropFormIdByFilter($id_form,$filter)
    {
        $id = null;
        $res = \CFormField::GetList($id_form,'N',$by="s_id",$order="desc", $filter);
        if($item = $res->Fetch()){
            $id = $item['ID'];
        }
        return $id;
    }
    public static function getFormIdByFilter($filter)
    {
        $id = null;
        $res = \CForm::GetList($by="s_id",$order="desc", $filter,$is_filtered);
        if($item = $res->Fetch()){
            $id = $item['ID'];
        }
        return $id;
    }
    public static function setStatusForm($arFields){
        $NEW_ID = \CFormStatus::Set($arFields);
        if ($NEW_ID<=0)
        {
            global $strError;
            self::$errors[] = $strError;
        }
    }
    public static function deleteSite($id){
        \CSite::Delete($id);
    }
    public static function deleteForm($id){
        \CForm::Delete($id);
    }
    /**
	 * Создание контента для статика
	 *
	 * @param   array $code json код для вставки
	 * @param   integer $parentCode код категории родителя
	 */
    public static function createContentStatic($code, $parentCode=''){
        $file=$_SERVER["DOCUMENT_ROOT"]."/upload/static_content/content.json";
        $json = file_get_contents($file);
        
        $arStatic=json_decode($json,true);
        $arCode = json_decode($code,true);
        if(!is_null($arStatic[$parentCode])){
            $arStatic[$parentCode]=array_merge($arStatic[$parentCode],$arCode);
        }else{
            $arStatic=array_merge($arStatic,$arCode);
        }

        $jsonStatic=json_encode($arStatic);
        file_put_contents($file, $jsonStatic);
    } 
    /**
	 * Удаление контента для статика
	 *
	 * @param   integer $parentCode код категории родителя для удаления
	 */  
    public static function deleteContentStatic($parentCode=''){
        $file=$_SERVER["DOCUMENT_ROOT"]."/upload/static_content/content.json";
        $jsonStat = file_get_contents($file);
        $arStatic=json_decode($json,true);
        unset($arStatic[$parentCode]);        
    }
}