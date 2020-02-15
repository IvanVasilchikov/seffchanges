<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
die();
CModule::IncludeModule('iblock');
$arParams = array("replace_space"=>"_","replace_other"=>"_","change_case"=>"U");
$IBLOCK_ID = 16;
$namesArr = array();
$descriptionArr = array();

$namesArr[] = 'Газпром';
$namesArr[] = 'Тинькофф';
$namesArr[] = 'Роснефть';
$namesArr[] = 'Leroy merlin';
$namesArr[] = 'ВТБ';
$namesArr[] = 'Газпром';
//$namesArr[] = 'Тинькофф';
//$namesArr[] = 'Роснефть';
//$namesArr[] = 'Leroy merlin';
//$namesArr[] = 'ВТБ';


$descriptionArr[] = 'Вы найдёте объекты по аренде и продаже недвижимости в Москве. Все квартиры, дома и другие объекты проверены';
$descriptionArr[] = 'Для упрощения поиска, у нас реализована система рекомендаций похожих объявлений';
$descriptionArr[] = 'Вы найдёте объекты по аренде и продаже недвижимости в Москве. Все квартиры, дома и другие объекты проверены';
$descriptionArr[] = 'Для упрощения поиска, у нас реализована система рекомендаций похожих объявлений';
$descriptionArr[] = 'Вы найдёте объекты по аренде и продаже недвижимости в Москве. Все квартиры, дома и другие объекты проверены';
$descriptionArr[] = 'Для упрощения поиска, у нас реализована система рекомендаций похожих объявлений';
$descriptionArr[] = 'Вы найдёте объекты по аренде и продаже недвижимости в Москве. Все квартиры, дома и другие объекты проверены';
$descriptionArr[] = 'Для упрощения поиска, у нас реализована система рекомендаций похожих объявлений';

$arSections = [
    'Собственнику',
    'Покупателю',
    'Арендатору',
    'Девелоперу',
];


$doc = [
	'/assets/images/clients/clients_4.png',
	'/assets/images/clients/clients_3.png',
	'/assets/images/clients/clients_2.png',
	'/assets/images/clients/clients_1.png',
	'/assets/images/clients/clients_0.png',
	'/assets/images/clients/clients_4.png',
	'/assets/images/clients/clients_3.png',
	'/assets/images/clients/clients_2.png',
	'/assets/images/clients/clients_1.png',
	'/assets/images/clients/clients_0.png',
];

$code = array();
?>
    <form action="" method="post">
        <input type="submit" name='add_razd' value="Добавить элементы">
    </form>
<?


//создает элементы-------------------------------------------------
if (isset($_POST['add_razd'])){
    $bs = new CIBlockSection;
    $el = new CIBlockElement;
   // $sectionID = $_REQUEST['sectionID'];
   // foreach($arSections as $sectionName) {
        
//        $arFields = Array(
//            "ACTIVE" => 'Y',
//            "IBLOCK_ID" => $IBLOCK_ID,
//            "NAME" => $sectionName,
//            //"PICTURE" => $_FILES["PICTURE"],
//        );
    
//        $sectionID = $bs->Add($arFields);
        
        foreach ($namesArr as $key => $name) {
            $code[$key] = Cutil::translit($name, "ru", $arParams);
            $PROP = array();
            $PROP['SUBTITLE'] = "Получите персональную подборку лучших предложений";
            $PROP['ANSWERS'] = ['Жилую в городе','Загородную','Коммерческую','Зарубежную'];
           
            $arFields = Array(
                "ACTIVE" => "Y",
               // "IBLOCK_SECTION_ID" => $sectionID,
                "IBLOCK_ID" => $IBLOCK_ID,
               // "PREVIEW_PICTURE" => CFile::MakeFileArray($doc[$key]),
                //"PREVIEW_TEXT" => $descriptionArr[$key],
                "NAME" => "Какую недвижимость вы ищите ".($key+1)."?",
                //"NAME" => $name,
                "PROPERTY_VALUES" => $PROP,
               // "CODE" => $code[$key] . $key,
                "CODE" => ($key+1),
                "SORT" => ($key+1),
            );
            if ($ID = $el->Add($arFields)) {
                $res = ($ID > 0);
                echo 'add' . $ID . '<br>';
            } else {
                echo $bs->LAST_ERROR;
            }
        
        
        }
   // }
    
}