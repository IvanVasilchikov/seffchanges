<?php

namespace Idem\Realty\Core\Seo\AdminInterface;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\TextAreaWidget;
use Idem\Realty\Core\Seo\Widget\Element\Element;
use Idem\Realty\Core\Objects\Widget\Map\Map;
use Idem\Realty\Core\Objects\Widget\File\File;
/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class SeoAdminInterface extends AdminInterface
{
    
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
            case 'textarea':
                $returnType = new TextAreaWidget();
                break;
            case 'radio':
                $returnType = new CheckboxWidget();
                break;
            case 'date':
                $returnType = new DateTimeWidget();
                break;
            case 'select':
                $returnType = new Element();
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

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $arTabs = [
            'MAIN' => 'Основные свойства'
        ];
        $dir = dirname(__FILE__);
        $arTemp = file_get_contents($dir.'/seo_admin_template.json');
        $arMenuData = [];
        $arMenuItems = json_decode($arTemp, 1);
        $arMenuFields = [
            'ID' => array(
                'WIDGET' => new NumberWidget(),
                'READONLY' => true,
                'FILTER' => true,
                'VIRTUAL' => false,
                'TITLE' => 'ID'
            ),
            'LINK' => array(
                'WIDGET' => new StringWidget(),
                'READONLY' => false,
                'FILTER' => true,
                'VIRTUAL' => false,
                'TITLE' => 'Ссылка(формируется автоматически при выборе параметров фильтра)'
            )
        ];
        foreach ($arMenuItems as $key => $arMenu){
            if($key != 'MAIN')
                $arMenuFields = [];
            foreach ($arMenu as $fieldID => $arField){
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
                    $arMenuFields[$fieldID]['LIST_HELPER'] = "Idem\Realty\Core\\".$arField['helper']."\\".$arField['helper']."Table";
                    $arMenuFields[$fieldID]['TITLE_FIELD_NAME'] = 'NAME';
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
            '\Idem\Realty\Core\Seo\AdminInterface\SeoListHelper' => array(
                'BUTTONS' => array(
                    'LIST_CREATE_NEW' => array(
                        'TEXT' => "Создать Сео",
                    ),
                )
            ),
            '\Idem\Realty\Core\Seo\AdminInterface\SeoEditHelper' => array(
                'BUTTONS' => array(
                    'ADD_ELEMENT' => array(
                        'TEXT' => "Создать Сео",
                    ),
                    'DELETE_ELEMENT' => array(
                        'TEXT' => "Удалить Сео",
                    )
                )
            )
        );
    }
}