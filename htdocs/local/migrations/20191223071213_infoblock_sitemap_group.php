<?php
include_once __DIR__.'/../modules/idem.realty/lib/utilities/migration.php';

use Phinx\Migration\AbstractMigration;
use Idem\Realty\Utilities\Migration;

class InfoblockSitemapGroup extends AbstractMigration
{
    public function up()
    {        
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'group_zhk_sitemap',
            'IBLOCK_TYPE_ID' => 'zhk_sitemap',
            'NAME' => 'Sitemap выборка',
            'SECTION_PAGE_URL'=>'#SITE_DIR#/gorod/#SECTION_CODE_PATH#/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/gorod/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("2" => "R", "5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);

        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'group_country_sitemap',
            'IBLOCK_TYPE_ID' => 'country_sitemap',
            'NAME' => 'Sitemap выборка',
            'SECTION_PAGE_URL'=>'#SITE_DIR#/zagorod/#SECTION_CODE_PATH#/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/zagorod/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("2" => "R", "5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'group_commerc_sitemap',
            'IBLOCK_TYPE_ID' => 'commerc_sitemap',
            'NAME' => 'Sitemap выборка',
            'SECTION_PAGE_URL'=>'#SITE_DIR#/commerce/#SECTION_CODE_PATH#/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/commerce/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("2" => "R", "5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);  

        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'group_foreign_sitemap',
            'IBLOCK_TYPE_ID' => 'foreign_sitemap',
            'NAME' => 'Sitemap выборка',
            'SECTION_PAGE_URL'=>'#SITE_DIR#/foreign-real-estate/#SECTION_CODE_PATH#/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/foreign-real-estate/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("2" => "R", "5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);  
    }
    
    public function down()
    {
        $this->removeContent();
        $this->removeBlocks();
    }
    private function removeContent()
    {
        $arBlocks = [
            'group_zhk_sitemap',
            'group_country_sitemap',
            'group_commerc_sitemap',
            'group_foreign_sitemap',
        ];
        
        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }
    }
    private function removeBlocks(){
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'group_zhk_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'group_country_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'group_commerc_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'group_foreign_sitemap']));        
    }
}
