<?php

use Phinx\Migration\AbstractMigration;

class DropHigwayDuplicates extends AbstractMigration
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
    
        $resVal = Idem\Realty\Core\Highway\HighwayTable::getList([
            'select' => ["*"]
        ])->fetchAll();
        $arResult = [];
        foreach ($resVal as $arItem){
            if(!isset($arResult[trim($arItem['CODE'])]))
                $arResult[trim($arItem['CODE'])] = $arItem['ID'];
            else
                Idem\Realty\Core\Highway\HighwayTable::delete($arItem['ID']);
        }
        $resVal2 = Idem\Realty\Core\Highway\HighwayTable::getList([
            'select' => ["*"]
        ])->fetchAll();
        
        foreach ($resVal2 as $arSecondCheckItem){
            if(isset($arResult[trim($arSecondCheckItem['CODE']."-shosse")]))
               Idem\Realty\Core\Highway\HighwayTable::delete($arSecondCheckItem['ID']);
        }
    
    
        $resMetroVal = Idem\Realty\Core\Metro\MetroTable::getList([
            'select' => ["*"]
        ])->fetchAll();
        $arResult = [];
        foreach ($resMetroVal as $arItem){
            if(!isset($arResult[trim($arItem['CODE'])]))
                $arResult[trim($arItem['CODE'])] = $arItem['ID'];
            else
                Idem\Realty\Core\Metro\MetroTable::delete($arItem['ID']);
        }
        
        $resLocVal = Idem\Realty\Core\Locality\LocalityTable::getList([
            'select' => ["*"]
        ])->fetchAll();
        $arResult = [];
        foreach ($resLocVal as $arItem){
            if(!isset($arResult[trim($arItem['CODE'])]))
                $arResult[trim($arItem['CODE'])] = $arItem['ID'];
            else
                Idem\Realty\Core\Locality\LocalityTable::delete($arItem['ID']);
        }
    }
    
    public function down()
    {
        CModule::IncludeModule('idem.realty');
        $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
        require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/import/intrum.php");
    
        $intrum = new Idem\Realty\Import\Intrum();
    
        $arData = $intrum::getVariants(822);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Highway");
        
        
        $arData = $intrum::getVariants(485);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Metro");
        
        $arData = $intrum::getVariants(630);
        if(!empty($arData))
            $intrum->dataCollect($arData, "Locality");
    }
}
