<?php

namespace Idem\Realty\Core\Objects\Widget\Map;

use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Widget\HelperWidget;
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
class Map extends OrmElementWidget
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
    public function loadSettings($code = null, $map = false)
    {
        $load = parent::loadSettings($code, true);
        return $load;
    }

    /**
     * @inheritdoc
     */
    public function getEditHtml()
    {
        $value = $this->data[$this->code];
        $this->code = $this->getSettings('FIELD_ID');
		$html = $this->getMultipleEditHtml($value);

        return $html;
    }
    
    public function getMultipleEditHtml($value = "")
    {
        static $gmap_included = false;
        static $script_included = false;
        static $gmap_num = 1;
        $htmlId = 'map_'.$this->code;
        $uniqueId = strtolower($htmlId);
        $name = $this->code;
        $inputSize = (int)$this->getSettings('INPUT_SIZE');
        $windowWidth = (int)$this->getSettings('WINDOW_WIDTH');
        $windowHeight = (int)$this->getSettings('WINDOW_HEIGHT');
        global $APPLICATION;
        ob_start();
        if (!$script_included) {
            $script_included = true;
            \CJSCore::Init(array("jquery"));
            ?>
			<script src="/local/modules/idem.realty/lib/core/objects/widget/map/multiple.js"></script>
        <?}?>
		<div id="<?= $uniqueId ?>-field-container" class="map-box <?= $uniqueId ?>"></div>
        <?
        if (!$gmap_included) {
            ?>
			<script async defer src="https://maps.googleapis.com/maps/api/js?&region=RU&callback=initMapNovostroy&key=AIzaSyDznEP-R50a6HvXTtGjGDAQOZnEcde7yUI"></script>
			<script src="/local/modules/idem.realty/lib/core/objects/widget/map/script.js"></script>
            <?
            $gmap_included = true;
        }
		$map = '<input type="text" id="gmcoords{{field_id}}" name="'.$this->code.'" value="'.$value.'"><div id="GMapDiv{{field_id}}" style="width: 480px; height: 360px;"></div><div name="city" id="gm{{field_id}}_city" value="Москва"></div><div name="address" id="gm{{field_id}}_address" value=""></div><input type="text" id="gmAddr{{field_id}}" value=""><br><input type="button" id="gmbut{{field_id}}" value="Искать по адресу" onclick="gmSearchByAddr({{field_id}});"><br><br><br>';
       	//$gmapNextNum = $gmap_num + 1;
        ?>
		
		<script>
			var multiple = new MultipleWidgetHelper(
				'#<?= $uniqueId ?>-field-container',
				'<?=$map?> <span id="sp_<?=md5($name)?>_<?=$gmap_num?>" ></span>',
			  	false
			);
			multiple.addMapField({
				value: '<?= $gmap_num ?>',
				field_id: <?= $gmap_num ?>,
				element_title: '<?= static::prepareToJs($name) ?>'
			},);
			
			<?/*multiple.addMapField(undefined, <?=$gmapNextNum?>);*/?>
		</script>
		<?$gmap_num++;?>
        <?
        return ob_get_clean();
        
    }
    
	
    protected function getLinkedModel()
    {
        /**
         * @var \DigitalWand\AdminHelper\Helper\AdminBaseHelper $linkedHelper
         */
        $linkedHelper = $this->getSettings('HELPER');
        
        return $linkedHelper::getModel();
    }
    /**
     * Генерирует HTML для поля в списке.
     *
     * @param \CAdminListRow $row
     * @param array $data Данные текущей строки.
     *
     * @return void
     *
     * @see AdminListHelper::addRowCell()
     *
     * @api
     */
   /* public function generateRow(&$row, $data)
    {
        // TODO: Implement generateRow() method.
    }*/
    
    /**
     * Генерирует HTML для поля фильтрации.
     *
     * @return void
     *
     * @see AdminListHelper::createFilterForm()
     *
     * @api
     */
   /* public function showFilterHtml()
    {
        // TODO: Implement showFilterHtml() method.
    }*/
}