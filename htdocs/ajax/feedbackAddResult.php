<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = array();
$arResult['success'] = false;
$fileID = 0;
if(isset($_FILES['image']) && !empty($_FILES['image'])){
    $fileID = CFile::SaveFile($_FILES['image'],'load_files');
    if($fileID)
        $arFile = CFile::MakeFileArray($fileID);
}
if (CModule::IncludeModule('form')) {
    $arValues = array ();
    foreach($_REQUEST['new_result'] as $key => $val){
        $arValues[$key] = $val;
    }
    if($fileID && !empty($arFile)){
        $arValues[$_REQUEST['file_name']] = $arFile;
    }
    if ($result_id = CFormResult::Add($_REQUEST['WEB_FORM_ID'], $arValues, 'N')) {
        CFormResult::Mail($result_id);
    }
    else
    {
        global $strError;
        $arResult['error'] = $strError;
    }
}
else{
    $arResult['error'] = 'form module error';
}

if (empty($arResult['error']))
{
    $arResult['success'] = true;
    $arResult['status'] = 'success';
}

echo json_encode($arResult);
die();