<?php
include_once __DIR__.'/../modules/idem.realty/lib/utilities/migration.php';

use Phinx\Migration\AbstractMigration;
use Idem\Realty\Utilities\Migration;

class MapPoints extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        Migration::createIBlock([
            'LID' => 's1',
            'CODE' => 'about_map_points_ru',
            'IBLOCK_TYPE_ID' => 'company',
            'NAME' => 'Точки на карте',
            'DETAIL_PAGE_URL' => '',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createIBlock([
            'LID' => 's2',
            'CODE' => 'about_map_points_en',
            'IBLOCK_TYPE_ID' => 'company',
            'NAME' => 'EN - Точки на карте',
            'DETAIL_PAGE_URL' => '',
            'ACTIVE' => 'Y',
            'INDEX_ELEMENT' => 'Y',
            "GROUP_ID" => Array("5" => "R", "6" => "X"),
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        Migration::createProperties([
            "NAME" => "Точка на карте",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "MAP",
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "map_google",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Точка на карте",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "MAP",
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "map_google",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Тип",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TYPE",
            "PROPERTY_TYPE" => "E",
            "IBLOCK_ID" =>  Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_ru']),
            "LINK_IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'type_point_ru']),
        ]);
        Migration::createProperties([
            "NAME" => "Тип",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TYPE",
            "PROPERTY_TYPE" => "E",
            "IBLOCK_ID" =>  Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_en']),
            "LINK_IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'type_point_en']),
        ]);
        $arPoints = [
            "-33.718234, 150.363181",
            "-33.727111, 150.371124",
            "-33.848588, 151.209834",
            "-33.851702, 151.216968",
            "-34.671264, 150.863657",
            "-34.571264, 150.863657",
        ];
        
        $arTypes = [
            [
                "VALUE" => "shops",
                "DEF" => "N",
                "XML_ID" => "shops",
                "SORT" => "100",
                "SVG" => "/assets/svg/map/shop.svg"
            ],
            [
                "VALUE" => "health&beauty",
                "DEF" => "N",
                "XML_ID" => "health&beauty",
                "SORT" => "200",
                "SVG" => "/assets/svg/map/health.svg"
            ],
            [
                "VALUE" => "kindergarten",
                "DEF" => "N",
                "XML_ID" => "kindergarten",
                "SORT" => "300",
                "SVG" => "/assets/svg/map/baby.svg"
            ],
            [
                "VALUE" => "education",
                "DEF" => "N",
                "XML_ID" => "education",
                "SORT" => "400",
                "SVG" => "/assets/svg/map/education.svg"
            ],
            [
                "VALUE" => "fun",
                "DEF" => "N",
                "XML_ID" => "fun",
                "SORT" => "500",
                "SVG" => "/assets/svg/map/movie.svg"
            ],
            [
                "VALUE" => "fun",
                "DEF" => "N",
                "XML_ID" => "fun",
                "SORT" => "500",
                "SVG" => "/assets/svg/map/coffee.svg"
            ]
        ];
       
        $arLangs = ['ru','en'];
        $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
        foreach ($arLangs as $lang) {
            $propVals = [];
            $db_enum_list = CIBlockProperty::GetPropertyEnum("TYPE", Array(), Array("IBLOCK_ID"=>Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_'.$lang])));
            while($ar_enum_list = $db_enum_list->GetNext())
            {
                $propVals[$ar_enum_list['VALUE']] = $ar_enum_list['ID'];
            }
            foreach ($arTypes as $key => $arType) {
                $id = Migration::createElement([
                    "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'type_point_'.$lang]),
                    "NAME" => $arType['VALUE'],
                    "CODE" => $arType['VALUE'],
                    "PROPERTY_VALUES" => [
                        "ICON" => \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$arType['SVG'])
                    ]
                ]);
                Migration::createElement([
                    "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'about_map_points_'.$lang]),
                    "NAME" => "Точка ".($key+1),
                    "PROPERTY_VALUES" => [
                        "MAP" => $arPoints[$key],
                        "TYPE" => $id
                    ]
                ]);
            }
        }
    }
    public function down()
    {
        $arBlocks = [
            'about_map_points_ru',
            'about_map_points_en',
        ];

        foreach ($arBlocks as $block){
            Migration::removeAllInIBlock($block);
        }
        Migration::deleteIBlock('about_map_points_ru',"s1");
        Migration::deleteIBlock('about_map_points_en',"s2");
    }
}
