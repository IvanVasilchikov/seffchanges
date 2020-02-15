<?php

namespace Idem\Realty\Core\Objects\Widget\Element;

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
    public function loadSettings($code = null)
    {
        $load = parent::loadSettings($code);

        if (!is_subclass_of($this->getSettings('HELPER'), '\DigitalWand\AdminHelper\Helper\AdminBaseHelper'))
        {
            throw new ArgumentTypeException('HELPER', '\DigitalWand\AdminHelper\Helper\AdminBaseHelper');
        }

        if (!is_array($this->getSettings('ADDITIONAL_URL_PARAMS')))
        {
            throw new ArgumentTypeException('ADDITIONAL_URL_PARAMS', 'array');
        }

        return $load;
    }

    /**
     * @inheritdoc
     */
    public function getEditHtml($value = "")
    {
        //$this->entityName = 'Idem\Realty\Core\Dictionary\DictionaryTable';
        $this->code = $this->getSettings('FIELD_ID');

        $value = $this->data[$this->code];

        if($this->getSettings('SIMPLE'))
		    $html = $this->getEditHtmlSelect($value);
        else
            $html = $this->getMultipleEditHtml($value);

        return $html;
    }

    protected function getEditHtmlSelect($value = "")
    {
        /**
         * @var AdminBaseHelper $linkedHelper
         */
        $linkedHelper = $this->getSettings('HELPER');
        $inputSize = (int) $this->getSettings('INPUT_SIZE');
        $windowWidth = (int) $this->getSettings('WINDOW_WIDTH');
        $windowHeight = (int) $this->getSettings('WINDOW_HEIGHT');

        $name = 'FIELDS';
        $key = $this->code;

        $entityData = $this->getOrmElementData($value);

        if (!empty($entityData)) {
            $elementId = $entityData['ID'];
            $elementName = $entityData['VALUE'];
        } else {
            $elementId = '';
        }

        $popupUrl = $linkedHelper::getUrl(array_merge(
            array(
                'popup' => 'Y',
                'eltitle' => $this->getSettings('TITLE_FIELD_NAME'),
                'n' => $name,
                'k' => $key
            ),
            $this->getSettings('ADDITIONAL_URL_PARAMS')
        ));

        return '<input name="' . $this->getEditInputName() . '"
                     id="' . $name . '[' . $key . ']"
                     value="' . $elementId . '"
                     size="' . $inputSize . '"
                     type="text">' .
            '<input type="button"
                    value="..." onClick="jsUtils.OpenWindow(\''. $popupUrl . '\', ' . $windowWidth . ', '
            . $windowHeight . ');">' . '&nbsp;<span id="sp_' . md5($name) . '_' . $key . '" >' .
            static::prepareToOutput($elementName)
            . '</span>';
    }
    /**
     * Генерирует HTML с выбором элемента в виде радио инпутов.
     *
     * @return string
     */
  
    public function getMultipleEditHtml($value = "")
    {
        /**
         * @var AdminBaseHelper $linkedHelper
         */
        static $script_included = false;
        $linkedHelper = $this->getSettings('HELPER');
        $inputSize = (int)$this->getSettings('INPUT_SIZE');
        $windowWidth = (int)$this->getSettings('WINDOW_WIDTH');
        $windowHeight = (int)$this->getSettings('WINDOW_HEIGHT');

        $name = 'FIELDS['.$this->code.']';
        $key = $this->code;
		
        $htmlId = end(explode('\\', $linkedHelper)) . '-' . $this->code;
        $uniqueId = strtolower($htmlId);
		
        $entityListData = $value;
        //$entityListData = $this->getOrmElementData($value, true);
      
        $popupUrl = $linkedHelper::getUrl(array_merge(
            array(
                'popup' => 'Y',
                'eltitle' => 'VALUE',
                'n' => $name,
                'k' => '{{field_id}}'
            ),
            $this->getSettings('ADDITIONAL_URL_PARAMS')
        ));
        $popupUrl .= '&find_FIELD_ID='.$this->code;
        ob_start();
        
		if (!$script_included) {
			$script_included = true;
            \CJSCore::Init(array("jquery"));
			?>
			<script src="/local/modules/idem.realty/lib/core/objects/widget/map/multiple.js"></script>
		<?}?>
		<div id="<?= $uniqueId ?>-field-container" class="<?= $uniqueId ?>"></div>

		<script>
			var multiple = new MultipleWidgetHelper(
				'#<?= $uniqueId ?>-field-container',
				'<input name="<?=$name?>[{{field_id}}]"' +
				'id="<?=$name?>[{{field_id}}]"' +
				'value="{{value}}"' +
				'size="<?=$inputSize?>"' +
				'type="text">' +
				'<input type="button"' +
				'value="..."' +
				'onClick="jsUtils.OpenWindow(\'<?=$popupUrl?>\', <?=$windowWidth?>, <?=$windowHeight?>);">' +
				'&nbsp;<span id="sp_<?=md5($name)?>_{{field_id}}" >{{element_title}}</span>',
			  	true
			);
			<?
			
			if (!empty($entityListData))
			{
				foreach($entityListData as $referenceData)
				{
					$elementId = $referenceData['ID'];
					$elementName = $referenceData['NAME'];
					
					?>
					multiple.addField({
						value: '<?= $elementId ?>',
						field_id: <?= $elementId ?>,
						element_title: '<?= static::prepareToJs($elementName) ?>'
					});
					<?
				}
			}
			?>
			multiple.addField();
		</script>
        <?
        return ob_get_clean();
    }

	
    /**
     * Получает информацию о записях, к которым осуществлена привязка.
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     */
    protected function getOrmElementData($value = "", $multiple = false)
    {
        $refInfo = [];
        $linkedModel = $this->getLinkedModel();
        
		if (!empty($value)) {
			if($multiple){
                $arValues = explode(',', $value);
				
			   	foreach ($arValues as $searchVal) {
                    $rsMultEntity = $linkedModel::getList(array(
                        'select' =>  array('ID', 'NAME','CODE'),
                        'filter' => array('NAME' => $searchVal)
                    ));
                 
                    while ($multEntity = $rsMultEntity->fetch()) {
                        $refInfo[] = $multEntity;
                    }
               	}
            }
            else {
                $rsEntity = $linkedModel::getList(array(
                    'select' => array('ID', 'NAME', 'CODE'),
                    'filter' => array('NAME' => $value)
                ));
    
                while ($entity = $rsEntity->fetch())
                    $refInfo = $entity;
            }
        }

        return $refInfo;
    }

    /**
     * Получает информацию о всех активных элементах для их выбора в виджете.
     *
     * @return array
     *
     * @throws \Bitrix\Main\ArgumentException
     */
    protected function getOrmElementList()
    {
        $valueList = null;
        $linkedModel = $this->getLinkedModel();

        $rsEntity = $linkedModel::getList(array(
            'filter' => array(
                'ACTIVE' => 1
            ),
            'select' => array(
                'ID',
                'TITLE'
            )
        ));

        while ($entity = $rsEntity->fetch()) {
            $valueList[] = $entity;
        }

        return $valueList;
    }

    /**
     * Возвращает связанную модель.
     *
     * @return \Bitrix\Main\Entity\DataManager
     */
    protected function getLinkedModel()
    {
        return 'Idem\Realty\Core\Dictionary\DictionaryTable';
    }
}