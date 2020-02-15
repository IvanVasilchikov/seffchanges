<?php

if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php";
use Idem\Realty\Utilities\Migration;
use Phinx\Migration\AbstractMigration;

class TagsFilters extends AbstractMigration
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
            'CODE' => 'tagsFiltersRu',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Теги для фильтра на главной',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'tagsFiltersCom',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'EN - Теги для фильтра на главной',
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
        $iBlockIdRu = Migration::getIBlockIdByFilter(['CODE' => 'tagsFiltersRu']);        
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "ЭКСКЛЮЗИВ",
            "CODE" =>"/gorod/eksklyuziv/"
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Акция",
            "CODE" =>"/gorod/aktsiya/"
        ]);

        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdRu,
            "NAME" => "Вид на воду",
            "CODE" =>"/gorod/vid-na-vodu/"
        ]);

        $iBlockIdEn = Migration::getIBlockIdByFilter(['CODE' => 'tagsFiltersCom']);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "ЭКСКЛЮЗИВ",
            "CODE" =>"/gorod/eksklyuziv/"
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Акция",
            "CODE" =>"/gorod/aktsiya/"
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockIdEn,
            "NAME" => "Вид на воду",
            "CODE" =>"/gorod/vid-na-vodu/"
        ]);        
    }

    private function removeContent()
    {
        $arBlocks = [
            'tagsFiltersRu',
            'tagsFiltersCom',
        ];

        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }        
    }

    private function removeBlocks()
    {
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'tagsFiltersRu']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'tagsFiltersCom']));        
    }
}
