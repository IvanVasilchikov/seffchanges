<?
define('PAGE_NO_FOOTER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('front_page','privacy');
$APPLICATION->SetTitle("Политика конфиденциальности");
?>
<?
$APPLICATION->IncludeComponent(
    "custom:privacy",
    "",
    array(),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>