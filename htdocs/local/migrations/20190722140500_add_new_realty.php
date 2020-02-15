<?php

use Phinx\Migration\AbstractMigration;

class AddNewRealty extends AbstractMigration
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
        CModule::IncludeModule('idem.realty');
        $code = \Cutil::translit("Новостройка", "ru",["replace_space"=>"-","replace_other"=>"-"]);
        Idem\Realty\Core\Objecttype\ObjecttypeTable::add(['NAME'=>'Новостройка','CODE'=>$code]);
    }
    
    public function down()
    {
        CModule::IncludeModule('idem.realty');
        $code = \Cutil::translit("Новостройка", "ru",["replace_space"=>"-","replace_other"=>"-"]);
        $newID= Idem\Realty\Core\Objecttype\ObjecttypeTable::getList([
            'select' => ["*"],
            'filter' => ["CODE"=>$code]
        ])->fetch();
        Idem\Realty\Core\Objecttype\ObjecttypeTable::delete($newID['ID']);
    }
}
