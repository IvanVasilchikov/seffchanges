<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION;
$APPLICATION->SetPageProperty('front_page','home');
$APPLICATION->SetTitle("Агентство элитной недвижимости Saffari Estate");
$APPLICATION->SetPageProperty("keywords", "агентство элитной недвижимости, агентство элитной недвижимости в Москве, лучшее агентство элитной недвижимости");
$APPLICATION->SetPageProperty("description", "Saffari Estate — агентство недвижимости. Обращайтесь к экспертам! Элитная недвижимость в Москве, Подмосковье, по всему миру");
?>

<?
$APPLICATION->IncludeComponent(
    "custom:main_page",
    "",
    Array(
        "QUESTION_IBLOCK_CODE" => 'debriefing_'.LANGUAGE_ID,
        "COMPANY_FEATURES_IBLOCK_CODE" => 'features_work_'.LANGUAGE_ID,
        "MAIN_SLIDER_IBLOCK_CODE" => 'main_slider_'.LANGUAGE_ID,
        "SERVICES_IBLOCK_CODE" => 'services_'.LANGUAGE_ID,
        "GUIDE_IBLOCK_CODE" => 'our_guide_'.LANGUAGE_ID,
        "AWARDS_IBLOCK_CODE" => 'awards_'.LANGUAGE_ID,
        "CLIENTS_IBLOCK_CODE" => 'clients_'.LANGUAGE_ID,
    )
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

