<?php

use Phinx\Migration\AbstractMigration;

if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php");

use Idem\Realty\Utilities\Migration;

class DistrictsInfo extends AbstractMigration
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
        $this->addProp();
        $this->addContent();
    }

    public function down()
    {
        $this->removeProp();
        $this->removeContent();
    }

    private function addProp()
    {
        Migration::createProperties([
            "NAME" => "Пункты для шапки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICO_HEADER",
            "MULTIPLE" => "Y",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Блок к числами",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "BLOCK_NUMBER",
            "MULTIPLE" => "Y",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Второй заголовок",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "SUB_TITLE",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Экология",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ECOLOGY_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Безопасность",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "SECURITY_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Транспорт",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TRANSPORT_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Расположение",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "PLACE_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Заголовок в футере",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "FOOTER_TITLE",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Текст в футере",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "FOOTER_TEXT",
            "USER_TYPE" => "HTML",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_ru'])
        ]);


        Migration::createProperties([
            "NAME" => "Пункты для шапки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICO_HEADER",
            "MULTIPLE" => "Y",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Блок к числами",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "BLOCK_NUMBER",
            "MULTIPLE" => "Y",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Второй заголовок",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "SUB_TITLE",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Экология",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ECOLOGY_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Безопасность",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "SECURITY_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Транспорт",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "TRANSPORT_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Расположение",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "PLACE_SLIDER",
            "MULTIPLE" => "N",
            "WITH_DESCRIPTION" => "Y",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Заголовок в футере",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "FOOTER_TITLE",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
        Migration::createProperties([
            "NAME" => "Текст в футере",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "FOOTER_TEXT",
            "USER_TYPE" => "HTML",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'areas_en'])
        ]);
    }

    private function addContent()
    {
        Migration::removeAllInIBlock('areas_ru');
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'areas_ru']);
        $pathImg = '/assets/images/';
        $filePrev = \CFile::MakeFileArray($pathImg.'district-bg-desktop.jpg');

        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "PREVIEW_PICTURE" => $filePrev,
            "NAME" => "Тверской",
            "CODE"=>"tverskoy",
            "PREVIEW_TEXT" => "Тверской район расположен в Центральном административном округе (ЦАО) от Манежной площади до Белорусского вокзала, занимает площадь в 7,27 км2, населен 73,8 тыс. человек (на 1 января 2010 года) и насчитывает 179 улиц. Тверской район был образован 5 июля 1995 года, а муниципальное образование Тверское 15 октября 2003 года. Муниципальное образование и район Тверской получили свои названия благодаря улице Тверская.",
            "DETAIL_TEXT" =>"Хамовники являются одним из самых востребованных районов столицы среди покупателей жилья. Однако доступен район не всем: средние цены квадратного метра на первичном и вторичном рынках в этом районе составляют 738,2 и 768,8 тыс. руб. соответственно, отмечают опрошенные редакцией «РБК-Недвижимость» риелторы.<br>Сейчас Хамовники, по оценке риелторов, пользуются популярностью из-за центрального расположения, хорошей экологии и транспортной доступности. В районе много парков, через район протекает Москва-река. Здесь нет комфорт-класса среди новостроек. На вторичном рынке представлены все типы жилья: дореволюционные, сталинские, кирпичные дома ЦК и панельные пятиэтажки.",
            "PROPERTY_VALUES" => [
                "PREFFIX" => "Район",
                "SUB_TITLE" => "Готовые дома комфорт-класса в москве",
                "FOOTER_TITLE" => "элитная<br> недвижимость<br> в Тверском районе",
                "FOOTER_TEXT" => "Хамовники один из наиболее престижных районов Москвы – сочетают в себе все, что необходимо для комфортного проживания в уединении. Перспективный район со множеством респектабельных зданий, превосходная инфраструктура, максимальная доступность необходимых объектов делают жилье одним из наиболее востребованных на столичном рынке. Квартиры в Хамовниках отличаются также великолепным разнообразием – клиентам агентства предлагаются просторные многокомнатные апартаменты и небольшие уютные студии – на любой вкус. Мы готовы предложить своим клиентам жилье, полностью соответствующее их пожеланиям – в подходящем объекте и необходимой конфигурации. Возможность купить квартиру в Хамовниках представляет собой как успешную долгосрочную инвестицию, так и выбор превосходного района для комфортного проживания.",
            ]
        ]);
        Migration::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Хамовники",
            "PREVIEW_PICTURE" => $filePrev,
            "CODE"=>"khamovniki",
            "PREVIEW_TEXT" => "Хамовники являются одним из самых востребованных районов столицы среди покупателей жилья. Однако доступен район не всем: средние цены квадратного метра на первичном и вторичном рынках в этом районе составляют 738,2 и 768,8 тыс. руб. соответственно, отмечают опрошенные редакцией «РБК-Недвижимость» риелторы.",
            "DETAIL_TEXT" =>"Хамовники являются одним из самых востребованных районов столицы среди покупателей жилья. Однако доступен район не всем: средние цены квадратного метра на первичном и вторичном рынках в этом районе составляют 738,2 и 768,8 тыс. руб. соответственно, отмечают опрошенные редакцией «РБК-Недвижимость» риелторы.<br>Сейчас Хамовники, по оценке риелторов, пользуются популярностью из-за центрального расположения, хорошей экологии и транспортной доступности. В районе много парков, через район протекает Москва-река. Здесь нет комфорт-класса среди новостроек. На вторичном рынке представлены все типы жилья: дореволюционные, сталинские, кирпичные дома ЦК и панельные пятиэтажки.",
            "PROPERTY_VALUES" => [
                "PREFFIX" => "Район",
                "SUB_TITLE" => "Готовые дома комфорт-класса в москве",
                "FOOTER_TITLE" => "элитная<br> недвижимость<br> в Хамовниках",
                "FOOTER_TEXT" => "Хамовники один из наиболее престижных районов Москвы – сочетают в себе все, что необходимо для комфортного проживания в уединении. Перспективный район со множеством респектабельных зданий, превосходная инфраструктура, максимальная доступность необходимых объектов делают жилье одним из наиболее востребованных на столичном рынке. Квартиры в Хамовниках отличаются также великолепным разнообразием – клиентам агентства предлагаются просторные многокомнатные апартаменты и небольшие уютные студии – на любой вкус. Мы готовы предложить своим клиентам жилье, полностью соответствующее их пожеланиям – в подходящем объекте и необходимой конфигурации. Возможность купить квартиру в Хамовниках представляет собой как успешную долгосрочную инвестицию, так и выбор превосходного района для комфортного проживания.",
            ]
        ]);
        $pathSvg = '/assets/svg/';
        $fileWalk = \CFile::MakeFileArray($pathSvg.'walk.svg');
        $fileBall = \CFile::MakeFileArray($pathSvg.'ball.svg');
        $fileBook = \CFile::MakeFileArray($pathSvg.'book.svg');

        $pathDetail = '/assets/images/detail/';
        $filePark = \CFile::MakeFileArray($pathDetail.'parks.jpg');
        $filePlace = \CFile::MakeFileArray($pathDetail.'slide-1.jpg');


        $arIdEl=[Migration::getElementIdByFilter(["IBLOCK_CODE"=>"areas_ru", "CODE"=>"tverskoy"]),Migration::getElementIdByFilter(["IBLOCK_CODE"=>"areas_ru", "CODE"=>"khamovniki"])];
        foreach($arIdEl as $idEl){
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$fileWalk,"DESCRIPTION"=>"5 минут до <br>Садового кольца"],'ICO_HEADER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$fileBall,"DESCRIPTION"=>"Лучшее школьное <br>образование"],'ICO_HEADER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$fileBook,"DESCRIPTION"=>"Развитая инфраструктура <br>для занятий спортом"],'ICO_HEADER');

            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>"97","DESCRIPTION"=>"тыс. численность <br>населения"],'BLOCK_NUMBER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>"950","DESCRIPTION"=>"га. территория <br>района"],'BLOCK_NUMBER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>"2530","DESCRIPTION"=>"тыс. м² общая <br>площадь района"],'BLOCK_NUMBER');

            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$filePark,"DESCRIPTION"=>"В районе находится живописный Сквер Девичьего поля с прудом и тихими зонами отдыха"],'ECOLOGY_SLIDER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$filePlace,"DESCRIPTION"=>"В районе находится живописный Сквер Девичьего поля с прудом и тихими зонами отдыха"],'SECURITY_SLIDER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$filePark,"DESCRIPTION"=>"В районе находится живописный Сквер Девичьего поля с прудом и тихими зонами отдыха"],'TRANSPORT_SLIDER');
            Migration::addPropsEl($idEl,$iBlockId,["VALUE"=>$filePark,"DESCRIPTION"=>"В районе находится живописный Сквер Девичьего поля с прудом и тихими зонами отдыха"],'PLACE_SLIDER');
        }
    }

    private function removeProp()
    {
        $iBlockId = Migration::getIBlockIdByFilter(['CODE' => 'areas_ru']);
        $iBlockIdEn = Migration::getIBlockIdByFilter(['CODE' => 'areas_en']);
        $ids=[
            Migration::getPropertyIDByCode($iBlockId,"ICO_HEADER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"ICO_HEADER"),
            Migration::getPropertyIDByCode($iBlockId,"BLOCK_NUMBER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"BLOCK_NUMBER"),
            Migration::getPropertyIDByCode($iBlockId,"SUB_TITLE"),
            Migration::getPropertyIDByCode($iBlockIdEn,"SUB_TITLE"),
            Migration::getPropertyIDByCode($iBlockId,"ECOLOGY_SLIDER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"ECOLOGY_SLIDER"),
            Migration::getPropertyIDByCode($iBlockId,"SECURITY_SLIDER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"SECURITY_SLIDER"),
            Migration::getPropertyIDByCode($iBlockId,"TRANSPORT_SLIDER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"TRANSPORT_SLIDER"),
            Migration::getPropertyIDByCode($iBlockId,"PLACE_SLIDER"),
            Migration::getPropertyIDByCode($iBlockIdEn,"PLACE_SLIDER"),
            Migration::getPropertyIDByCode($iBlockId,"FOOTER_TITLE"),
            Migration::getPropertyIDByCode($iBlockIdEn,"FOOTER_TITLE"),
            Migration::getPropertyIDByCode($iBlockId,"FOOTER_TEXT"),
            Migration::getPropertyIDByCode($iBlockIdEn,"FOOTER_TEXT"),
        ];
        foreach($ids as $id){
            Migration::deleteProperties($id);
        }

    }

    private function removeContent()
    {
        Migration::removeAllInIBlock('areas_ru');

    }
}
