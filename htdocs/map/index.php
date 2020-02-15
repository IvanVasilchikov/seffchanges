<?
define('PAGE_NO_FOOTER', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('front_page','map');
$APPLICATION->SetTitle("Поиск по карте");
?>
<?
$APPLICATION->IncludeComponent(
    "custom:map.search",
    "",
    array(
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
