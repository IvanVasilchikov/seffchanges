<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<?

use app\Util\Util;
use Bitrix\Main\Loader;
use Idem\Realty\Realty\Data;

Loader::includeModule("idem.realty");
Loader::includeModule("iblock");

$arRes=[];
$arFilter = array('IBLOCK_CODE' => 'sortMenuRu', 'ACTIVE'=>"Y");
$rsSect = CIBlockSection::GetList(array(),$arFilter);
while ($arSect = $rsSect->GetNext())
{   
    $arFilter = Array('IBLOCK_CODE' => 'sortMenuRu',"SECTION_ID"=>$arSect['ID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,["NAME", "SORT"]);
    while($ar_fields = $res->GetNext())
    {
        $arRes[$arSect['CODE']][]=$ar_fields;        
    }
}

$lang = new app\Util\Util();
$langs = $lang->getLangs();
$nextLang = "EN";
$nextLangUrl = "/en/";
if (count($langs) > 1) {
    foreach ($langs as $lang) {
        if ($lang['ACTIVE']) {
            if ($lang['LANGUAGE_ID'] == 'en') {
                $nextLang = "RU";
                $nextLangUrl = "/";
            }
        }
    }
} else {
    $nextLang = false;
}

$data = new Data();
$arTypes = [];
$arObjectTypes = [
    LIVE_REALTY_URL => LIVE_DEPARTAMENT,
    COMMERC_REALTY_URL => COMMERC_DEPARTAMENT,
    COUNTRY_REALTY_URL => COUNTRY_DEPARTAMENT,
    FOREIGN_REALTY_URL => FOREIGN_DEPARTAMENT,
];

$res = \Idem\CIdemStatic::getInstance();
foreach ($arObjectTypes as $url => $departament) {
    $types = Data::getGroupByField($departament, 'object_type', false);
    $types = Util::sorterFields(["poselok" => 100], $types);
    $tags = Data::getGroupByField($departament, 'tags', []);
    $tagsValue = array_map(function ($item) {
        return $item['value'];
    }, $tags);
    $arDepartamentTypes = [];
    foreach ($types as $type) {
        if ($type['text'] == "Поселок") {
            $text = "Посёлки";
        } else {
            $text = mb_ucfirst($type['text']);
        }
        $arDepartamentTypes[] = [
            "text" => $text,
            "url" => Data::createUrl([], [
                'object_type' => $type['value'],
                'department_id' => $departament,
            ]),
        ];
    }

    foreach ($tags as $tag) {
        if ($tag['value'] == NOVOSTROIKA_CODE) {
            $arDepartamentTypes[] = [
                "text" => mb_ucfirst($tag['text']),
                "url" => Data::createUrl([], [
                    'tags' => [$tag['value']],
                    'department_id' => $departament,
                ]),
            ];
        }
    }
    $arEx['/'.$url.'/'][] = [
        "type" => "all",
        "text" => $res->get('site_' . LANGUAGE_ID . '.all_objects'),
        "url" => Data::createUrl([], [
            'department_id' => $departament,
        ]),
    ];
    if (in_array(EXCLUSIVE, $tagsValue)) {
        $arEx['/'.$url.'/'][] = [
            "type" => "exclusive",
            "text" => $res->get('site_' . LANGUAGE_ID . '.exclusive_title'),
            "url" => Data::createUrl([], [
                'tags' => [EXCLUSIVE],
                'department_id' => $departament,
            ]),
        ];
    }        
    $arTypes[$url] = $arDepartamentTypes;
}

foreach($arTypes as $k => $arType){  
    $arPount=[];
    foreach($arType as $arPoint){
        $arPoint["sort"]=1000;
        foreach($arRes[$k] as $el){
            if($arPoint["text"]==$el["NAME"]){
                $arPoint["sort"]=intval($el["SORT"]);
            }
        }
        $arPount[]=$arPoint;
    }
    usort($arPount, function($a,$b){
        return ($a['sort']-$b['sort']);
    });
    $arTypes[$k]=$arPount;
}
global $APPLICATION;
$menu = [];
$arMainMenu = [];
if (count($arResult) > 4) {
    $arMoreMenu = [
        "text" => "Еще",
        "url" => "",
        "more" => [
            "small" => true,
            "links" => [],
        ],
    ];
}

foreach ($arResult as $itemIndex => $arItem) { 
    if ($itemIndex > 3) {
        $arMoreMenu['more']['links'][] = [
            'text' => $arItem['TEXT'],
            'url' => $arItem["LINK"],
        ];        
    } elseif (count($arTypes[$arItem['PARAMS']['type']]) == 0) {
        $arMainMenu[] = [
            'text' => $arItem['TEXT'],
            'url' => $arItem["LINK"],
        ];
    } else {        
        if($arItem["LINK"]=='/'.COMMERC_REALTY_URL.'/'){
            $links =[$arTypes[$arItem['PARAMS']['type']]];       
            $small = true;
        }else{
            $links = array_chunk($arTypes[$arItem['PARAMS']['type']], 3);        
            array_unshift($links, $arEx[$arItem["LINK"]]);
            $small = false;
        }  
        $arMainMenu[] = [
            'text' => $arItem['TEXT'],
            'url' => $arItem["LINK"],
            'more' => ["small" => $small, 'links' => $links],
        ];        
    }
}
$arMoreMenu['more']['links'] = [$arMoreMenu['more']['links']];
$arMainMenu[] = $arMoreMenu;
$arResult = [];
$arResult['headerInfo'] = [
    'list' => $arMainMenu,
    'favorites' => 0,
    'phone' => [
        "href" => "tel:" . str_replace(['(', ')', ' ', '-'], '', $res->get('contacts_' . LANGUAGE_ID . '.phone_text')),
        "text" => $res->get('contacts_' . LANGUAGE_ID . '.phone_text'),
        "replace" => true,
    ],
];
if ($nextLang) {
    $arResult['headerInfo']['language'] = [
        "text" => $nextLang,
        "url" => $nextLangUrl,
    ];
}