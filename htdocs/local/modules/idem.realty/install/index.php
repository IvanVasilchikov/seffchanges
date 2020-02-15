<?php
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/wizards/install.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/hload/entity.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/hload/fields.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/hload/lang.php");


require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/objects/objectstable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/country/countrytable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/city/citytable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/valute/valutetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/flattype/flattypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/departament/departamenttable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/builtstatus/builtstatustable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/finishtype/finishtypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/dealtype/dealtypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/objecttype/objecttypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/wallmaterial/wallmaterialtable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/realtyclass/realtyclasstable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/transportring/transportringtable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/district/districttable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/locality/localitytable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/metro/metrotable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/highway/highwaytable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/tags/tagstable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/infrastructure/infrastructuretable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/bathroom/bathroomtable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/builttype/builttypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/useroom/useroomtable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/commerctype/commerctypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/countrytype/countrytypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/parkingtype/parkingtypetable.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/core/foreigntype/foreigntypetable.php");
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Idem\Realty\Wizards\Install;

IncludeModuleLangFile(__FILE__);

class idem_realty extends CModule
{
    var $MODULE_ID = 'idem.realty';

    function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = "Модуль недвижимости idem";
        $this->MODULE_DESCRIPTION = "Модуль для работы сайта Imperium";
    }

    public function DoInstall()
    {
        $install = new Install();
        $arInstall = [
            'Objects',
            'Country',
            'Departament',
            'City',
            'Valute',
            'Flattype',
            'Finishtype',
            'Dealtype',
            'Objecttype',
            'Wallmaterial',
            'Realtyclass',
            'Transportring',
            'District',
            'Locality',
            'Metro',
            'Highway',
            'Tags',
            'Infrastructure',
            'Builtstatus',
            'Bathroom',
            'Useroom',
            'Commerctype',
            'Countrytype',
            'Foreigntype',
            'Parkingtype',
            'Builttype'
        ];
        foreach ($arInstall as $installName){
            $install->CreateTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->CreateHLTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table',$installName, $installName, $installName);
        }
        
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        Loader::includeModule($this->MODULE_ID);
        $install = new Install();
        $arInstall = [
            'Objects',
            'Country',
            'Departament',
            'City',
            'Valute',
            'Flattype',
            'Finishtype',
            'Dealtype',
            'Objecttype',
            'Wallmaterial',
            'Realtyclass',
            'Transportring',
            'District',
            'Locality',
            'Metro',
            'Highway',
            'Tags',
            'Infrastructure',
            'Builtstatus',
            'Bathroom',
            'Useroom',
            'Commerctype',
            'Foreigntype',
            'Countrytype',
            'Parkingtype',
            'Builttype'
        ];
        foreach ($arInstall as $installName){
            $install->DropTable('Idem\Realty\Core\\'.$installName.'\\'.$installName.'Table');
            $install->DropHLTable($installName);
        }
        
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
