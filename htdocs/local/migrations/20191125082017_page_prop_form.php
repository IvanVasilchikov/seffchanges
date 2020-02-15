<?php
use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;


class PagePropForm extends AbstractMigration
{

    public function up()
    {
        $this->createPropForms();
    }

    public function down()
    {

    }

    private function createPropForms()
    {
        $arANSWER[] = array(
            "MESSAGE"     => " ",
            "C_SORT"      => 100,
            "ACTIVE"      => "Y",
            "FIELD_TYPE"  => "text",
        );

        $namesForm=[
            "SIMPLE_FORM_1",
            "object_presentation",
            "presentation_plan",
            "yourPrice",
            "requestPrice",
            "compil",
            "broker",
            "helpBest",
            "districts",
            "SIMPLE_FORM_2",
            "SIMPLE_FORM_3",
            "booking",
            "write_us_contacts",
            "write_us",
            "services",
            "presentation_plan",
            "application_detail",
            "object_presentation",
            "callback",
        ];
        foreach($namesForm as $nameForm){
            Migration::createPropForm([
                "SID"=>"page",
                "FORM_ID"=>Migration::getFormIdByFilter(['SID' => $nameForm]),
                "ACTIVE"=>"Y",
                "FIELD_TYPE"=>"text",
                "TITLE"=>"Страница",
                "TITLE_TYPE"=>"text",
                "REQUIRED"=>"N",
                "arANSWER"=>$arANSWER
            ]);
        }  
    }
}
