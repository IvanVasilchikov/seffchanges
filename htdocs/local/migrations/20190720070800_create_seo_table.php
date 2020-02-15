<?php


use Phinx\Migration\AbstractMigration;
use Idem\Realty\Wizards\Install;
use Idem\Realty\Import\Intrum;

class CreateSeoTable extends AbstractMigration
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
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        CModule::IncludeModule('idem.realty');
        
        $install = new Install();
        $arInstall = [
            'Seo'
        ];
        foreach ($arInstall as $installName){
            $install->CreateTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
        }
    }
    
    public function down()
    {
        $install = new Install();
        $arInstall = [
            'Seo',
        ];
        foreach ($arInstall as $installName){
            $install->DropTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
        }
        
    }
}
