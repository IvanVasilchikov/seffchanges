<?

Class idem extends CModule
{
    public $MODULE_ID = "idem";
    public $MODULE_NAME;
    public $MODULE_VERSION_DATE;

    function idem(){

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = $arModuleVersion['NAME'];
    }

    function DoInstall()
    {
        global $APPLICATION;
        RegisterModule($this->MODULE_ID);

        CopyDirFiles(dirname(dirname(__FILE__))."/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css", true, true);
        if(!is_file($_SERVER["DOCUMENT_ROOT"]."/upload/static_content/content.json")){
            CopyDirFiles(dirname(dirname(__FILE__))."/install/example", $_SERVER["DOCUMENT_ROOT"]."/upload/static_content", true, true);
        }
        $path = dirname(dirname(__FILE__));
        $str = <<<STR
<?php
    require("$path/admin/idem_content.php");
?>
STR;


        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/idem_content.php',$str);

        $APPLICATION->IncludeAdminFile('Установка модуля "Статический контент"', dirname(dirname(__FILE__))."/install/step.php");

    }

    function DoUninstall()
    {
        global $APPLICATION;
        UnRegisterModule($this->MODULE_ID);
        DeleteDirFiles(dirname(dirname(__FILE__))."/idem/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/css");
        DeleteDirFiles(dirname(dirname(__FILE__))."/install/example", $_SERVER["DOCUMENT_ROOT"]."/upload/static_content", true, true);
        unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/idem_content.php');
        $APPLICATION->IncludeAdminFile('Удаление модуля "Статический контент"', dirname(dirname(__FILE__))."/install/unstep.php");
    }
}

?>