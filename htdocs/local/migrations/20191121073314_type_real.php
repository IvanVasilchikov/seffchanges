<?php
use Phinx\Migration\AbstractMigration;
use Idem\Realty\Wizards\Install;
use Idem\Realty\Import\Intrum;

class TypeReal extends AbstractMigration
{

    public function up()
    {
        CModule::IncludeModule('idem.realty');

        $install = new Install();
        $arInstall = [
            'Typereal'
        ];
        foreach ($arInstall as $installName){
            $install->CreateTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->CreateHLTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table',$installName, $installName, $installName);
        }


        $intrum = new Intrum();

        $arData = $intrum::getVariants(1698);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Typereal");
    }

    public function down()
    {
        $install = new Install();
        $arInstall = [
            'Typereal'
        ];
        foreach ($arInstall as $installName){
            $install->DropTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->DropHLTable($installName);
        }

    }
}
