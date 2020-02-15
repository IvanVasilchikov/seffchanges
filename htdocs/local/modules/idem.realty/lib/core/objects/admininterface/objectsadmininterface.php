<?php

namespace Idem\Realty\Core\Objects\AdminInterface;
use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\ComboBoxWidget;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\FileWidget;
use DigitalWand\AdminHelper\Widget\IblockElementWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\TextAreaWidget;
use DigitalWand\AdminHelper\Widget\UserWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;
use Idem\Realty\Core\Objects\Widget\Element\Element;
use Idem\Realty\Core\Objects\Widget\Map\Map;
use Idem\Realty\Core\Objects\Widget\File\File;
/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class ObjectsAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    
    public function getTypeByBdType($type){
        switch ($type){
            case 'integer':
                $returnType = new NumberWidget();
                break;
            case 'decimal':
                $returnType = new NumberWidget();
                break;
            case 'text':
                $returnType = new StringWidget();
                break;
            case 'radio':
                $returnType = new CheckboxWidget();
                break;
            case 'date':
                $returnType = new DateTimeWidget();
                break;
            case 'select':
                $returnType = new OrmElementWidget();
                break;
            case 'multiselect':
               // $returnType = new OrmElementWidget();
                $returnType = new Element();
                break;
            case 'price':
                $returnType = new NumberWidget();
                break;
            case 'point':
                $returnType = new Map();
                break;
            case 'file':
                $returnType = new File();
                break;
            default:
                $returnType = new StringWidget();
                break;
        
        }
        
        return $returnType;
    }
    
    public function fields()
    {
        $arTabs = [
            'MAIN' => 'Основные свойства',
            'AREA' => 'Площади',
            'SEO' => 'Сео',
            'IMG' => 'Изображения',
            'MAP' => 'Карта',
            'PRICE' => 'Цены',
        ];
        $dir = dirname(__FILE__);
        $arTemp = file_get_contents($dir.'/object_admin_template.json');
        $arMenuData = [];
        $arMenuItems = json_decode($arTemp, 1);
        $arMenuFields = [
            'ID' => array(
                'WIDGET' => new NumberWidget(),
                'READONLY' => true,
                'FILTER' => true,
                'VIRTUAL' => false,
                'TITLE' => 'ID'
            )
        ];
        foreach ($arMenuItems as $key => $arMenu){
            if($key != 'MAIN')
                $arMenuFields = [];
            foreach ($arMenu as $fieldID => $arField){
                if($arField['datatype'] == 'point' && $_REQUEST['view'] == 'objects_list'){
                   continue;
                }
                if($fieldID == 'search'){
                   continue;
                }
                $arMenuFields[$fieldID] = [
                    'WIDGET' => $this->getTypeByBdType($arField['datatype']),
                    'READONLY' => false,
                    'FILTER' => true,
                    'VIRTUAL' => false,
                    'FIELD_ID' => $fieldID,//Не удалять
                    'TITLE' => $arField['name']
                ];
                if($arField['datatype'] == 'select' || $arField['datatype'] == 'multiselect'){
                    $arMenuFields[$fieldID]['HELPER'] = "Idem\Realty\Core\\".$arField['helper']."\\AdminInterface\\".$arField['helper']."ListHelper";
                    $arMenuFields[$fieldID]['TITLE_FIELD_NAME'] = 'NAME';
                }
                if($arField['datatype'] == 'radio'){
                    $arMenuFields[$fieldID]['FIELD_TYPE'] = 'integer';
                }
                if($arField['datatype'] == 'file'){
                    $arMenuFields[$fieldID]['TYPE'] = 'file';
                    if($arField['multiple'])
                        $arMenuFields[$fieldID]['MULTIPLE'] = true;
                }
            }

            $arMenuData[$key] = [
                'NAME' => $arTabs[$key],
                'FIELDS' =>$arMenuFields,
            ];
        }

        return $arMenuData;
    }

    /**
     * @inheritdoc
     */
    
    public function helpers()
    {
        return array(
            '\Idem\Realty\Core\Objects\AdminInterface\ObjectsListHelper' => array(
                'BUTTONS' => array(
                    'LIST_CREATE_NEW' => array(
                        'TEXT' => "Создать объект",
                    )
                )
            ),
            '\Idem\Realty\Core\Objects\AdminInterface\ObjectsEditHelper' => array(
                'BUTTONS' => array(
                    'ADD_ELEMENT' => array(
                        'TEXT' => "Создать объект",
                    ),
                    'DELETE_ELEMENT' => array(
                        'TEXT' => "Удалить объект",
                    )
                )
            )
        );
    }
}