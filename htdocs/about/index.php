<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('front_page','about');
$APPLICATION->SetTitle("О компании");
?>

<?
$APPLICATION->IncludeComponent(
    "custom:company",
    "",
    Array(
        "COMPANY_FEATURES_IBLOCK_CODE" => 'features_work_'.LANGUAGE_ID,
        "COMPANY_INFO_IBLOCK_CODE" => 'info_'.LANGUAGE_ID,
        "SERVICES_IBLOCK_CODE" => 'services_'.LANGUAGE_ID,
        "GUIDE_IBLOCK_CODE" => 'our_guide_'.LANGUAGE_ID,
        "AWARDS_IBLOCK_CODE" => 'awards_'.LANGUAGE_ID,
        "CLIENTS_IBLOCK_CODE" => 'clients_'.LANGUAGE_ID,
    )
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
