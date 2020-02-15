<?php

namespace Idem\Realty\Core\Seo\Widget\Element;

use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminBaseHelper;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;

Loc::loadMessages(__FILE__);

/**
 * Виджет выбора записей из ORM.
 *
 * Настройки:
 * - `HELPER` — (string) класс хелпера, из которого будет производиться поиск записией. Должен быть
 * наследником `\DigitalWand\AdminHelper\Helper\AdminBaseHelper`.
 * - `ADDITIONAL_URL_PARAMS` — (array) дополнительные параметры для URL с попапом выбора записи.
 * - `TEMPLATE` — (string) шаблон отображения виджета, может принимать значения select и radio, по-умолчанию — select.
 * - `INPUT_SIZE` — (int) значение атрибута size для input.
 * - `WINDOW_WIDTH` — (int) значение width для всплывающего окна выбора элемента.
 * - `WINDOW_HEIGHT` — (int) значение height для всплывающего окна выбора элемента.
 * - `TITLE_FIELD_NAME` — (string) название поля, из которого выводить имя элемента.
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class Element extends OrmElementWidget
{
    protected static $requireJs = false;
    protected static $defaults = array(
        'FILTER' => '=',
        'INPUT_SIZE' => 5,
        'WINDOW_WIDTH' => 600,
        'WINDOW_HEIGHT' => 500,
        'TITLE_FIELD_NAME' => 'TITLE',
        'TEMPLATE' => 'select',
        'ADDITIONAL_URL_PARAMS' => array()
    );

    /**
     * @inheritdoc
     */
    
    public function generateRow(&$row, $data)
    {
        $this->code = $this->getSettings('FIELD_ID');
    
        $strElement = $this->data[$this->code];
        if(is_null($strElement))
            $strElement = "";
        
        $row->AddViewField($this->getCode(), $strElement);
    }
    /**
     * @inheritdoc
     */
    public function getEditHtml($value = "")
    {
        //$this->entityName = 'Idem\Realty\Core\Dictionary\DictionaryTable';
        $this->code = $this->getSettings('FIELD_ID');

        $value = $this->data[$this->code];
        
        $html = "";
        
        if(!self::$requireJs){
    
            $html .= "<script src=\"/local/modules/idem.realty/lib/core/seo/widget/element/jquery-3.3.1.min.js\"></script>";
            $html .= "<script src=\"/local/modules/idem.realty/lib/core/seo/widget/element/seo.js\"></script>";
            self::$requireJs = true;
        }
        
		$html .= $this->getEditCustomSelect($value);

        return $html;
    }
    
    protected function getEditCustomSelect($value = "")
    {
        /**
         * @var AdminBaseHelper $linkedHelper
         */
        $name = 'FIELDS';
        $key = $this->getCode();
        
        $entityData = $this->getOrmElementData();
        
       
        
        $variables = "";
        foreach ($entityData as $key => $arData) {
            if($key == 0){
                $variables .= "<option value=''>Выбрать</option>";
            }
            
            $variables .= "<option ".($value == $arData['ID']?'selected':'')." value=\"".$arData['ID']."\">" . $arData['NAME']."|".$arData['CODE']. "</option>";
        }
        return '<select name="' . $this->getEditInputName() . '" id="' . $name . '[' . $key . ']">'.$variables.'</select>';
    }

	
    /**
     * Получает информацию о записях, к которым осуществлена привязка.
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     */
    protected function getOrmElementData()
    {
        \Bitrix\Main\Loader::includeModule("idem.realty");
        $refInfo = [];
        $linkedHelper = $this->getSettings('LIST_HELPER');
		
		$table = $linkedHelper::getTableName();
		$rsEntity = $linkedHelper::getList(array(
			'select' => array('ID', 'NAME', 'CODE')
		));

		while ($resBD = $rsEntity->fetch()) {
		    if($table=='i_departament') {
                if ($resBD['ID'] == 4)
                    continue;
                switch ($resBD['ID']){
                    case 1:
                        $resBD['CODE'] = LIVE_REALTY_URL;
                    break;
                    case 2:
                        $resBD['CODE'] = COMMERC_REALTY_URL;
                    break;
                    case 3:
                        $resBD['CODE'] = COUNTRY_REALTY_URL;
                    break;
                    case 5:
                        $resBD['CODE'] = FOREIGN_REALTY_URL;
                    break;
                }
            }
		    
			$refInfo[] = $resBD;
		}
        
        

        return $refInfo;
    }
   
}