<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $APPLICATION;
$menu = [];
$util = new app\Util\Util();
$arCompany = $util->getCompanyData();
$arMainMenu = [];
foreach($arResult as $itemIndex => $arItem)
{
    $arMainMenu[] = [
        'text' => $arItem['TEXT'],
        'url' => $arItem["LINK"],
    ];
}
$res = \Idem\CIdemStatic::getInstance();
$arTempSocial = $res->get('contacts_'.LANGUAGE_ID.'.social');
$arSocials = [];
$index = 'fb';
foreach ($arTempSocial as $arItem){
    switch ($arItem['name']){
        case 'facebook':
           $index = 'fb';
        break;
        case 'twitter':
           $index = 'tw';
        break;
        case 'instagram':
           $index = 'insta';
        break;
    }
    $arSocials[$index] = $arItem['url'];
}
$arResult = [];
$arResult['footerInfo'] = [
    'list' => $arMainMenu,
    'contacts' => [
        'phone' => [
            "url" => 'tel:'.str_replace(['(',')',' ','-'], '', $res->get('contacts_'.LANGUAGE_ID.'.phone_text')),
            "text" => $res->get('contacts_'.LANGUAGE_ID.'.phone_text'),
        ],
        'email' => [
            "url" => "mailto:".$res->get('contacts_'.LANGUAGE_ID.'.email_text'),
            "text" => $res->get('contacts_'.LANGUAGE_ID.'.email_text'),
        ],
        'address' => $res->get('contacts_'.LANGUAGE_ID.'.address_text'),
        'write' => true,
    ],
    "copyWrap" => [
        "copy" => '© '.date('Y').' '.$res->get('site_'.LANGUAGE_ID.'.name').'. <a href="'.$arCompany['privacy_policy_link'].'" target="_blank">'.$arCompany['privacy_policy_text'].'</a>',
        "socials" => $arSocials
    ],
    "map" => [
        "icon"=> "/svg/logo_saffari_2.svg",
        "image"=> "/assets/images/gmaps.jpg"
    ]

];
if(!empty($arMoreMenu)){
    $arResult['headerInfo']['moreList'] = [
        'btnText' => 'Ещё',
        'items' => $arMoreMenu,
    ];
}
