
<?php

if(isset($_REQUEST['saved']) && $_REQUEST['saved'] == 'Y'){
    foreach ($_REQUEST['langs'] as $key => $fields){
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/static_content/lang_'.$key.'.json',json_encode($fields));
    }
}
$files = new \FilesystemIterator($_SERVER['DOCUMENT_ROOT'].'/upload/static_content');
$res = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/upload/static_content/content.json'),true);
$aTabs = [];
/**
 * @var $file SplFileInfo
 */
foreach ($files as $file){
    $name = $file->getFilename();
    if(preg_match('#lang_(.{2})#',$name,$matches)){
        $aTabs[] = [
            "DIV" => "lang_".$matches[1],
            "TAB" => 'Языковой файл '.$matches[1],
            "ICON"=>"main_user_edit",
            "TITLE"=>'Языковой файл '.$matches[1],
            "FILE" => $file->getPath().'/'.$name,
            "LANG" => $matches[1]
        ];
    }
}
?>
<form action="" method="post">
<?
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();

foreach ($aTabs as $tab){
    $tabControl->BeginNextTab();
    showLangTab($tab['FILE'],$res,$tab['LANG']);
    $tabControl->EndTab();
}

$tabControl->Buttons();

?>
    <input type="hidden" name="saved" value="Y">
<input type="submit" value="Сохранить">
<?

$tabControl->End();

?>
</form>
<?

function showLangTab($file,$fields,$lang)
{
    $data = json_decode(file_get_contents($file),true);
    $fields = getFields($fields);
    $res = array_merge($fields,$data);

    foreach ($res as $key=>$value){
        ?>
            <tr>
                <td><?=$key?></td>
                <td><input type="text" name="langs[<?=$lang?>][<?=$key?>]" value="<?=$value?>"></td>
            </tr>
        <?
    }
}

function getFields($arr){
    $data = [];
    foreach ($arr as $key => $value){
        if(is_array($value)){
            if(!is_int($key)) $data[$key] = null;
            $data = array_merge($data,getFields($value));
        }else{
            $data[$key] = null;
        }
    }
    return $data;
}