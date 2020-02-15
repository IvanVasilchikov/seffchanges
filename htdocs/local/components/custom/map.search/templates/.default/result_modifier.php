<?
$arResult['mapSearch'] = json_decode('{
  "filter": {
    "action": "/api/objects.php",
    "tabs": []
  },
  "map": {
    "center": "55.75370903771494, 37.61981338262558",
    "zoom": 12,
    "markers": []
  }
}
', true);
$arResult['mapSearch']['breadcrumbs']=
		[
			[
				"href"=> "/",
				"title"=> "Главная"
			],
			[
				"href"=> "/",
				"title"=> " Элитная недвижимость на карте"
			]
		];
$arResult['mapSearch']['filter']['tabs'] = array_values($arResult['filters']);
$GLOBALS["JsonInit"]['mapSearch'] = $arResult['mapSearch'];
?>
