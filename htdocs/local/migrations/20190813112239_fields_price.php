<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class FieldsPrice extends AbstractMigration
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
        $this->createFildsForms();

    }

    public function down()
    {

    }
    private function createFildsForms()
    {
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );
        ////// Ваша цена
        Migration::createPropForm([
            "SID" => "object",
            "FORM_ID" => Migration::getFormIdByFilter(['SID' => "yourPrice"]),
            "ACTIVE" => "Y",
            "FIELD_TYPE" => "text",
            "TITLE" => "Объект",
            "TITLE_TYPE" => "text",
            "REQUIRED" => "N",
            "arANSWER" => $arANSWER
        ]);
        ////// Запрос цены
        Migration::createPropForm([
            "SID" => "object",
            "FORM_ID" => Migration::getFormIdByFilter(['SID' => "requestPrice"]),
            "ACTIVE" => "Y",
            "FIELD_TYPE" => "text",
            "TITLE" => "Объект",
            "TITLE_TYPE" => "text",
            "REQUIRED" => "N",
            "arANSWER" => $arANSWER
        ]);
        ////// написать нам
        Migration::createPropForm([
            "SID" => "object",
            "FORM_ID" => Migration::getFormIdByFilter(['SID' => "(write_us"]),
            "ACTIVE" => "Y",
            "FIELD_TYPE" => "text",
            "TITLE" => "Объект",
            "TITLE_TYPE" => "text",
            "REQUIRED" => "N",
            "arANSWER" => $arANSWER
        ]);
    }
}
