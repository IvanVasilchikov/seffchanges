<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('front_page','contacts');
$APPLICATION->SetTitle("Контакты");
?>

<?
$APPLICATION->IncludeComponent(
    "custom:contacts",
    "",
    Array(
        "WORKERS_IBLOCK_CODE" => 'press_workers_'.LANGUAGE_ID,
    )
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
