<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::AddAutoloadClasses('', array(
    'app\Util\Util' => '/local/php_interface/classes/util/util.php',
    'app\Util\Convert' => '/local/php_interface/classes/util/convert.php',
    'app\Util\RuleSeoList' => '/local/php_interface/classes/util/ruleSeoList.php',
    'app\Form\Base\CIdemForm' => '/local/php_interface/classes/Form/Base/CIdemForm.php',
    'Idem\CIdemStatic' => '/bitrix/modules/idem/classes/general/idem_static.php'
));

require_once('const.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once('cnfpug.php');
require_once('functions.php');

AddEventHandler("main", "OnEpilog", function () {
    global $APPLICATION;
    if (ADMIN_SECTION !== true) {
        $hash = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/hash.txt');
        $noJs = $APPLICATION->GetPageProperty('noJs', false);
        $APPLICATION->SetAdditionalCSS("/assets/styles/chunk/common-{$hash}.css");
        $APPLICATION->SetAdditionalCSS("/assets/styles/autoload-{$hash}.css");
        if (!$noJs) {
            $APPLICATION->AddHeadScript("/assets/scripts/chunk/common-{$hash}.js");
            $APPLICATION->AddHeadScript("/assets/scripts/autoload-{$hash}.js");
        }
        $page = $APPLICATION->GetPageProperty('front_page');
        if ($page) {
            $APPLICATION->SetAdditionalCSS("/assets/styles/{$page}-{$hash}.css");
            if (!$noJs) {
                $APPLICATION->AddHeadScript("/assets/scripts/${page}-{$hash}.js");
            }
        }
    }
});
