<?php
namespace Idem\Realty\Wizards;

use Bitrix\Main\Entity;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;

Loader::includeModule("idem.realty");

class Install
{
    public static function GetFieldType(Entity\Field $field) {
        if ($field instanceof Entity\IntegerField)
            return 'integer';
        if ($field instanceof Entity\DatetimeField)
            return 'datetime';
        if ($field instanceof Entity\DateField)
            return 'date';
        if ($field instanceof Entity\BooleanField)
            return 'boolean';
        if ($field instanceof Entity\FloatField)
            return 'float';
        if ($field instanceof Entity\EnumField)
            return 'enum';
        if ($field instanceof Entity\TextField)
            return 'text';
        if ($field instanceof Entity\StringField)
            return 'string';
        if ($field instanceof Entity\ExpressionField)
            return 'expression';
        if ($field instanceof Entity\ReferenceField)
            return 'reference';
    }
    
    
    public function DropTable($entity = '') {
        Loader::includeModule('idem.realty');
        if(!empty($entity)) {
            $entityTable = $entity;
            $sqlQuery = "DROP TABLE IF EXISTS `" . $entityTable::getTableName() . "`;";
            Application::getConnection()->query($sqlQuery);
        }
    }
    
    public function CreateHLTable($entity = '',$code = '', $ruName = '', $enName = '') {
        $entityTable = $entity;
        $tableName = $entityTable::getTableName();
        $fieldsMap = $entityTable::getMap();
        $arFields = [];
        foreach ($fieldsMap as &$fieldObj) {
            $data_type = self::GetFieldType($fieldObj);
            if ($data_type == 'reference' || $data_type == 'expression' || $data_type == '')
                continue;
            $arFields[] = $fieldObj->getName();
        }
        $res = \Idem\Realty\Hload\EntityTable::add(['NAME'=>ToUpper($code),'TABLE_NAME'=>$tableName]);
        if ($res->isSuccess()) {
            $rowID = $res->getId();
            \Idem\Realty\Hload\LangTable::add(['ID' => $rowID, 'NAME' => $ruName,'LID' => 'ru']);
            \Idem\Realty\Hload\LangTable::add(['ID' => $rowID, 'NAME' => $enName,'LID' => 'en']);
            foreach ($arFields as $key => $name)
                \Idem\Realty\Hload\FieldsTable::add(['ENTITY_ID' => 'HLBLOCK_'.$rowID, 'FIELD_NAME' => $name,'USER_TYPE_ID' => 'string','XML_ID' => '','SORT' => $key,'MULTIPLE' => 'N','MANDATORY' => 'N','SHOW_FILTER' => 'N','SHOW_IN_LIST' => 'Y','EDIT_IN_LIST' => 'Y','IS_SEARCHABLE' => 'N','SETTINGS' => serialize(['SIZE'=>20,'ROWS'=>1,'REGEXP'=>0,'MIN_LENGTH'=>0,'MAX_LENGTH'=>0,'DEFAULT_VALUE'=>''])]);
        }
    }
    
    public function DropHLTable($code = '') {
        if(!empty($code)) {
            $resVal = \Idem\Realty\Hload\EntityTable::getList([
                'select' => array('*'),
                'filter' => ['NAME' => ToUpper($code)]
            ]);
            if ($arValue = $resVal->fetch()) {
                \Idem\Realty\Hload\LangTable::delete($arValue['ID']);
                $resFieldsVal = \Idem\Realty\Hload\FieldsTable::getList([
                    'select' => array('*'),
                    'filter' => ['ENTITY_ID' => 'HLBLOCK_' . $arValue['ID']]
                ]);
                while ($arFieldsValue = $resFieldsVal->fetch()) {
                    \Idem\Realty\Hload\FieldsTable::delete($arFieldsValue['ID']);
                    \Idem\Realty\Hload\FieldsTable::delete($arFieldsValue['ID']);
                }
                \Idem\Realty\Hload\EntityTable::delete($arValue['ID']);
            }
        }
    }
    
    public function CreateTable($entity = '') {
        if(empty($entity))
            return;
        
        $entityTable = $entity;
        $query = "";
        
        $index = array();
        $queryFields = array();
        $primaryKey = '';
        $uniqueKey = '';
        $fieldsMap = $entityTable::getMap();
        foreach ($fieldsMap as &$fieldObj) {
            $code = $fieldObj->getName();
            
            $data_type = self::GetFieldType($fieldObj);
            if ($data_type == 'reference' || $data_type == 'expression' || $data_type == '')
                continue;
            $size = 0;
            if($data_type == 'string')
                $size = $fieldObj->getSize();
            
            if ($fieldObj->isPrimary()) {
                $primaryKey = ", PRIMARY KEY (`{$code}`)";
            }
            
            if ($fieldObj->isUnique()) {
                $uniqueKey = ", UNIQUE KEY (`{$code}`)";
            }
            
            $autocomplete = '';
            if ($code == 'ID') {
                $autocomplete = ' AUTO_INCREMENT';
            }
            
            $type = '';
            switch ($data_type) {
                case 'boolean':
                    $type = 'TINYINT(1)';
                    break;
                case 'date':
                    $type = 'DATE';
                    break;
                case 'datetime':
                    $type = 'DATETIME';
                    break;
                case 'float':
                    $type = 'DOUBLE';
                    break;
                case 'integer':
                    $type = 'INTEGER';// DEFAULT NULL
                    break;
                case 'string':
                    if(!empty($size))
                        $type = 'VARCHAR('.$size.')';
                    else
                        $type = 'VARCHAR(255)';
                    break;
                case 'text':
                    $type = 'TEXT';
                    break;
            }
            
            if (strlen($type) > 0) {
                if (!empty($autocomplete))
                    $queryFields[] = "`{$code}` {$type} NOT NULL{$autocomplete}";
                elseif ($data_type == 'date' || $data_type == 'datetime') {
                    $queryFields[] = "`{$code}` {$type} DEFAULT CURRENT_TIMESTAMP";
                } else
                    $queryFields[] = "`{$code}` {$type}";
            }
        }
        
        if (count($queryFields) > 0) {
            $query .= implode(', ', $queryFields);
        }
        
        if (strlen($primaryKey) > 0) {
            $query .= $primaryKey;
        }
        if (strlen($uniqueKey) > 0) {
            $query .= $uniqueKey;
        }
        
        if (count($index) > 0) {
            $query .= ', ' . implode(', ', $index);
        }
        
        if (strlen($query) > 0) {
            $sqlDropQuery = "DROP TABLE IF EXISTS `" . $entityTable::getTableName()."`";
            Application::getConnection()->query($sqlDropQuery);
            $sqlQuery = "CREATE TABLE `" . $entityTable::getTableName() . "` ({$query})";
            Application::getConnection()->query($sqlQuery);
        }
    }
}
