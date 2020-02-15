<?php

if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php";
use Idem\Realty\Utilities\Migration;
use Phinx\Migration\AbstractMigration;

class SortMenu extends AbstractMigration
{
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
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'sortMenuRu',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Сортировка для главного меню',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'sortMenuCom',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'EN - Сортировка для главного меню',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);

    }

    private function addContent()
    {
        $iBlockIdRu = Migration::getIBlockIdByFilter(['CODE' => 'sortMenuRu']);        
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Жилая",
            "CODE"=>"gorod"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Загородная",
            "CODE"=>"zagorod"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Коммерческая",
            "CODE"=>"commerce"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Зарубежная",
            "CODE"=>"zarubezhnaya"
        ]);
        $SectionIdLive = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockIdRu, "CODE"=>1]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Квартира",
            "SORT" =>100,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Апартаменты",
            "SORT" =>200,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Пентхаус",
            "SORT" =>300,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Вилла",
            "SORT" =>400,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Таунхаус",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Особняк",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Апартаменты",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdLive
        ]);
        $SectionIdZag = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockIdRu,"CODE"=>3]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Дом",
            "SORT" =>100,
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Участок",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Таунхаус",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Посёлки",
            "SORT" =>500,
            "IBLOCK_SECTION_ID"=>$SectionIdZag
        ]);
        $SectionIdComm = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockIdRu,"CODE"=>2]);        
        $SectionIdComm = Migration::getSectionIdByFilter(["IBLOCK_CODE"=>$iBlockIdRu,"CODE"=>5]);  

        $iBlockIdEn = Migration::getIBlockIdByFilter(['CODE' => 'sortMenuCom']);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Жилая",
            "CODE"=>"gorod"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Загородная",
            "CODE"=>"zagorod"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Коммерческая",
            "CODE"=>"commerce"
        ]);
        Migration::createSection([
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Зарубежная",
            "CODE"=>"zarubezhnaya"
        ]);     
    }

    private function removeContent()
    {
        $arBlocks = [
            'sortMenuRu',
            'sortMenuCom',
        ];

        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }        
    }

    private function removeBlocks()
    {
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'sortMenuRu']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'sortMenuCom']));        
    }
}
