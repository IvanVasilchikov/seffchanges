<?

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/prolog.php");

CModule::IncludeModule('idem');

use Idem\CIdemFileInfo,Idem\CIdemForm,Idem\CIdemStatic;

function clear_array(&$data){
    if(is_array($data)){
        foreach ($data as $key => &$value){
            if(isset($value['default'])){
                $def = explode(',',$value['default']);
                unset($value['default']);
                if(count($value) == 0){
                    foreach ($def as $f){
                        $value[$f] = null;
                    }
                }
            }
            clear_array($value);
        }
    }
}

function merge(array $ArrDast, array $ArrSource) {
    foreach($ArrSource as $idx => $value) {
        if(isset($ArrDast[$idx]) and is_array($ArrDast[$idx])) {
            $ArrDast[$idx] = merge($ArrDast[$idx], $value);
        } else {
            if($value) $ArrDast[$idx] = $value;
        }
    }
    return $ArrDast;
}

$res = \Idem\CIdemStatic::getInstance(false,LANGUAGE_ID);

require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_admin_after.php");

if (isset($_POST['action']) && $_POST['action'] == 'get_fields') {

    global $APPLICATION;
    $APPLICATION->RestartBuffer();

    $data = $_POST['fields'];
    $name = str_replace('[default]', '', $_POST['name']);
    $name = $name . '[' . $_POST['last_index'] . ']';
    $r = explode(',', $data);
    $arr = [];
    foreach ($r as $field) {
        $arr[$field] = '';
    }
    CIdemForm::loadLang($res->data['lang']);
    $html = CIdemForm::getReadData($arr, $name);

    die($html);
} elseif (isset($_POST['save']) && $_POST['save'] == 'save') {

    global $APPLICATION;
    $APPLICATION->RestartBuffer();

    $files = CIdemFileInfo::convert($_FILES);
    $data = $_POST;
    unset($data['save']);
    $res = merge($data,$files);
    clear_array($res);
    $data = json_encode($res,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/static_content/content.json',$data);
    LocalRedirect($_SERVER['HTTP_REFERER']);
    die();


} else {

    ?>
    <link rel="stylesheet" href="/bitrix/css/idem/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bitrix/css/idem/style.css">
    <script src="/bitrix/css/idem/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="/bitrix/css/idem/vendor/jquery/jq.nestable.js"></script>
    <script src="/bitrix/css/idem/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bitrix/css/idem/vendor/tinymce/tinymce.min.js"></script>
    <script src="/bitrix/css/idem/script.js"></script>
    <script>
        var token = '<?=bitrix_sessid_get()?>';
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="content-form" action="" method="post" enctype="multipart/form-data">
                    <?= CIdemForm::build($res->data) ?>
                    <div class="form-group">
                        <input type="hidden" name="save" value="save">
                        <button class="btn btn-primary" type="submit">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="add-block-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Добавление блока</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary add-block" data-dismiss="modal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-edit-object-item">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Редактирование элемента</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-edit-modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

<? } ?>
