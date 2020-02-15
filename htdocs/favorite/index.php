<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty('front_page','favorite');
$APPLICATION->SetTitle("Избранное");
$filter = [];
if ($_REQUEST['ids']) {
    $filter = [
        "ids" => [
            "values" => $_REQUEST['ids']
        ]
    ];
}
?>
<?
$APPLICATION->IncludeComponent(
    "custom:catalog",
    "favorite",
    array(
        "FILTER" => $filter,
        "SET_TITLE" => false,
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
