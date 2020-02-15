<?php
if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php";
use Idem\Realty\Utilities\Migration;
use Phinx\Migration\AbstractMigration;

class FieldsMainSlider extends AbstractMigration
{
    public function up()
    {
        $this->createFilds();

    }

    public function down()
    {

    }
    private function createFilds()
    {
        Migration::createProperties([
            "NAME" => "Ссылка",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "LINK",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'main_slider_ru']),
        ]);
        Migration::createProperties([
            "NAME" => "Ссылка",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "LINK",
            "MULTIPLE" => "N",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'main_slider_en']),
        ]);
    }
}
