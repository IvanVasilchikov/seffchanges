<?
$tmp = [
	'title' => $arResult['catalog']['title'],
	'cards' => $arResult['catalog']['cards'],
	'tabs' => [
		[
			"text"=> "Все",
      "value"=> "all"
		],
		[
			"text"=> "Городская",
      "value"=> "1"
		],
		[
			"text"=> "Загородная",
      "value"=> "3"
		],
		[
			"text"=> "Коммерческая",
      "value"=> "2"
		],
		[
			"text"=> "Зарубежная",
      "value"=> "5"
		]
	],
	"error"=> "Нет добавленных предложений в избранном",
];
$GLOBALS["JsonInit"]['favorite'] = $tmp;
unset($GLOBALS["JsonInit"]['catalog']);
?>
