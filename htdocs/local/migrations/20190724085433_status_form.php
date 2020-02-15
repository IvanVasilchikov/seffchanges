<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;

class StatusForm extends AbstractMigration
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
        $this->createStatusForms();
    }

    public function down()
    {
        //$this->removeStatusForms();
    }
    private function createStatusForms()
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
            Migration::setStatusForm(["FORM_ID" => Migration::getFormIdByFilter(['SID' => $name]), "C_SORT" => 100, "ACTIVE" => "Y", "TITLE" => "Опубликовано", "DESCRIPTION" => "Статус по умолчанию","DEFAULT_VALUE"=>"Y"]);
        }
    }

    private function removeStatusForms()
    {

    }
}
