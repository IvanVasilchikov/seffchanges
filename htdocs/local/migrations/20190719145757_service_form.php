<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class ServiceForm extends AbstractMigration
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
        $this->addContent();

    }

    public function down()
    {
        $this->removeContent();
        $this->removeForms();

    }
    private function createForms()
    {
        Migration::createForm([
            "NAME" => "Забронировать",
            "SID" => "booking",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Забронировать", "en" => "Booking"),
         ]);
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "booking"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "booking"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"timeFrom",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "booking"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Время от",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"timeTo",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "booking"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Время до",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"object",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "booking"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Объект",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Заявка с объекта",
            "SID" => "application_detail",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Заявка с объекта", "en" => "Application from the object"),
         ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "application_detail"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "application_detail"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "application_detail"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"object",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "application_detail"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Объект",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Презентация объекта",
            "SID" => "object_presentation",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Презентация объекта", "en" => "Object presentation"),
         ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "object_presentation"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "object_presentation"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "object_presentation"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"object",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "object_presentation"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Объект",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Презентация планировок",
            "SID" => "presentation_plan",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Презентация планировок", "en" => "Presentation plan"),
         ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "presentation_plan"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "presentation_plan"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "presentation_plan"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"object",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "presentation_plan"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Объект",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Услуги",
            "SID" => "services",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Услуги", "en" => "Services"),
         ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "services"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "services"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "services"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "services"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Обратный звонок",
            "SID" => "callback",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Обратный звонок", "en" => "Callback"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "callback"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "callback"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"phone",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "callback"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Телефон",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Напишите нам",
            "SID" => "write_us",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Напишите нам", "en" => "Write to us"),
         ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createForm([
            "NAME" => "Напишите нам(контакты)",
            "SID" => "write_us_contacts",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Напишите нам(контакты)", "en" => "Write to us(contacts)"),
         ]);
        Migration::createForm([
            "NAME" => "Напишите нам",
            "SID" => "write_us",
            "arSITE" => ["s1","s2"],
            "arMENU" => array("ru" => "Напишите нам", "en" => "Write to us"),
        ]);
        Migration::createPropForm([
            "SID"=>"name",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Имя",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"email",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"email",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);
        Migration::createPropForm([
            "SID"=>"message",
            "FORM_ID"=>Migration::getFormIdByFilter(['SID' => "write_us"]),
            "ACTIVE"=>"Y",
            "FIELD_TYPE"=>"text",
            "TITLE"=>"Сообщение",
            "TITLE_TYPE"=>"text",
            "REQUIRED"=>"N",
            "arANSWER"=>$arANSWER
        ]);

    }
    private function addContent()
    {
        Migration::createProperties([
            "NAME" => "Файл иконки для попапа",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'services_ru'])
        ]);
        Migration::createProperties([
            "NAME" => "Файл иконки для попапа",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => Migration::getIBlockIdByFilter(['CODE' => 'services_en'])
        ]);
    }
    private function removeContent()
    {
        Migration::deleteProperties(Migration::getPropertyIDByCode(Migration::getIBlockIdByFilter(['CODE' => 'services_en']),"ID"));
        Migration::deleteProperties(Migration::getPropertyIDByCode(Migration::getIBlockIdByFilter(['CODE' => 'services_ru']),"ID"));
        Migration::deleteProperties(Migration::getPropertyIDByCode(Migration::getIBlockIdByFilter(['CODE' => 'services_en']),"ICON"));
        Migration::deleteProperties(Migration::getPropertyIDByCode(Migration::getIBlockIdByFilter(['CODE' => 'services_ru']),"ICON"));
    }
    private function removeForms()
    {
        $namesForm=[
            "booking",
            "write_us_contacts",
            "write_us",
            "services",
            "presentation_plan",
            "application_detail",
            "object_presentation",
            "callback",
        ];
        foreach ($namesForm as $name){
            Migration::deleteForm( Migration::getFormIdByFilter(['SID' => $name]));
        }
    }
}
