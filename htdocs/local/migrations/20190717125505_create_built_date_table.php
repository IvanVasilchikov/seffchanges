<?php


use Phinx\Migration\AbstractMigration;
use Idem\Realty\Wizards\Install;
use Idem\Realty\Import\Intrum;

class CreateBuiltDateTable extends AbstractMigration
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
            'Zhkclass',
            'Finishyear',
        ];
        foreach ($arInstall as $installName){
            $install->CreateTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->CreateHLTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table',$installName, $installName, $installName);
        }


        $intrum = new Intrum();

        $arData = $intrum::getVariants(1623);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Zhkclass");
        $arData = $intrum::getVariants(1626);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Finishyear");
    }

    public function down()
    {
        $install = new Install();
        $arInstall = [
            'Zhkclass',
            'Finishyear',
        ];
        foreach ($arInstall as $installName){
            $install->DropTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->DropHLTable($installName);
        }

    }
}
