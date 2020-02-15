<?php
include_once __DIR__.'/../modules/idem.realty/lib/utilities/migration.php';

use Phinx\Migration\AbstractMigration;
use Idem\Realty\Utilities\Migration;

class SitemapsIblocks extends AbstractMigration
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
        Migration::createType('zhk_sitemap',[
            'ID'=>'zhk_sitemap',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Sitemap ЖК',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'zhk_sitemap',
            'IBLOCK_TYPE_ID' => 'zhk_sitemap',
            'NAME' => 'Sitemap ЖК',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/catalog/live/#CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        
        
        
        Migration::createType('country_sitemap',[
            'ID'=>'country_sitemap',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Sitemap Загородки',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'country_sitemap',
            'IBLOCK_TYPE_ID' => 'country_sitemap',
            'NAME' => 'Sitemap Загородки',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/catalog/country/#CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        
        
        Migration::createType('commerc_sitemap',[
            'ID'=>'commerc_sitemap',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Sitemap коммерции',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'commerc_sitemap',
            'IBLOCK_TYPE_ID' => 'commerc_sitemap',
            'NAME' => 'Sitemap коммерции',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/catalog/commerc/#CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        
        Migration::createType('foreign_sitemap',[
            'ID'=>'foreign_sitemap',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Sitemap зарубежки',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'foreign_sitemap',
            'IBLOCK_TYPE_ID' => 'foreign_sitemap',
            'NAME' => 'Sitemap зарубежки',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/catalog/foreign/#CODE#/',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
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
            'zhk_sitemap',
            'foreign_sitemap',
            'country_sitemap',
            'commerc_sitemap',
        ];
        
        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }
    }
    private function removeBlocks(){
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'zhk_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'foreign_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'country_sitemap']));
        Migration::deleteIBlock(Migration::getIBlockIdByFilter(['CODE' => 'commerc_sitemap']));
        Migration::deleteType('zhk_sitemap');
        Migration::deleteType('foreign_sitemap');
        Migration::deleteType('country_sitemap');
        Migration::deleteType('commerc_sitemap');
    }
}
