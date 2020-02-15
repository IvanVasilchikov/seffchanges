<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class PriceForm extends AbstractMigration
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
        $this->createPropForms();
        $this->createStatusForms();

    }

    public function down()
    {
        $this->removeForms();

    }
    private function createForms()
    {
        ////// Ваша цена
        Migration::createForm([
            "NAME" => "Ваша цена",
            "SID" => "yourPrice",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Ваша цена", "en" => "Your price"),
        ]);
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "yourPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "yourPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"offer",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "yourPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Предложение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "yourPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        ////// Цена по запросу
        Migration::createForm([
            "NAME" => "Цена по запросу",
            "SID" => "requestPrice",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Цена по запросу", "en" => "Request price"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "requestPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "requestPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "requestPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "requestPrice"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        ////// Запрос на подборку
        Migration::createForm([
            "NAME" => "Запрос на подборку",
            "SID" => "compil",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Запрос на подборку", "en" => "Запрос на подборку"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "compil"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "compil"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "compil"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        ////// Запрос брокеру
        Migration::createForm([
            "NAME" => "Запрос брокеру",
            "SID" => "broker",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Запрос брокеру", "en" => "Запрос брокеру"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "broker"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "broker"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "broker"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "broker"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"typeEstate",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "broker"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Тип",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        ////// Подбор предложений
        Migration::createForm([
            "NAME" => "Подбор предложений",
            "SID" => "helpBest",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Подбор предложений", "en" => "Подбор предложений"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "helpBest"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "helpBest"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "helpBest"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"page",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "helpBest"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Страница",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
    }
    private function createPropForms(){
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us_contacts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"manager",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us_contacts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Менеджер",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us_contacts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us_contacts"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "SIMPLE_FORM_1"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);

    }
    private function createStatusForms()
    {
        $namesForm=[
            "compil",
            "requestPrice",
            "yourPrice",
            "helpBest",
            "broker"
        ];
        foreach ($namesForm as $name){
            Migration::setStatusForm(["FORM_ID" => Migration::getFormIdByFilter(['SID' => $name]), "C_SORT" => 100, "ACTIVE" => "Y", "TITLE" => "Опубликовано", "DESCRIPTION" => "Статус по умолчанию","DEFAULT_VALUE"=>"Y"]);
        }
    }
    private function removeForms()
    {
        $namesForm=[
            "compil",
            "requestPrice",
            "yourPrice",
            "helpBest",
            "broker"
        ];
        foreach ($namesForm as $name){
            Migration::deleteForm( Migration::getFormIdByFilter(['SID' => $name]));
        }

    }
}
