<?
use Idem\Realty\Core\Objects\Objects;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::includeModule("idem.realty");
if($_REQUEST['parent_id']!=0){
    $_REQUEST['size']=6;
}
if(isset($_REQUEST['cnt']) && $_REQUEST['cnt']) {
    $objects = new Objects();
    $res = $objects->getObjectsCnt();
}else {
    if((!$_REQUEST['parent_id'] || $_REQUEST['parent_id']==0)&&(!$_REQUEST['locality'] || is_array($_REQUEST["locality"]))){
        $res = Objects::getFilterObjects(false,true);
    }else{
        $res = Objects::getFilterObjects();
    }    
}
header('Content-Type: application/json');
echo json_encode($res);
die();
?>
