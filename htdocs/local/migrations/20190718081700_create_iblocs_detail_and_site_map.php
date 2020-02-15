<?php


use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class CreateIblocsDetailAndSiteMap extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->createBlocks();
        $this->addContent();

    }

    public function down()
    {
        $this->removeContent();
        $this->removeBlocks();

    }
    private function createBlocks()
    {
        Migration::createType('content',[
            'ID'=>'content',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Контент',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        Migration::createType('locality',[
            'ID'=>'locality',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Расположение',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);

        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'pointSaitMapRu',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Пункты для карты сайта',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'pointSaitMapCom',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'EN - Пункты для карты сайта',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'areas_ru',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Районы',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "Префикс к названию района",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "PREFFIX",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'areas_en',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'EN - Районы',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "Префикс к названию района",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "PREFFIX",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'type_point_ru',
            'IBLOCK_TYPE_ID' => 'locality',
            'NAME' => 'Типы точек',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'type_point_ru'])
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'type_point_en',
            'IBLOCK_TYPE_ID' => 'locality',
            'NAME' => 'EN - Типы точек',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'type_point_en'])
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'binding_ru',
            'IBLOCK_TYPE_ID' => 'locality',
            'NAME' => 'Привязка к объектам',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "ИД объекта",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ID",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Координаты",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "COORD",
            "USER_TYPE" => "map_yandex",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Тип точек",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TYPE_POINT",
            "PROPERTY_TYPE" => "E",
            "LINK_IBLOCK_ID"=>Migration::getIBlockIdByFilter(['CODE' => 'type_point_ru']),
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_ru'])
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'binding_en',
            'IBLOCK_TYPE_ID' => 'locality',
            'NAME' => 'EN - Привязка к объектам',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "ИД объекта",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ID",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Координаты",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "COORD",
            "USER_TYPE" => "map_yandex",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Тип точек",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TYPE_POINT",
            "PROPERTY_TYPE" => "E",
            "LINK_IBLOCK_ID"=>Migration::getIBlockIdByFilter(['CODE' => 'type_point_en']),
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'binding_en'])
        ]);
    }
    private function removeBlocks(){
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'pointSaitMapRu']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'pointSaitMapCom']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'areas_ru']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'areas_en']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'type_point_ru']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'type_point_en']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'binding_ru']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'binding_en']));
        Migration::deleteType('content');
        Migration::deleteType('locality');
    }
    private function removeContent()
    {
        $arBlocks = [
            'pointSaitMapRu',
            'pointSaitMapCom',
            'areas_ru',
            'areas_en',
            'type_point_ru',
            'type_point_en',
            'binding_en',
            'binding_ru',
        ];

        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }
    }
    private function addContent()
    {
        $this->createPointSaitMap();
        $this->createArea();
        $this->createTypePoint();
        $this->createBuilding();
    }
    private function createPointSaitMap()
    {
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'pointSaitMapRu']);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Жилая",
            "CODE"=>LIVE_REALTY_URL
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Загородная",
            "CODE"=>COUNTRY_REALTY_URL
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Коммерческая",
            "CODE"=>COMMERC_REALTY_URL
        ]);
        $SectionIdLive = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockId, "CODE"=>LIVE_REALTY_URL]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Квартиры",
            "CODE" =>"/catalog/".LIVE_REALTY_URL."/?object_type=Квартира",
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Апартаменты",
            "CODE" =>"/catalog/".LIVE_REALTY_URL."/?object_type=Апартаменты",
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        $SectionIdZag = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockId,"CODE"=>COUNTRY_REALTY_URL]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Дом",
            "CODE" =>"/catalog/".COUNTRY_REALTY_URL."/?country_type=дом",
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Коттедж",
            "CODE" =>"/catalog/".COUNTRY_REALTY_URL."/?country_type=Коттедж",
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        $SectionIdComm = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockId,"CODE"=>COMMERC_REALTY_URL]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Ресторан",
            "CODE" =>"/catalog/".COMMERC_REALTY_URL."/?commerc_type=ресторан",
            "IBLOCK_SECTION_ID"=>$SectionIdComm
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Магазин",
            "CODE" =>"/catalog/".COMMERC_REALTY_URL."/?commerc_type=Магазин",
            "IBLOCK_SECTION_ID"=>$SectionIdComm
        ]);

    }
    private function createTypePoint()
    {
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'type_point_ru']);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Магазины",
            "CODE" =>"shop",
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Красота и здоровье",
            "CODE" =>"beatyAndHealht",
        ]);
    }
    private function createBuilding()
    {
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'binding_ru']);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Ло5 5 #537366",
            "CODE"=>"#537366"
        ]);
        $SectionIdLive = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockId,"CODE"=>"#537366"]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Осетинские Пироги ДолПирог",
            "IBLOCK_SECTION_ID"=>$SectionIdLive,
            "PROPERTY_VALUES" => [
                "ID" => 537366,
                "COORD" => "55.752498, 37.639993",
                "TYPE_POINT" => Migration::getElementIdByFilter(["IBLOCK_CODE"=>"type_point_ru", "CODE"=>"shop"]),
            ]
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Иварус",
            "IBLOCK_SECTION_ID"=>$SectionIdLive,
            "PROPERTY_VALUES" => [
                "ID" => 537366,
                "COORD" => "55.751987, 37.640861",
                "TYPE_POINT" => Migration::getElementIdByFilter(["IBLOCK_CODE"=>"type_point_ru", "CODE"=>"shop"]),
            ]
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "МАГАЗИН МЯСНОЙ ПРОДУКЦИИ, ОАО \"Раменский Мясокомбинат\"",
            "IBLOCK_SECTION_ID"=>$SectionIdLive,
            "PROPERTY_VALUES" => [
                "ID" => 537366,
                "COORD" => "55.753308, 37.638640",
                "TYPE_POINT" => Migration::getElementIdByFilter(["IBLOCK_CODE"=>"type_point_ru", "CODE"=>"shop"]),
            ]
        ]);
    }
    private function createArea(){
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'areas_ru']);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Тверской",
            "PREVIEW_TEXT" =>"Тверской район расположен в Центральном административном округе (ЦАО) от Манежной площади до Белорусского вокзала, занимает площадь в 7,27 км2, населен 73,8 тыс. человек (на 1 января 2010 года) и насчитывает 179 улиц. Тверской район был образован 5 июля 1995 года, а муниципальное образование Тверское 15 октября 2003 года. Муниципальное образование и район Тверской получили свои названия благодаря улице Тверская.",
            "PROPERTY_VALUES" => [
                "PREFFIX" => "Район",
            ]
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Хамовники",
            "PREVIEW_TEXT" =>"Хамовники являются одним из самых востребованных районов столицы среди покупателей жилья. Однако доступен район не всем: средние цены квадратного метра на первичном и вторичном рынках в этом районе составляют 738,2 и 768,8 тыс. руб. соответственно, отмечают опрошенные редакцией «РБК-Недвижимость» риелторы.",
            "PROPERTY_VALUES" => [
                "PREFFIX" => "Район",
            ]
        ]);
    }
}
