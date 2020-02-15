<?php

namespace Idem\Realty\Core\Objects\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;
use Idem\Realty\Core\Objects\AdminInterface\ObjectsAdminInterface;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ObjectsEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Objects\ObjectsTable';
    
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
            //dump($data['INFO']);
            if($_REQUEST['entity'] == 'core_objects'){
                if(!empty($data['INFO'])) {
                    $rootDir = dirname(__FILE__)."/../../../../../../..";
                    $dir = dirname(__FILE__);
                    $arTemp = file_get_contents($dir.'/object_admin_template.json');
                    $arDataByTabs = json_decode($arTemp, 1);
                    foreach ($arDataByTabs as $key => $arTabData) {
                        foreach ($arTabData as $fieldID => $arField) {
                            if (isset($data['INFO'][$fieldID])) {
                                if($arField['datatype'] == 'file' && !empty($data['INFO'][$fieldID])){
                                    $arImgsList = explode(',', $data['INFO'][$fieldID]);
                                    $data['INFO'][$fieldID] = "";
                                    if(!is_array($arImgsList))
                                        $arImgsList = [$data['INFO'][$fieldID]];
                                    
                                    foreach ($arImgsList as $filePath) {
                                        if (!file_exists($rootDir . $filePath) && !file_exists($rootDir."/upload/realty_img_intrum/" . $filePath)) {
                                            $arImg = \CFile::MakeFileArray("https://saffariestate.intrumnet.com/files/crm/product/" . $filePath);
                                            if (!empty($arImg)) {
                                                $fid = \CFile::SaveFile($arImg, "intrum_temp_img");
                                                if ($fid) {
                                                    if (empty($data['INFO'][$fieldID])) {
                                                        $data['INFO'][$fieldID] = $fid;
                                                    } else {
                                                        if (!is_array($data['INFO'][$fieldID]))
                                                            $data['INFO'][$fieldID] = [
                                                                $data['INFO'][$fieldID],
                                                                $fid
                                                            ];
                                                        else
                                                            $data['INFO'][$fieldID][] = $fid;
                                                    }
                                                }
                                            }
                                        }
                                        else {
                                            $path = "";
                                            if(file_exists($rootDir . $filePath))
                                                $path = $filePath;
                                            elseif(file_exists($rootDir."/upload/realty_img_intrum/" . $filePath))
                                                $path = "/upload/realty_img_intrum/" .$filePath;
                                            
    
                                            if (empty($data['INFO'][$fieldID])) {
                                                $data['INFO'][$fieldID] = $path;
                                            } else {
                                                if (!is_array($data['INFO'][$fieldID]))
                                                    $data['INFO'][$fieldID] = [
                                                        $data['INFO'][$fieldID],
                                                        $path
                                                    ];
                                                else
                                                    $data['INFO'][$fieldID][] = $path;
                                            }
                                        }
                                    }
                                }
                                elseif($arField['datatype'] == 'select' && !empty($data['INFO'][$fieldID])){
                                    $helper = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                                    if($data['INFO'][$fieldID])
                                        $data['INFO'][$fieldID] = $this->getSimpleSelectDataFormat($data['INFO'][$fieldID], $helper, true);
                                }
                                elseif($arField['datatype'] == 'multiselect' && !empty($data['INFO'][$fieldID])){
                                    $helper = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                                    if($data['INFO'][$fieldID]) {
                                        $data['INFO'][$fieldID] = $this->getSelectDataFormat($data['INFO'][$fieldID], $helper, true);
                                    }
                                }
                            }
                        }
                    }
                    
                    $data['INFO']['ID'] = $data['ID'];
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
        if($_REQUEST['entity'] == 'core_objects'){
            $arSearchFields = ['address', 'city', 'zhk_name', 'cian_zhk_name'];
            $arSearch = [];
            global $DB;
            $arRav = [];
            $dir = dirname(__FILE__);
            $arTemp = file_get_contents($dir.'/object_admin_template.json');

            $arDataByTabs = json_decode($arTemp, 1);
            foreach ($arDataByTabs as $key => $arTabData) {
                foreach ($arTabData as $fieldID => $arField) {
                    if (isset($this->data[$fieldID])) {
                        $multiple = false;
                        
                        $value = $this->data[$fieldID];
                        if(empty($value))
                            $value = NULL;
                        switch ($arField['datatype']){
                            case 'radio':
                                if(!$value)
                                    $value = NULL;
                                break;
                            case 'date':
                                $value = $DB->FormatDate($value, "DD.MM.YYYY HH:MI:SS", "YYYY-MM-DD HH:MI:SS");
                                break;
                            case 'multiselect':
                                $helper = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                                if($value) {
                                    $value = $this->getSelectDataFormat($value, $helper);
                                }
                                break;
                            case 'select':
                                $helper = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                                if($value)
                                    $value = $this->getSimpleSelectDataFormat($value, $helper);
                                break;
                            case 'file':
                                if($value) {
                                    if (!is_array($value))
                                        $value = \CFile::GetPath($value);
                                    else {
                                        $multiple = true;
                                        $arTemp = $value;
                                        $value = [];
                                        foreach ($arTemp as $val) {
                                            if(is_array($val))
                                                $val = $val['VALUE'];
                                            $io = \CBXVirtualIo::GetInstance();
                                            $strFilePath = $_SERVER["DOCUMENT_ROOT"].$val;
                                            if($io->FileExists($strFilePath) && !is_numeric($val))
                                                $value[] = $val;
                                            else
                                                $value[] = \CFile::GetPath($val);
                                        }
                                    }
                                    $value = implode(',', $value);
                                }
                                break;
                        }
                        if(!$multiple)
                            $arRav[$fieldID] = $value;
                        else
                            $arRav[$fieldID][] = $value;
    
                        if(in_array($fieldID, $arSearchFields)){
                            $arSearch[] = $arRav[$fieldID];
                        }
                    }
                }
            }
            
            if(!empty($arRav['parent_id']) && !is_null($arRav['parent_id']))
                $arRav['parent_id'] = (int)$arRav['parent_id'];
            else
                $arRav['parent_id'] = 0;
            
            $arRav['search'] = implode(' ', $arSearch);
            $this->data = ['ID' => $_REQUEST['ID'], 'INFO' => json_encode($arRav, JSON_UNESCAPED_SLASHES)];
        }

        /** @var EntityManager $entityManager */
    
        $entityManager = new static::$entityManager(static::getModel(), empty($this->data) ? array() : $this->data, $id, $this);
        $saveResult = $entityManager->save();
        $this->addNotes($entityManager->getNotes());
        return $saveResult;
    }
}