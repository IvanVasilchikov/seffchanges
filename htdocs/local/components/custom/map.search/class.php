<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class mapSearch extends CBitrixComponent
{
	public function searchFieldIndex($code, $array)
	{
		$index = false;
		foreach ($array as $key => $value) {
			if ($value['name'] == $code) {
				$index = $key;
				break;
			}
		}
		return $index;
	}
	public static function generateJsonFilter()
	{
		$typeActive=LIVE_DEPARTAMENT;
		if (is_numeric($_GET["type_page"])) {
			$typeActive=intval($_GET["type_page"]);
		}elseif($_GET["type_page"]){
			$typeActive=$_GET["type_page"];
		}
		global $APPLICATION;
		$json = [];
		$categories = [LIVE_DEPARTAMENT => 'Городская', COUNTRY_DEPARTAMENT => 'Загородная', FOREIGN_DEPARTAMENT => 'Зарубежная'];
		//COUNTRY_SKLAD => 'Складская',FOREIGN_TORG => 'Торговая', COMMERC_OFFICE => 'Офисная'
		foreach ($categories as $type => $text) {
			$tmp = $APPLICATION->IncludeComponent(
				"custom:object.filter",
				"",
				array(
					'DEPARTAMEN_ID' => $type,
					'MAP' => true,
				),
				false
			);
			$realtyType = [];
			foreach ($categories as $category => $text) {
				$realtyType[] = [
					"text" => $text,
					"value" => $category . '',
					"selected" => ($category === $type)
				];
			}
			$tmp['json']['active'] = ($type === $typeActive);
			array_splice($tmp['json']['fields'], 0, 0, [[
				"type" => "select",
				"name" => "realty_type",
				"values" => $realtyType
			]]);
			$json[$type] = $tmp['json'];
		}
		return $json;
	}

	public function executeComponent()
	{
		$this->arResult['filters'] = self::generateJsonFilter();		
		$this->includeComponentTemplate();
	}
}
