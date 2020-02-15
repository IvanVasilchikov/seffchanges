<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use Idem\Realty\Admin\Admin;

global $APPLICATION, $adminPage, $adminMenu, $USER, $adminChain, $SiteExpireDate, $FIELDS;
$module_right = $APPLICATION->GetGroupRight('main');
if ($module_right == "D")
    $APPLICATION->AuthForm('Нет доступа');


$entity_name = $_REQUEST['entity'];
$module_name = 'idem.realty';

switch ($_REQUEST['sect']) {
    case 'list':
        Admin::buildAdminListPage($module_name, $entity_name);
        break;
    case 'edit':
        Admin::buildAdminEditPage($module_name, $entity_name);
        break;
}
?>