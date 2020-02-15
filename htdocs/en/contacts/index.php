<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Contacts");
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
