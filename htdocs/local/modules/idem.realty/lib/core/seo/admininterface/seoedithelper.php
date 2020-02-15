<?php

namespace Idem\Realty\Core\Seo\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;
use Bitrix\Main\Localization\Loc;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class SeoEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Seo\SeoTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
    
    protected function loadElement($select = array())
    {
        if ($this->getPk() !== null) {
            $className = static::getModel();
            $result = $className::getById($this->getPk());
            
            /*добавленный блок*/
            $data = $result->fetch();
            if($_REQUEST['entity'] == 'core_seo'){
                if(!empty($data['INFO'])) {
                    $rootDir = dirname(__FILE__)."/../../../../../../..";
                    $dir = dirname(__FILE__);
                    $arTemp = file_get_contents($dir.'/seo_admin_template.json');
                    $arDataByTabs = json_decode($arTemp, 1);
                    foreach ($arDataByTabs as $key => $arTabData) {
                        foreach ($arTabData as $fieldID => $arField) {
                            if (isset($data['INFO'][$fieldID])) {
                                if($arField['datatype'] == 'select' && !empty($data['INFO'][$fieldID])){
                                    $helper = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                                    if($data['INFO'][$fieldID])
                                        $data['INFO'][$fieldID] = $this->getSimpleSelectDataFormat($data['INFO'][$fieldID], $helper, true);
                                }
                            }
                        }
                    }
                    if(empty($data['INFO']['base_link'])){
                        $data['INFO']['base_link'] = (LANGUAGE_ID=='en'?"/en":"")."/catalog/";
                    }
                    $data['INFO']['ID'] = $data['ID'];
                    if(empty($data['INFO']['department']))
                        $data['INFO']['LINK'] = "";
                    else
                        $data['INFO']['LINK'] = $data['LINK'];
                    $data = $data['INFO'];
                }
            }
            return $data;
        }
        
        return false;
    }
    
    protected function getSelectDataFormat($values = [], $helper = "", $byValue = false){
        if(empty($values) || empty($helper))
            return [];
        
        $arIds = [];
        foreach ($values as $id)
            $arIds[] = $id;
        $arFilter = ['ID' => $arIds];
        if($byValue)
            $arFilter = ['NAME' => explode(',', $values)];
        $arResult = [];
        $rsEntity = $helper::getList(array(
            'select' =>  array('ID', 'NAME','CODE'),
            'filter' => $arFilter
        ));
        
        while ($res = $rsEntity->fetch()) {
            if($byValue)
                $arResult[] = $res;
            else
                $arResult[] = $res['NAME'];
        }
        
        if($byValue)
            return $arResult;
        else
            return implode(',', $arResult);
    }
    
    protected function getSimpleSelectDataFormat($id = [], $helper = "", $byValue = false){
        if(empty($id) || empty($helper))
            return [];
        $arFilter = ['ID' => $id];
        if($byValue)
            $arFilter = ['NAME' => $id];
        $rsEntity = $helper::getList(array(
            'select' =>  array('ID', 'NAME','CODE'),
            'filter' => $arFilter
        ));
        
        if ($res = $rsEntity->fetch()) {
            if($byValue)
                return $res['ID'];
            else
                return $res['NAME'];
        }
        else
            return "";
    }
    
    
    protected function saveElement($id = null)
    {
        if($_REQUEST['entity'] == 'core_seo'){
            $arSearchFields = ['address', 'city', 'zhk_name', 'cian_zhk_name'];
            $arSearch = [];
            global $DB;
            $arRav = [];
            $dir = dirname(__FILE__);
            $arTemp = file_get_contents($dir.'/seo_admin_template.json');
            
            $arDataByTabs = json_decode($arTemp, 1);
            foreach ($arDataByTabs as $key => $arTabData) {
                foreach ($arTabData as $fieldID => $arField) {
                    if (isset($this->data[$fieldID])) {
                        
                        $value = $this->data[$fieldID];
                        if(empty($value))
                            $value = NULL;
                       
                        if($arField['datatype'] == 'select') {
                            $helper = "Idem\Realty\Core\\" . $arField['helper'] . "\\" . $arField['helper'] . "Table";
                            if ($value)
                                $value = $this->getSimpleSelectDataFormat($value, $helper);
                        }
                        
                        
                        $arRav[$fieldID] = $value;
                        
                        
                        if(in_array($fieldID, $arSearchFields)){
                            $arSearch[] = $arRav[$fieldID];
                        }
                    }
                }
            }
            
            $this->data = ['ID' => $_REQUEST['ID'],'LINK' => $this->data['LINK'], 'INFO' => json_encode($arRav, JSON_UNESCAPED_SLASHES)];
        }
        
        /** @var EntityManager $entityManager */
        
        $entityManager = new static::$entityManager(static::getModel(), empty($this->data) ? array() : $this->data, $id, $this);
        $saveResult = $entityManager->save();
        $this->addNotes($entityManager->getNotes());
        return $saveResult;
    }
}