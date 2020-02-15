<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$tmp = json_decode(file_get_contents('php://input'), true);
if ($tmp) {
    $_POST = $tmp;
}
use app\Form\Base\CIdemForm;
$write=new CIdemForm;
$arResult=$write->saveData("helpBest");
echo $arResult;