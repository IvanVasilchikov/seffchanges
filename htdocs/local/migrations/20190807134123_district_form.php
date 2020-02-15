<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class DistrictForm extends AbstractMigration
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
        $this->createForms();

    }

    public function down()
    {
        $this->removeForms();

    }
    private function removeForms(){
        Migration::deleteForm( Migration::getFormIdByFilter(['SID' => 'districts']));
    }
    private function createForms()
    {
        Migration::createForm([
            "NAME" => "Заявка с района",
            "SID" => "districts",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Заявка с района", "en" => "Заявка с района"),
        ]);
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "districts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "districts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "districts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"districts_name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "districts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Район",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::setStatusForm(["FORM_ID" => Migration::getFormIdByFilter(['SID' => "districts"]), "C_SORT" => 100, "ACTIVE" => "Y", "TITLE" => "Опубликовано", "DESCRIPTION" => "Статус по умолчанию","DEFAULT_VALUE"=>"Y"]);

    }
}
