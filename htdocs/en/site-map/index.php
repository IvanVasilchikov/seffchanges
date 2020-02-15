<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?>
<div class="container">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.map",
		"main",
		Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"COL_NUM" => "1",
			"LEVEL" => "3",
			"SET_TITLE" => "Y",
			"SHOW_DESCRIPTION" => "N",
            "IBLOCK_CODE"=>"pointSaitMapCom",
            "TITLE"=>"Sait map"
		)
	);?>
 </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>