<?

use Bitrix\Main\Loader;
use Idem\Realty\Core\Objects\ObjectsTable;
use Idem\Realty\Core\Objects\Objects;
use Idem\Realty\Realty\Data;
use app\Util\Util;
use Idem\Realty\Import\Intrum;
use app\Util\Convert;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loader::includeModule('idem.realty');
Loader::includeModule('iblock');
class ObjectDetail extends CBitrixComponent
{
	const svgGorod = [
		'zhkclass'=>'/svg/class.svg',
		'finishyear'=>'/svg/gotovnost.svg',
		'balcones'=>'/svg/balcony.svg',
		'floors'=>'/svg/floor.svg',
		'floor'=>'/svg/floor.svg',
		'built_status'=>'/svg/gotovnost.svg',
		'kitchen_area'=>'/svg/kithen.svg',
		'metro'=>'/svg/metro.svg',
		'finish_type'=>'/svg/otdelka.svg',
		'count_parking_spaces'=>'/svg/parking.svg',
		'rooms'=>'/svg/room.svg',
		'area'=>'/svg/square.svg',
		'total_area_building'=>'/svg/square.svg',
		'wall_material'=>'/svg/type_house.svg',
		'count_flats'=>'/svg/count_kv.svg',
		'flat_type'=>'/svg/type_kv.svg',
		'jk_sale_count'=>'/svg/sale.svg',
		'floor_height'=>'/svg/potolok.svg',
		'bathrooms'=>'/svg/kanaliz.svg',
	];
	const svgZagorod = [
		'electricity_house'=>'/svg/electricity.svg',
		'electricity_in_the_house'=>'/svg/electricity.svg',
		'floors'=>'/svg/floor.svg',
		'gas_objects'=>'/svg/gaz.svg',
		'gas_poselok'=>'/svg/gaz.svg',
		'sewage_poselok'=>'/svg/kanaliz.svg',
		'sewage_objects'=>'/svg/kanaliz.svg',
		'forest'=>'/svg/les.svg',
		'distance_mkad'=>'/svg/mcad.svg',
		'highway'=>'/svg/road.svg',
		'jk_weaving_area'=>'/svg/sotka.svg',
		'area_weaving'=>'/svg/sotka.svg',
		'jk_count_weaving'=>'/svg/sotka.svg',
		'bedrooms'=>'/svg/bed.svg',
		'area_building'=>'/svg/square.svg',
		'jk_house_area'=>'/svg/square.svg',
		'object_type'=>'/svg/type_zagorod.svg',
		'wall_material'=>'/svg/wall.svg',
		'water'=>'/svg/water.svg',
		'finish_country'=>'/svg/otdelka.svg',
		'finish_type'=>'/svg/otdelka.svg',
		'jk_sale_count'=>'/svg/sale.svg',
		'jk_count_house'=>'/svg/type_house.svg',
		'vodosn_poselok'=>'/svg/vodoprovod.svg',
		'vodosn_objects'=>'/svg/vodoprovod.svg',
		'mebel'=>'/svg/mebel.svg',
		'bathrooms'=>'/svg/kanaliz.svg',
		'dop_build'=>'/svg/dop_str.svg',
		'permit_type'=>'/svg/type_use.svg',
		'land_category'=>'/svg/class.svg',
		'communications'=>'/svg/commun.svg',
		'district_area'=>'/svg/raion.svg',
		'to_the_airport'=>'/svg/airport.svg',
		'view'=>'/svg/view.svg',
		'pool'=>'/svg/swimming_pool.svg',
		'floor'=>'/svg/floor.svg',
		'loggia'=>'/svg/balcony.svg',
		'location'=>'/svg/raion.svg',
		'area'=>'/svg/square.svg',
		'finish'=>'/svg/gotovnost.svg',
	];
	const svgCommerc = [
		'type_real'=>'/svg/type_house.svg',
		'realty_class'=>'/svg/class.svg',
		'area'=>'/svg/square.svg',
		'floors'=>'/svg/floor.svg',
		'floor'=>'/svg/floor.svg',
		'finish_type'=>'/svg/otdelka.svg',
		'year_finish'=>'/svg/gotovnost.svg',
		'jk_sale_count'=>'/svg/sale.svg',
		'jk_count_offise'=>'/svg/count_pr.svg',
	];
	const typeBread = [
		LIVE_DEPARTAMENT=>'Городская недвижимость',
		COMMERC_DEPARTAMENT=>'Коммерческая недвижимость',
		COUNTRY_DEPARTAMENT=>'Загородная недвижимость',
		FOREIGN_DEPARTAMENT=>'Зарубежная недвижимость'
	];

	public function getJkObjectsTable($current)
	{
		global $APPLICATION;
		if ($current['jk_sale_count'] > 0 || $current['jk_rent_count'] > 0) {
			$params = [
				'parent_id' => $current['id'],
				'all_count' => 1,
				'order'=>'price_rub|asc',
			];
			$filter = $APPLICATION->IncludeComponent(
				"custom:object.filter",
				"",
				array(
					'DEPARTAMEN_ID' => $this->arParams['DEPARTAMENT_ID'],
					'DINAMIC' => true,
					'PARAMS' => $params,
				),
				false
			);
			$res = $APPLICATION->IncludeComponent(
				"custom:catalog",
				"",
				array(
					'DEPARTAMEN_ID' => $this->arParams['DEPARTAMENT_ID'],
					"RETURN" => true,
					"FILTER" => [
						'bool' => $filter['filter'],
					],
					'PARAMS' => $params,
					'json' => $filter['json'],
				),
				false
			);
			$tableSetting = [];
			if ($this->arParams['DEPARTAMENT_ID'] == LIVE_DEPARTAMENT || $this->arParams['DEPARTAMENT_ID'] == COMMERC_DEPARTAMENT) {
				$tableSetting = [
					[
						"title" => "ID",
						"field" => "id",
						"sortField" => "id",
						"sorter" => false
					],
					[
						"title" => "Площадь",
						"sortField" => "area",
						"field" => "info.square",
						"sorter" => true
					],
					[
						"title" => "Этаж",
						"sortField" => "floor",
						"field" => "info.floor",
						"sorter" => true
					],
					[
						"title" => "Отделка",
						"sortField" => "finish_type",
						"field" => "finish_type",
						"sorter" => false,
					],
					[
						"title" => "Планировки/Фото",
						"sortField" => "plan",
						"field" => "plan",
						"sorter" => false,
						"view" => "plan"
					],
					[
						"title" => "Цена",
						"sortField" => "price_rub",
						"view" => "price",
						"field" => "price.total",
						"dopClass" => "detail-table__cell--price-width",
						"dopClassList" => "detail-table__cell--price",
						"sorter" => true
					]
				];
			} else if ($this->arParams['DEPARTAMENT_ID'] == COUNTRY_DEPARTAMENT) {
				$tableSetting = [
					[
						"title" => "ID",
						"field" => "id",
						"sortField" => "id",
						"sorter" => false
					],
					[
						"title" => "Площадь",
						"sortField" => "area_building",
						"field" => "info.square",
						"sorter" => true
					],
					[
						"title" => "Площадь участка",
						"sortField" => "area_weaving",
						"field" => "info.area",
						"sorter" => true
					],
					[
						"title" => "Отделка",
						"sortField" => "finish_type",
						"field" => "finish_type",
						"sorter" => false,
					],
					[
						"title" => "Планировки/Фото",
						"sortField" => "plan",
						"field" => "plan",
						"sorter" => false,
						"view" => "plan"
					],
					[
						"title" => "Цена",
						"sortField" => "price_rub",
						"view" => "price",
						"field" => "price.total",
						"dopClass" => "detail-table__cell--price-width",
						"dopClassList" => "detail-table__cell--price",
						"sorter" => true
					]
				];
			}
			$sorterArray = [];
			foreach (array_filter($tableSetting, function($item){
				return $item['sorter'];
			}) as $item) {
				$title = morpher_inflect(strtolower($item['title']),'rod');
				$sorterArray[] = [
					"text"=> 'Увеличению '.$title,
					"value"=> $item['sortField'].'_asc',
					"field"=> $item['sortField'],
					"direction"=> "asc"
				];
				$sorterArray[] = [
					"text"=> 'Уменьшению '.$title,
					"value"=> $item['sortField'].'_desc',
					"field"=> $item['sortField'],
					"direction"=> "desc"
				];
			}
			$result = [
				"filterTable" => $filter['json'],
				"table" => $tableSetting,
				"cards" => $res['cards'],
				"sort"=> [
					"name"=> "sort",
					"values"=> array_merge([
						[
							"text"=> "По умолчанию",
							"value"=> "default",
							"selected"=> true
						],
					],$sorterArray)
				],
				"title" => "Выбрать предложение"
			];
			setJsonInit("detailComplex/apartments", $result);
			return $result;
		}
	}
	public function getJkObjectsCards($current)
	{
		global $APPLICATION;
		if ($current['jk_sale_count'] > 0 || $current['jk_rent_count'] > 0) {
			$json = [];
			$params = [
				'parent_id' => $current['id'],
			];
			$categories = [COUNTRY_DEPARTAMENT => 'Загородная'];
			foreach ($categories as $type => $text) {
				$filter = $APPLICATION->IncludeComponent(
					"custom:object.filter",
					"",
					array(
						'DEPARTAMEN_ID' => $type,
						'DINAMIC' => true,
						'PARAMS' => $params,
					),
					false
				);
				$realtyType = [];
				foreach ($categories as $category => $text) {
					$realtyType[] = [
						"text" => $text,
						"value" => $category . '',
						"selected" => ($category === $type),
					];
				}
				$filter['json']['active'] = ($type === COUNTRY_DEPARTAMENT);
				array_splice($filter['json']['fields'], 0, 0, [[
					"type" => "select",
					"name" => "realty_type",
					"values" => $realtyType,
				]]);
				unset($filter['json']["popupButtons"]);
				unset($filter['json']["more"][3]);
				$json[] = $filter['json'];
			}
			$resCart = $APPLICATION->IncludeComponent(
				"custom:catalog",
				"",
				array(
					'LIMIT' => 6,
					'DEPARTAMEN_ID' => $this->arParams['DEPARTAMENT_ID'],
					"RETURN" => true,
					"SORT"=>["name"=>"price_rub","order"=>"asc"],
					"FILTER" => [
						'bool' => $filter['filter'],
					],
					'PARAMS' => array_merge($params, [
						'order'=>'price_rub|asc',
					]),
					'json' =>  $filter['json'],
				),
				false
			);
			$results = [
				"filterCards" =>[
					"action" => "/api/objects.php?parent_id={$current['id']}&size=6",
					"params"=> ['size'=>6, 'order'=>'price_rub|asc'],
					"tabs" => $json
				],
				"cards" => $resCart['cards'],
				"title" => "Выбрать предложение",
				"view"=>"cards",
				"sort"=> [
					"name"=> "sort",
					"values"=> [
						[
							"text"=> "По умолчанию",
							"value"=> "default",
							"selected"=> true
						],
						[
							"text"=> "Увеличение цены",
							"value"=> "price_asc",
							"field"=> "price",
							"direction"=> "asc"
						],
						[
							"text"=> "Уменьшение цены",
							"value"=> "price_desc",
							"field"=> "price",
							"direction"=> "desc"
						],
						[
							"text"=> "Увеличение площади",
							"value"=> "area_asc",
							"field"=> "area",
							"direction"=> "asc"
						],
						[
							"text"=> "Уменьшение площади",
							"value"=> "area_desc",
							"field"=> "area",
							"direction"=> "desc"
						]
					]
				],
				"pagination" => $resCart["pagination"],
			];
			setJsonInit("detailComplex/apartments", $results);
		}

	}

	public function tease($body, $sentencesToDisplay = 2)
	{
		preg_match('/^([^.!?]*[\.!?]+){0,' . $sentencesToDisplay . '}/', strip_tags($body), $abstract);
		$string = $abstract[0];
		$string = rtrim($string, "!,.-");
		return $string . "… ";
	}

	public function subText($string, $limit)
	{
		$string = strip_tags($string);
		$string = substr($string, 0, $limit);
		$string = rtrim($string, "!,.-");
		$string = substr($string, 0, strrpos($string, ' '));
		return $string . "… ";
	}

	public function generateRowView($info, $offerConfig, $charact = false, $about=false, $parents=false)
	{
		$fields['id'] = $info['id'];
		$distance_metro = $info['distance_metro'];
		$metro = $info['metro'];
		if (is_array($info['object_type'])) {
			$info['object_type'] = $info['object_type'][0];
		}
		if ($info['isJk'] == 1 && $info["department_id"] == COUNTRY_DEPARTAMENT) {
			$info['object_type'] = "Посёлок";
		}
		$department=$info["department_id"];
		$object_type = $info['object_type'];
		$floors = $info['floors'];
		$fields = Convert::fromElasticFields($info);
		$info = [];

		foreach ($offerConfig as $fieldConfig) {
			$spec = Util::filterValue($fieldConfig);
			$value = $spec['filter']($fields[$spec['field']], $fields);
			$ico = $spec['ico'];
			if ($fields[$spec['field']] != '' && $value && $ico) {
				$url=false;
				if($spec["field"]=="highway"){
					$url='/zagorod/sale/'.\CUtil::translit($value, 'ru', Intrum::TRANSLIT).'-shosse/';
				}
				if($spec["field"]=="object_type" && $this->arParams['DEPARTAMENT_ID'] == COUNTRY_DEPARTAMENT){
					$url='/zagorod/sale/'.\CUtil::translit($value, 'ru', Intrum::TRANSLIT).'/';
				}
				if (stripos($ico, 'plural') !== false) {
					$arPlur = explode(",", str_replace(['plural:[', ']'], "", $ico));
					if ($arPlur[0] == "object_type") {
						$ico = Util::plural_form(intval($value), Util::simular_form($object_type, true), false);
						$value = intval($value);
					} else {
						$ico = Util::plural_form(intval($value), $arPlur, false);
					}
				}
				if ($ico == 'distance_metro') {
					if ($distance_metro != '')
						$ico = Util::plural_form(intval($distance_metro), ['минута пешком', 'минуты пешком', 'минут пешком'], true);
					else
						$ico = '';
				}
				if ($ico == 'metro' && $metro != '') {
					$ico = 'До метро ' . $metro;
				}
				if ($ico == 'floors') {
					if ($floors != '') {
						$ico = '/' . $floors . ' этаж';
					} else {
						$ico = ' этаж';
					}
				}
				if (is_array($value)) {
					$value = $value[0];
				}
				if ($spec['field'] == "gas_in_the_house" || $spec['field'] == "electricity_house" || $spec['field'] == "sewage" || $spec['field'] == "plumbing" || $spec['field'] == "gas_line" || $spec['field'] == "electricity_in_the_house") {
					if ($value == 1) {
						$value = 'да';
					} else {
						$value = 'нет';
					}
				}
				if($spec['field'] == "area"){
					$value = number_format($value, 0, ' ', ' ');
					if($ico != "м²"){
						$value = $value." м²";
					}
				}
				if ($value == DEAL_TYPE_SALE) {
					$value = "Продажа";
				}
				if ($value == DEAL_TYPE_RENT) {
					$value = "Аренда";
				}
				$svg='/svg/class.svg';
				if($department == COUNTRY_DEPARTAMENT || $department == FOREIGN_DEPARTAMENT){
					if(self::svgZagorod[$spec['field']]!=NULL){
						$svg=self::svgZagorod[$spec['field']];
					}
				}elseif($department == COMMERC_DEPARTAMENT){
					if(self::svgCommerc[$spec['field']]!=NULL){
						$svg=self::svgCommerc[$spec['field']];
					}
				}else{
					if(self::svgGorod[$spec['field']]!=NULL){
						$svg=self::svgGorod[$spec['field']];
					}
				}


				if ($charact) {
					$info[] = ["title" => $ico, "text" => $value, "icon"=> $this->__path .$svg, "url"=>$url];
				}elseif($about){
					$info[] = ["title" => $value, "text" => $ico];
				}elseif($parents){
					$info[] = ["heading" => $value, "phrase" => $ico];
				} else {
					$info[] = ["text" =>$value.' '. $ico, "icon" => $this->__path .$svg];
				}

			}
		}
		return $info;
	}

	/** Блок конфигураций */
	public function generateData($json, $JK)
	{
		if ($json["department_id"] == LIVE_DEPARTAMENT) {
			$titleConfig = ['object_type', 'area|postfix:м²'];
			$addressConfig = ['city', 'district', 'locality', 'district_area', 'address', 'house'];
			$mainConfig = ['area!м²', 'rooms!plural:[комната,комнаты,комнат]', 'floor!floors', 'bathrooms!plural:[санузлел,санузла,санузлов]',/* 'metro!distance_metro|postfix:,|prefix:м.', /*'finish_type!&nbsp;'*/];
			$charactConfig = ['area!Общая площадь|postfix:м²', 'rooms!Количество комнат', 'floor!Этаж/этажей в доме|with-field:floors:/', 'flat_type!Тип квартиры', 'kitchen_area!Кухня|postfix:м²', 'finish_type!Отделка', 'balcones!Балкон'];
			if ($JK) {
				$titleConfig = ['lot_name|prefix:Жилой комплекс'];
				$aboutConfig = ['count_parking_spaces!plural:[Парковочное место,Парковочных места,Парковочных мест]', 'distance_metro!metro|postfix:<span>мин</span>', 'area_park_g!Площадь собственного парка|postfix:<span>га</span>'];
				$mainConfig = ['total_area_building!м²', 'count_flats!plural:[предложение,предложения,предложений]', 'floors!plural:[этаж,этажа,этажей]'/*, 'metro!distance_metro|postfix:,|prefix:м.'*/, 'jk_sale_count!в продаже', 'jk_rent_count!в аренде'];
				$charactConfig = ['zhkclass!Класс ЖК', 'wall_material!Тип дома', 'total_area_building!Общая площадь|postfix:м²', 'count_flats!Количество квартир', 'floors!Этажей в доме', 'finishyear!Готовность дома', 'finish_type!Отделка', 'floor_height!Высота потолков|postfix:м'];
			}
		} else if ($json["department_id"] == COUNTRY_DEPARTAMENT) {
			$titleConfig = ['object_type', 'area_building|postfix:м²'];
			$addressConfig = ['district_area', 'highway', 'distance_mkad|postfix:км'];
			$needMkad = ' от МКАД';
			if ($json["object_type"] == "Участок") {
				$mainConfig = ['area_weaving!соток', 'distance_mkad!км от МКАД'];
				$titleConfig = ['object_type', 'area_weaving|postfix:сот.'];
				$charactConfig = ['object_type!Тип', 'area_weaving!Площадь участка|postfix:сот.', 'highway!Шоссе', "distance_mkad!Удаленность{$needMkad}|postfix:км", 'gas_objects!Газ', 'electricity_house!Электричество', 'vodosn_objects!Водоснабжение', 'sewage_objects!Канализация', 'permit_type!Вид использования', 'land_category!Категория земли', 'forest!Лес рядом', 'water!У водоема'];
			} else {
				$charactConfig = ['object_type!Тип', 'highway!Шоссе', 'area_building!Площадь дома|postfix:м²', 'area_weaving!Площадь участка|postfix:сот.', 'bedrooms!Кол-во спален', 'bathrooms!Кол-во санузлов', 'floors!Этажей', 'mebel!Мебель', 'finish_type!Отделка', 'dop_build!Доп. строения', 'wall_material!Материал стен', 'gas_objects!Газ', 'electricity_house!Электричество', 'vodosn_objects!Водоснабжение', 'sewage_objects!Канализация', 'forest!Лес', 'water!У водоема'];
				$mainConfig = ['area_building!м²', 'area_weaving!соток', 'bedrooms! ', /*'finish_type!&nbsp;'*/];
			}
			if ($JK) {
				$titleConfig = ['lot_name|prefix:Посёлок'];
				$aboutConfig = ['jk_house_area!Площадь домов|postfix:<span>м²</span>', 'jk_weaving_area!Площадь участков|postfix:<span>сот.</span>', "distance_mkad!Удаленность{$needMkad}|postfix:<span>км</span>"];
				$charactConfig = ['object_type!Тип', 'district_area!Район', 'highway!Направление', 'jk_house_area!Площадь домов|postfix:м²', 'jk_weaving_area!Площадь участков|postfix:сот.', "distance_mkad!Удаленность от МКАД|postfix:км", 'finish_country!Отделка', 'communications!Коммуникации', 'gas_poselok!Газ', 'electricity_in_the_house!Электричество', 'vodosn_poselok!Водоснабжение', 'sewage_poselok!Канализация'];
				$mainConfig = ['jk_count_house!plural:[дом,дома,домов]', 'jk_count_weaving!plural:[участок,участка,участков]', 'jk_count_taun!plural:[таунхаус,таунхауса,таунхаусов]', 'jk_sale_count!в продаже', 'jk_rent_count!в аренде'];
			}
		}else if ($json["department_id"] == FOREIGN_DEPARTAMENT) {
			$titleConfig = ['lot_name'];
		$mainConfig = ['area!м²', 'bedrooms! ', 'finish! '];
			$addressConfig = ['country', 'city'];
			$charactConfig = ['object_type!Тип', 'area!Площадь|postfix:м²', 'area_weaving!Площадь участка|postfix:соток', 'bedrooms!Кол-во спален', 'loggia!Балкон', 'location!Расположение', 'to_the_airport!Аэропорт', 'view!Вид', 'floor!Этаж', 'floor!Этаж/этажей в доме|with-field:floors:/', 'pool!Бассейн'];

		}else if ($json["department_id"] == COMMERC_DEPARTAMENT) {
			$titleConfig = ['lot_name'];
			$mainConfig = ['area!м²', 'realty_class! |prefix:Класс ','floor!floors','finish_type! '];
			$addressConfig = ['country', 'city', 'district', 'locality', 'district_area', 'address', 'house'];
			$charactConfig = ['type_real!Тип здания', 'realty_class!Класс', 'area!Площадь офиса', 'floor!Этаж/этажей в здании|with-field:floors:/', 'year_finish!Год строительства'];
			if ($JK) {
				$mainConfig = ['jk_count_offise!plural:[офис,офиса,офисов]','floors!plural:[этаж,этажа,этажей]', 'jk_sale_count!в продаже', 'jk_rent_count!в аренде'];
				$charactConfig = ['type_real!Тип здания', 'realty_class!Класс', 'area!Площадь здания', 'floors!Количество этажей', 'year_finish!Год строительства'];
			}
		}
		if ($JK) {
			$descConfig = ['desc_jk_charact'];
		} else {
			$descConfig = ['description'];
		}
		$arResult = [
			"titleConfig" => $titleConfig,
			"addressConfig" => $addressConfig,
			"mainConfig" => $mainConfig,
			"charactConfig" => $charactConfig,
			"aboutConfig" => $aboutConfig,
			"descConfig" => $descConfig
		];
		return $arResult;
	}

	public function generateDataDetail($json, $JK)
	{
		$static = \Idem\CIdemStatic::getInstance(true, "ru");
		$config = $this->generateData($json, $JK);

		$name = Util::generatedFields($config['titleConfig'], $json);
		$address = Util::generatedFields($config['addressConfig'], $json);
		$descObject = Util::generatedFields($config['descConfig'], $json);

		if (is_array($json["plan"])) {
			$json["plan"] = implode(",", $json["plan"]);
		}
		if ($json["plan"] != '') {
			$json["main_img"] = $json["main_img"] . ',' . $json["plan"];
		}
		if ($json["main_img"] != "") {
			$sliderObject = Util::getCropImgs(explode(",", $json["main_img"]), 1200, 1200);
		}
		if ($json["zhk_main_img"] != "") {
			$sliderJk = Util::getCropImgs(explode(",", $json["zhk_main_img"]), 1200, 1200);
		}
		if ($JK) {
			if ($sliderJk) {
				$sliderOne[] = $sliderJk[0];
				$sliderMain = $sliderJk;
			} elseif ($sliderObject) {
				$sliderOne[] = $sliderObject[0];
				$sliderMain = $sliderObject;
			}
			$type = "complex";
		} else {
			if ($sliderObject) {
				$sliderMain = $sliderObject;
			} elseif ($sliderJk) {
				$sliderMain = $sliderJk;
			}
			$type = "object";
		}
		if (!$sliderMain) {
			$sliderMain = [$this->__path . '/img/zaglushka_813х665.jpg'];
			$sliderOne = [$this->__path . '/img/zaglushka_813х665.jpg'];
		}

		$fieldsUrl = [
			"object_type" => $json["object_type"],
			"deal_type" => $json["deal_type"],
			"department" => $json["department"],
			"department_id" => $json["department_id"],
		];
		$urlCategory = Data::createUrl([], $fieldsUrl);
		global $APPLICATION;
		$backUrl = $_SERVER['HTTP_REFERER'];
		if ($backUrl == NULL || $backUrl == 'https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurUri() || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
			$backUrl = $urlCategory;
		}
		$navName = $name;
		if ($JK && ($json["department_id"] == LIVE_DEPARTAMENT)) {
			if (strpos($json['realty_type'], 'новостройка') !== false) {
				$navName = 'Новостройка';
			} else {
				$navName = 'Вторичка';
			}
		}
		if ($JK && ($json["department_id"] == COUNTRY_DEPARTAMENT)) {
			$navName = 'Поселок';
		}
		$objectType=mb_strtolower(morpher_inflect($json["object_type"],'im mn'));

		if(morpher_inflect($json["object_type"],'rod mn') == "#ERROR: Parameter 1 'text' is plural."){
			$objectType=mb_strtolower($json["object_type"]);
		}

		$resJson = [
			"nav" => [
				"title" => $navName,
				// "price" => ($json["price_hidden"] != 1 && $json["price_rub"] != '') ? number_format($json["price_rub"], 0, '.', ' ') . " р." : 'По запросу',
				"links" => [
					[
						"text" => GetMessage("characteristics"),
						"anchor" => "#characteristics"
					]
				]
			],
			'main' => [
				"breadcrumbs"=> [
					[
						"href"=> "/",
						"title"=> "Главная"
					],
					[
						"href"=> Data::createUrl([], ["department" => $json["department"],"department_id" => $json["department_id"]]),
						"title"=> self::typeBread[$json["department_id"]],
					],

				],
				"id" => 'ID:'.$json['id'],
				"isFav" => false,
				"backPage" => $backUrl,
				"type" => $type,
				"images" => array_map(function ($item) {
					return [
						"sources" => [
							"mobile" => [$item],
							"tablet" => [$item],
							"desktop" => [$item]
						],
						"alt" => "",
					];
				}, $sliderMain),
				"title" => $name,
				"address" => $address,
				"phone" => [
					"text" => $static->get('catalog_detail.phone'),
					"url" => $static->get('catalog_detail.phone')
				]
			],
			"characteristics" => [
				"title" => GetMessage("characteristics"),
				"description" => str_replace("\n", "<br>", $descObject),
				"share" => [
					[
						"icon" => "/assets/svg/socials/email.svg",
						"name" => "email"
					],
					[
						"icon" => "/assets/svg/socials/facebook.svg",
						"name" => "facebook"
					],
					[
						"icon" => "/assets/svg/socials/twitter.svg",
						"name" => "twitter"
					],
					[
						"icon" => "/assets/svg/socials/vk.svg",
						"name" => "vk"
					],
					[
						"icon" => "/assets/svg/socials/viber.svg",
						"name" => "viber"
					],
					[
						"icon" => "/assets/svg/socials/whatsapp.svg",
						"name" => "whatsApp"
					],
					[
						"icon" => "/assets/svg/socials/telegram.svg",
						"name" => "telegram"
					]
				]
			],
			"banner" => [
				"picture" => [
					"sources" => [
						"tablet" => [
							"/assets/images/detail/banner/background-tablet.jpg",
							"/assets/images/detail/banner/background-tablet.webp"
						],
						"desktop" => [
							"/assets/images/detail/banner/background-tablet.jpg",
							"/assets/images/detail/banner/background-tablet.webp"
						]
					],
					"alt" => "",
					"title" => ""
				],
				"title" => GetMessage("BookTime"),
				"form" => [
					"url" => "/ajax/booking.php",
					"hidden" => [
						"object" => $name . " #" . $this->arParams['ID'],
						"page" => $APPLICATION->GetCurDir()
					],
					"inputs" => [
						[
							"title" => GetMessage("name"),
							"placeholder" => GetMessage("name") . "*",
							"value" => "",
							"name" => "name",
							"type" => "text",
							"className" => "",
							"checked" => [
								"value" => "waiting",
								"required" => true,
								"lengthString" => [
									"min" => 1,
									"max" => 50
								]
							]
						],
						[
							"title" => GetMessage("phone"),
							"placeholder" => "+7 (___) ___-__-__*",
							"value" => "",
							"name" => "phone",
							"type" => "text",
							"className" => "input--phone",
							"maskInfo" => [
								"complete" => false
							],
							"checked" => [
								"value" => "waiting",
								"required" => true,
								"lengthString" => [
									"min" => 17,
									"max" => 17
								]
							]
						]
					],
					"timeInputs" => [
						[
							"title" => GetMessage("time"),
							"placeholder" => GetMessage("from"),
							"name" => "timeFrom",
							"type" => "text",
							"timeMask" => [
								"complete" => false
							]
						],
						[
							"placeholder" => GetMessage("to"),
							"name" => "timeTo",
							"type" => "text",
							"timeMask" => [
								"complete" => false
							]
						]
					],
					"btn" => GetMessage("booking"),
					"checkbox" => [
						"text" => GetMessage("agreePersonal"),
						"name" => "checkbox",
						"value" => "y",
						"checked" => false
					]
				]
			],
			"about" => [
				"title" => $name,
				"description" => $json["zhk_description"],
				"slider" => [
					[
						"sources" => [
							"desktop" => $sliderOne
						],
						"alt" => "",
						"title" => "slide 1"
					]
				],
				"buttons" => [
					[
						"type" => "presentation",
						"image" => "/assets/images/detail/catalog-mini.png",
						"url" => "/personalData.pdf",
						"text" => GetMessage("prez") . " «" . $name . "»"
					],
					[
						"type" => "plan",
						"image" => "/assets/images/detail/catalog-mini.png",
						"url" => "",
						"text" => GetMessage("typePlan")
					]
				],
			],
		];
		if (!$JK) {
			array_push($resJson["main"]["breadcrumbs"], ["href"=> Data::createUrl([], $fieldsUrl),"title"=> 'Элитные '.$objectType]);
		}
		elseif($JK && $json["department_id"] == LIVE_DEPARTAMENT){
			array_push($resJson["main"]["breadcrumbs"], ["href"=> '/gorod/novostroyka/',"title"=> 'Элитные новостройки']);
		}elseif($JK && $json["department_id"] == COUNTRY_DEPARTAMENT){
			array_push($resJson["main"]["breadcrumbs"], ["href"=> '/zagorod/poselok/',"title"=> 'Элитные посёлки']);
		}
		if ($json["highway"] != '') {
			array_push($resJson["main"]["breadcrumbs"], ["href"=> Data::createUrl([], $fieldsUrl).\CUtil::translit($json["highway"], 'ru', Intrum::TRANSLIT).'-shosse/',"title"=>$json["highway"].' шоссе']);
		}
		$urlCity=Data::createUrl([], $fieldsUrl);
		if ($json["country"] != '' && $json["department_id"] == FOREIGN_DEPARTAMENT) {
			$urlCity=$urlCity.\CUtil::translit($json["country"], 'ru', Intrum::TRANSLIT).'/';
			array_push($resJson["main"]["breadcrumbs"], ["href"=> $urlCity,"title"=>$json["country"]]);

		}
		if ($json["city"] != '' && $json["department_id"] == FOREIGN_DEPARTAMENT) {
			array_push($resJson["main"]["breadcrumbs"], ["href"=> $urlCity.\CUtil::translit($json["city"], 'ru', Intrum::TRANSLIT).'/',"title"=>$json["city"]]);
		}
		array_push($resJson["main"]["breadcrumbs"], ["title"=>'ID '.$json['id']]);

		if ($json["department_id"] == COUNTRY_DEPARTAMENT) {
			$resJson["about"]["buttons"] = [
				[
					"type" => "presentation",
					"image" => "/assets/images/detail/catalog-mini.png",
					"url" => "/personalData.pdf",
					"text" => GetMessage("prez") . " «" . $name . "»"
				]
			];
		}
		if ($JK) {
			if ($json["department_id"] == LIVE_DEPARTAMENT) {
				array_push($resJson["nav"]["links"], ["text" => GetMessage("aboutJK"), "anchor" => "#about"]);
			} else {
				array_push($resJson["nav"]["links"], ["text" => "О посёлке", "anchor" => "#about"]);
			}
			if ($json["department_id"] == COUNTRY_DEPARTAMENT) {
				array_push($resJson["nav"]["links"], ["text" => "Предложения", "anchor" => "#detail-choose"]);
			}
		}
		array_unshift($resJson["nav"]["links"], ["text" => GetMessage("descObject"), "anchor" => "#main"]);
		if (!$JK) {
			if ($json["parent_id"] != "") {
				if ($json["department_id"] == LIVE_DEPARTAMENT) {
					array_push($resJson["nav"]["links"], ["text" => GetMessage("aboutJK"), "anchor" => "#aboutComplex"]);
				} else {
					array_push($resJson["nav"]["links"], ["text" => "О посёлке", "anchor" => "#aboutComplex"]);
				}
			}
		}
		if ($json["parent_id"] != "" && $json["department_id"] != FOREIGN_DEPARTAMENT) {
			$parentObj = ObjectsTable::wakeUpObject($json["parent_id"]);
			$parentObj->fill();
			$jsonParent = $parentObj->getInfo();
			$jsonParent['id'] = $parentObj->getId();
			$jsonParent["zhk_main_img"] = explode(',', $jsonParent["zhk_main_img"]);
			if ($jsonParent["zhk_main_img"][0] != NULL) {
				$img = Util::getCropImgs([$jsonParent["zhk_main_img"][0]], 1400, 1000);
			} else {
				$img = [$this->__path . '/img/zaglushka_1440х600.jpg'];
				$imgMobile = [$this->__path . '/img/zaglushka_347х337_detail_2.jpg'];
				$imgTablet = [$this->__path . '/img/zaglushka_688х478_768.jpg'];
			}
			$resJson["complex"]["image"]["sources"]["desktop"] = $img;
			$resJson["complex"]["image"]["sources"]["mobile"] = $imgMobile;
			$resJson["complex"]["image"]["sources"]["tablet"] = $imgTablet;
			$resJson["complex"]["image"]["alt"] = 'complex';
			$resJson["complex"]["image"]["title"] = 'complex';
			$resJson["complex"]["title"] = $jsonParent["lot_name"];
			$resJson["complex"]["text"] = $this->tease($jsonParent["zhk_description"]);
			if ($json["department_id"] == LIVE_DEPARTAMENT) {
				$resJson["complex"]["button"] = ["link" => Data::createUrl([], $jsonParent), "text" => GetMessage("descJK")];
			} else {
				$resJson["complex"]["button"] = ["link" => Data::createUrl([], $jsonParent), "text" => 'Подробнее о поселке'];
			}
		}
		if ($json["department_id"] == LIVE_DEPARTAMENT) {
			if ($json["park_zone_infra"] != "" || $json["security_infra"] != "" || $json["parking_infra"] || $json["concierge_infra"] || $json["location_infra"]) {
				array_push($resJson["nav"]["links"], ["text" => GetMessage("infrastructure"), "anchor" => "#infrastructure"]);
			}
		}
		if ($json["department_id"] == COUNTRY_DEPARTAMENT) {
			if ($json["education_infra"] != "" || $json["parks_ponds_infra"] != "" || $json["fitness_spa_infra"] != "" || $json["cafes_restaurants_infra"] != "") {
				array_push($resJson["nav"]["links"], ["text" => GetMessage("infrastructure"), "anchor" => "#infrastructure"]);
			}
		}
		if ($json["department_id"] == COMMERC_DEPARTAMENT) {
			array_push($resJson["nav"]["links"], ["text" => "Карта", "anchor" => "#map"]);
		}
		if(\Bitrix\Iblock\ElementTable::getCount([
				"IBLOCK.CODE"=>"areas_ru",
				"ACTIVE"=>"Y",
				"NAME"=>$json["locality"]
		]) > 0) {
			array_push($resJson["nav"]["links"], ["text"=> GetMessage("district"), "anchor"=> "#district"]);
		}
		if($json["metro"] !=""){
			$resJson["main"]["metro"] =[
				"station"=> "м. ".$json["metro"].",",
				"text"=> $json["distance_metro"]." мин. пешком"
			];
		}
		$resJson["main"]["info"] = [];
		$resJson["characteristics"]["info"] = [];
		$resJson["about"]["info"] = [];
		if ($config['mainConfig']) {
			$resJson["main"]["info"] = $this->generateRowView($json, $config['mainConfig']);
		}
		if ($config['charactConfig']) {
			$resJson["characteristics"]["info"] = $this->generateRowView($json, $config['charactConfig'], true);
		}
		if ($config['aboutConfig']) {
			$resJson["about"]["info"] = $this->generateRowView($json, $config['aboutConfig'],false,true);
		}
		if ($json["department_id"] == COMMERC_DEPARTAMENT) {
			unset($resJson["about"]);
		}
		$valutes = ['rub' => 'rub', 'dol' => 'dollar', 'eur' => 'euro'];
		if($json["department_id"] == FOREIGN_DEPARTAMENT){
			$valutes = ['rub' => 'rub', 'dol' => 'dollar', 'eur' => 'euro', 'pound' => 'pound'];
			array_push($resJson["nav"]["links"], ["text" => "Карта", "anchor" => "#map"]);
		}
		foreach ($valutes as $k => $valute) {
			if(is_array($json["square_price_" . $k]) && !empty($json["square_price_" . $k])){
				$json["square_price_" . $k] = min(array_diff($json["square_price_" . $k], array('')));
			}
			if(is_array($json["price_" . $k]) && !empty($json["price_" . $k])){
				$json["price_" . $k] = min(array_diff($json["price_" . $k], array('')));
			}
			if ($json["square_price_" . $k] != '') {
				$resJson["main"]["price"]["meters"][$valute] = number_format($json["square_price_" . $k], 0, '.', ' ') . GetMessage($k) . '/м2';
				if ($k == 'rub') {
					$resJson["main"]["price"]["selected"]["meters"] = number_format($json["square_price_" . $k], 0, '.', ' ') . GetMessage($k) . '/м2';
				}
			}
			if ($json["price_" . $k] != '') {
				if($JK){
					$resJson["main"]["price"]["total"][$valute] = 'от '.number_format($json["price_" . $k], 0, '.', ' ') . GetMessage($k);
				}else{
					$resJson["main"]["price"]["total"][$valute] = number_format($json["price_" . $k], 0, '.', ' ') . GetMessage($k);
				}
				if ($k == 'rub') {
					if($JK){
						$resJson["main"]["price"]["selected"]["total"] = 'от '.number_format($json["price_" . $k], 0, '.', ' ') . GetMessage($k);
					}else{
						$resJson["main"]["price"]["selected"]["total"] = number_format($json["price_" . $k], 0, '.', ' ') . GetMessage($k);
					}
				}
			}
		}

		$resJson["main"]["price"]["offer"]=true;
		
		if (($JK && $json["price_hidden"] != '') || ((!$JK && $json["price_hidden"] != '') || (!$JK && ($json["price_hidden_lot"] != '' || $json['price_rub']=="")))) {
			$resJson["main"]["price"]['request'] = true;
		}

		$resJson["nav"]["price"] =  ($json["price_hidden"] == '' && $json["price_hidden_lot"] == '' && $resJson["main"]["price"]["selected"]["total"]) ? $resJson["main"]["price"]["selected"]["total"] : 'По запросу';

		/** SEO **/
		$titleSeo=[];
		$keySeo=[];
		$descSeo=[];
		$titleSeo[]=$json['id'];

		if (($JK && $json["price_hidden"] != '') || $json["price_hidden_lot"] != '' || $json['price_rub']=="") {
			$titleSeo[] = "цена по запросу";
		}elseif($json['price_rub']!=""){
			if($JK){
				$titleSeo[]='от '.number_format((is_array($json["price_rub"]))?min($json["price_rub"]):$json["price_rub"], 0, '.', ' ')."руб.";
			}else{
				$titleSeo[]=number_format($json['price_rub'], 0, '.', ' ')."руб.";
			}
		}
		if($json['price_dol']!="" && $json['price_eur']!="" && $json["price_hidden"] == '' && $json["price_hidden_lot"]== ''){
			if($JK){
				$titleSeo[]="(от " . number_format((is_array($json["price_dol"]))?min($json['price_dol']):$json['price_dol'], 0, '.', ' ') . "$, от " . number_format((is_array($json["price_eur"]))?min($json['price_eur']):$json['price_eur'], 0, '.', ' ') . "€)";
			}elseif($json["department_id"] == FOREIGN_DEPARTAMENT){
				$titleSeo[] = "(" . number_format($json['price_dol'], 0, '.', ' ') . "$, " . number_format($json['price_eur'], 0, '.', ' ') . "€, " . number_format($json['price_pound'], 0, '.', ' ') . "£)";
			}else{
				$titleSeo[] = "(" . number_format($json['price_dol'], 0, '.', ' ') . "$, " . number_format($json['price_eur'], 0, '.', ' ') . "€)";
			}
		}
		if ($json["department_id"] == LIVE_DEPARTAMENT) {
			if($json['rooms']!=""){
				if($JK ){
				if(is_array($json["area"])){
					$titleSeo[] = 'от '.Util::plural_form(intval(min($json["rooms"])), ['комнаты', 'комнат', 'комнат']);
				}else{
					$titleSeo[] = 'от '.Util::plural_form(intval($json["rooms"]), ['комнаты', 'комнат', 'комнат']);
				}
				}else {
				$titleSeo[] = Util::plural_form(intval($json['rooms']), ['комната', 'комнаты', 'комнат']);
				}
			}
			if($json['area']!=""){
				if($JK){
				if(is_array($json["area"])){
					$titleSeo[]='от '.min($json["area"]) . "м²";
				}else{
					$titleSeo[]='от '.$json["area"] . "м²";
				}
				}else {
				$titleSeo[] = $json['area'] . "м²";
				}
			}
			$descSeo[]=$json['id'];
			if($JK){
				$titleSeo=[];
				$keySeo=[];
				$descSeo=[];
				$titleSeo[]="Жилой комплекс ".$json['lot_name'];
				if($json['address'] != '' ){
					$titleSeo[]=$json['address'];
				}
				if($json['house'] != '' ){
					$titleSeo[]=$json['house'];
				}
				$keySeo[]='ЖК '.$json['lot_name'].', жилой комплекс '.$json['lot_name'].', жк '.$json['lot_name'].' официальный сайт';
				$descSeo[]='ЖК '.$json['lot_name'].'. Лучшие предложения от экспертов рынка. Оставьте онлайн-заявку или свяжитесь '.$static->get('contacts_' . LANGUAGE_ID . '.phone_text');
			}
		}elseif ($json["department_id"] == COUNTRY_DEPARTAMENT) {
			if($json['area_weaving']!=""){
				if($JK){
				if(is_array($json["area_weaving"])){
					$titleSeo[]='от '.min($json["area_weaving"]) . " сот.";
				}else{
					$titleSeo[]='от '.$json["area_weaving"] . " сот.";
				}
				}else {
				$titleSeo[] = $json['area_weaving'] . " сот.";
				}
			}
			if($json['area_building']!=""){
				if($JK){
				if(is_array($json["area_building"])){
					$titleSeo[]='от '.min($json["area_building"]) .  "м²";
				}else{
					$titleSeo[]='от '.$json["area_building"] .  "м²";
				}
				}else {
				$titleSeo[] = $json['area_building'] . "м²";
				}
			}
			$descSeo[]=$json['id'];
			if($JK){
				$titleSeo=[];
				$keySeo=[];
				$descSeo=[];
				$titleSeo[]="Поселок ".$json['lot_name'].". Предложения, информация о поселке";
				$keySeo[]='Коттеджный поселок '.$json['lot_name'].', коттеджный поселок '.$json['lot_name'].' официальный сайт, КП '.$json['lot_name'].' официальный сайт';
				$descSeo[]='Все актуальные объекты в КП '.$json['lot_name'].'! Объекты в закрытой продаже! Звоните! · Проектная декларация на рекламируемом сайте';
			}
		}
		$titleSeo = implode(', ', $titleSeo);
		$keySeo = implode(', ', $keySeo);
		$descSeo = implode(', ', $descSeo);
		if(empty($keySeo)){
			$keySeo=$titleSeo;
		}
		$this->getMeta($titleSeo, $descSeo, $json["zhk_main_img"][0], $keySeo);
		return $resJson;
	}

	public function executeComponent()
	{
		if (!$this->arParams['ID']) {
			return true;
		}
		$JK = false;
		$detailObj = ObjectsTable::wakeUpObject($this->arParams['ID']);
		$detailObj->fill();
		$json = $detailObj->getInfo();
		$json = Convert::fromElasticFields($json);
		$json['id'] = $detailObj->getId();
		if ($json["isJk"] === 1) {
			$JK = true;
		}
		if ($this->arParams['PDF'] == true) {
			$result = $this->getPdfObject($json, $JK);
		} else {
			$result = $this->generateDataDetail($json, $JK);
		}
		$this->arResult['json'] = $result;
		if (is_null($this->arParams['PDF'])) {
			$this->arResult['json']["similar"]=$this->getSimilar($json, $json["isJk"]);
			$descDetail = $this->generateDataDetailDesc($json);
			$this->syncVue($JK);
			$this->arResult['json']=array_merge($this->arResult['json'],$descDetail);
			if ($JK) {
				$nameBlock = "detailComplex";
			} else {
				$nameBlock = "detailObject";
			}
			if ($descDetail["infrastructure"]) {
				setJsonInit($nameBlock . '/infrastructure', $descDetail["infrastructure"]);
			}
			if ($descDetail["map"]) {
				setJsonInit($nameBlock . '/map', $descDetail["map"]);
			}
			if ($descDetail["district"]) {
				setJsonInit($nameBlock . '/district', $descDetail["district"]);
			}
			if ($JK) {
				if($this->arParams['DEPARTAMENT_ID'] == COUNTRY_DEPARTAMENT){
					$apartment = $this->getJkObjectsCards($json);
				}else{
					$apartment = $this->getJkObjectsTable($json);
				}
				$this->arResult['json']["apartments"]=$apartment;
			}
		}
		if ($this->startResultCache()) {
			if ($this->arParams['PDF'] == true) {
				$this->includeComponentTemplate("pdf");
			} elseif ($JK) {
				$this->includeComponentTemplate("complex");
			} else {
				$this->includeComponentTemplate();
			}
		}
	}

	/**
	 * Генерация доп данных для страницы и синхронизации с vue
	 *
	 * @return  void
	 */
	public function syncVue($JK)
	{
		global $APPLICATION;
		if ($JK) {
			setJsonInit('detailComplex', $this->arResult['json']);
		} else {
			setJsonInit('detailObject', $this->arResult['json']);
		}
		setJsonInit('popups/form/request_price', [
			"title" => "Запросить цену",
			"action" => "/ajax/requestPrice.php",
			"hidden" => [
				"object" => "#" . $this->arParams['ID'],
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "input",
					"name" => "name",
					"placeholder" => "Имя*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 50
						]
					]
				], [
					"type" => "input",
					"name" => "phone",
					"placeholder" => "+7 (___) ___-__-__*",
					"value" => "",
					"maskInfo" => [
						"complete" => false
					],
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 17,
							"max" => 17
						]
					]
				], [
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true
					]
				], [
					"type" => "textarea",
					"name" => "message",
					"placeholder" => "Сообщение*",
					"value" => "",
					"checked" => [
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 160
						]
					]
				]
			],
			"btnPhrase" => "Отправить заявку",
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]
		]);
		setJsonInit('popups/form/yourPrice', [
			"title" => "Предложить цену",
			"action" => "/ajax/yourPrice.php",
			"hidden" => [
				"object" => "#" . $this->arParams['ID'],
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "input",
					"name" => "name",
					"placeholder" => "Имя*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 50
						]
					]
				], [
					"type" => "input",
					"name" => "phone",
					"placeholder" => "+7 (___) ___-__-__*",
					"value" => "",
					"maskInfo" => [
						"complete" => false
					],
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 17,
							"max" => 17
						]
					]
				], [
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true
					]
				],
				[
					"type" => "input",
					"name" => "offer",
					"placeholder" => "Готов предложить*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true
					]
				]
			],
			"btnPhrase" => "Отправить заявку",
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]
		]);
		setJsonInit('popups/form/presentation', [
			"className" => "popup-form--wide",
			"picture" => [
				"sources" => [
					"mobile" => ["/assets/images/background-book.jpg"],
					"tablet" => ["/assets/images/background-book.jpg"],
					"desktop" => ["/assets/images/background-book.jpg"]
				],
				"alt" => "alt",
				"title" => "Title text"
			],
			"title" => GetMessage("getPrez"),
			"action" => "/ajax/prez.php",
			"hidden" => [
				"object" => "#" . $this->arParams['ID'],
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "input",
					"name" => "name",
					"placeholder" => GetMessage("name") . "*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 50
						]
					]
				], [
					"type" => "input",
					"name" => "phone",
					"placeholder" => "+7 (___) ___-__-__*",
					"value" => "",
					"maskInfo" => [
						"complete" => false
					],
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 17,
							"max" => 17
						]
					]
				], [
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true
					]
				]
			],
			"btnPhrase" => GetMessage("getPrez"),
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]
		]);
		setJsonInit('popups/form/presentation_complex', [
			"className" => "popup-form--wide",
			"picture" => [
				"sources" => [
					"mobile" => ["/assets/images/background-book.jpg"],
					"tablet" => ["/assets/images/background-book.jpg"],
					"desktop" => ["/assets/images/background-book.jpg"]
				],
				"alt" => "alt",
				"title" => "Title text"
			],
			"title" => GetMessage("getPrez"),
			"action" => "/ajax/prez_plan.php",
			"hidden" => [
				"object" => $this->arParams['ID'],
				"send" => ($JK) ? 'N' : 'Y',
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "input",
					"name" => "name",
					"placeholder" => GetMessage("name") . "*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 50
						]
					]
				], [
					"type" => "input",
					"name" => "phone",
					"placeholder" => "+7 (___) ___-__-__*",
					"value" => "",
					"maskInfo" => [
						"complete" => false
					],
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 17,
							"max" => 17
						]
					]
				], [
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true
					]
				]
			],
			"btnPhrase" => GetMessage("getPrez"),
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]
		]);
		setJsonInit('popups/form/writeUs', [

			"title" => GetMessage("writeUs"),
			"action" => "/ajax/write_us.php",
			"hidden" => [
				"object" => "#" . $this->arParams['ID'],
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "input",
					"name" => "name",
					"placeholder" => GetMessage("name") . "*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 50
						]
					]
				], [
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true
					]
				], [
					"type" => "input",
					"name" => "phone",
					"placeholder" => "+7 (___) ___-__-__*",
					"value" => "",
					"maskInfo" => [
						"complete" => false
					],
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"lengthString" => [
							"min" => 17,
							"max" => 17
						]
					]
				], [
					"type" => "textarea",
					"name" => "message",
					"placeholder" => GetMessage("message") . "*",
					"value" => "",
					"checked" => [
						"required" => true,
						"lengthString" => [
							"min" => 1,
							"max" => 160
						]
					]
				]
			],
			"btnPhrase" => GetMessage("send"),
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]

		]);
	}

	/**
	 * Генерация мета-данных
	 * Запрос в эластик
	 *
	 * @param   string $name Тайтл для мета и og
	 * @param   string $description Описание
	 * @param   string $zhk_main_img ссылка на изображение
	 * @param   string $keywords ключевые слова
	 *
	 * @return  void
	 */
	public function getMeta($name, $description, $zhk_main_img, $keywords)
	{
		global $APPLICATION;
		$APPLICATION->SetTitle($name);
		$APPLICATION->AddHeadString('<meta property="og:title" content="' . $name . '" />');
		$APPLICATION->AddHeadString('<meta property="og:type" content="article" />');
		$APPLICATION->AddHeadString('<meta property="og:url" content="https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurUri() . '" />');
		$APPLICATION->AddHeadString('<meta property="og:description" content="' . $description . '" />');
		if ($zhk_main_img != '') {
			$APPLICATION->AddHeadString('<meta property="og:image" content="' . $zhk_main_img . '" />');
		}
		$APPLICATION->SetPageProperty("keywords", $keywords);
		$APPLICATION->SetPageProperty("description", $description);
	}

	public function getPdfObject($json, $JK)
	{

		$static = \Idem\CIdemStatic::getInstance(true, "ru");
		$config = $this->generateData($json, $JK);
		$name = Util::generatedFields($config['titleConfig'], $json);
		$address = Util::generatedFields($config['addressConfig'], $json);
		$descObject = Util::generatedFields($config['descConfig'], $json);

		if ($json["main_img"] != '') {
			$sliderJk = explode(",", $json["main_img"]);
		} elseif ($json["zhk_main_img"] != '') {
			$sliderJk = explode(",", $json["zhk_main_img"]);
		}
		if ($sliderJk) {
			//$sliderJk = array_slice($sliderJk, 0, 9);
			$sliderJk = $sliderJk;
			$sliderJk = array_chunk($sliderJk, 3);
			$arSliderFinish = array_chunk($this->generatePictureView(array_slice($sliderJk, 1)), 2);
		}

		$resJson["characteristics"] = $resJson["characteristics"]["info"] = $this->generateRowView($json, $config['charactConfig'], true);
		$countDel=count($resJson["characteristics"])/2;
		$resJson["characteristics"]=array_chunk($resJson["characteristics"], ceil($countDel));

		if (($JK && $json["price_hidden"] != '') || $json["price_hidden_lot"] != '' || $json['price_rub']=="") {
			$price='Цена по запросу';
		}elseif(is_array($json["price_rub"]) && !empty($json["price_rub"])){
			$price="от ".number_format(min($json["price_rub"]), 0, '.', ' '). " р.";
		}else{
			$price=($json["price_rub"] != "") ? number_format($json["price_rub"], 0, '.', ' ') . " р." : '';
		}

		$resJson = [
			"header" => [
				"phone" => $static->get('contacts_' . LANGUAGE_ID . '.phone_text')
			],
			"content" => [
				[
					"type" => "gallery",
					"main" => true,
					"heading" => $name,
					"address" => $address,
					"gallery" => [
						[
							"mainImage" => ($sliderJk[0][0]) ? $sliderJk[0][0] : $this->__path . '/img/zaglushka_813х665.jpg',
							"amount" => $price,
							"costMetter" => ($json["square_price_rub"] != ""&& $json["price_hidden"] == ''&& $json["price_hidden_lot"]== '') ? number_format($json["square_price_rub"], 0, '.', ' ') . " р./м2" : ' ',
						]
					]
				], [
					"type" => "characteristics",
					"title" => "Характеристики",
					"info" => $resJson["characteristics"],
					"description" => str_replace("\n", "<br>", $descObject)
				]
			]
		];
		if ($sliderJk[0][1]) {
			$resJson["content"][0]["gallery"][0]["images"][0] = $sliderJk[0][1];
		}
		if ($sliderJk[0][2]) {
			$resJson["content"][0]["gallery"][0]["images"][1] = $sliderJk[0][2];
		}
		if ($json["parent_id"] != "") {
			$util = new Util();
			$parentObj = ObjectsTable::wakeUpObject($json["parent_id"]);
			$parentObj->fill();
			$jsonParent = $parentObj->getInfo();
			$infoParent = [
				"type" => "description",
				"heading" => $jsonParent["lot_name"],
				"description" =>  $jsonParent["zhk_description"]
			];

			if($jsonParent["area"][0]!="" && is_array($jsonParent["area"])){
				$area=[["heading"=> min($jsonParent["area"]).' - '.max($jsonParent["area"])." <span>м²</span>","phrase"=> "Площадь объектов"]];
			}

			$config = $this->generateData($jsonParent, true);
			$aboutObject = $this->generateRowView($jsonParent, $config['aboutConfig'],false,false,true);

			if($area){
				$infoParent["items"] = array_merge($area, $aboutObject);
			}else{
				$infoParent["items"] = $aboutObject;
			}
			array_push($resJson["content"], $infoParent);
		}
		if($json["parent_id"] == 0){
			$infoParent = [
				"type" => "description",
				"heading" => $json["lot_name"],
				"description" =>  str_replace("\n", "<br>", $json["zhk_description"])
			];
			if($json["area"][0]!="" && is_array($json["area"])){
				$area=[["heading"=> min($json["area"]).' - '.max($json["area"])." <span>м²</span>","phrase"=> "Площадь объектов"]];
			}

			$config = $this->generateData($json, true);
			$aboutObject = $this->generateRowView($json, $config['aboutConfig'],false,false,true);

			if($area){
				$infoParent["items"] = array_merge($area, $aboutObject);
			}else{
				$infoParent["items"] = $aboutObject;
			}
			array_push($resJson["content"], $infoParent);

		}
		/*if($json["tags"] != ''){
			array_push($resJson["content"], ["type"=> "tags","heading"=> "инфраструктура", "items"=> explode(",", $json["tags"])]);
		}*/
		$resJson["content"][count($resJson["content"])-1]["newPage"]=true;
		$isNewPage = true;
		if ($arSliderFinish) {
			foreach($arSliderFinish as $k => $arSlide){
				if($k==0){
					array_push($resJson["content"], ["newPage" => $isNewPage, "type" => "gallery", "heading" => "Все фотографии", "gallery" => $arSlide]);
				}else{
					array_push($resJson["content"], ["newPage" => $isNewPage, "type" => "gallery", "heading" => " ", "gallery" => $arSlide]);
				}
			}
		}

		if ($json["plan"] != '') {
			$planImages = explode(",", $json["plan"]);
			if (count($planImages) % 2 !== 0) {
				$planImages[] = '';
			}
			$planImages = array_chunk($planImages, 2);
			$planPicture = $this->generatePictureView($planImages, true);
			array_push($resJson["content"], ["newPage" => true, "type" => "plan", "heading" => "Планировка", "gallery" => $planPicture]);
			$isNewPage = false;
		}
		$resJson["footer"] = [
			"phone" => $static->get('contacts_' . LANGUAGE_ID . '.phone_text'),
			"address" => $static->get('contacts_' . LANGUAGE_ID . '.address_text')
		];
		return $resJson;
	}

	public function generatePictureView($array, $pdf = false)
	{
		$arSliderFinish = [];
		foreach ($array as $k => $slider) {
			if ($pdf) {
				$slider = array_merge([""], $slider);
			}
			$sliderFinish["revers"] = false;
			$sliderFinish["mainImage"] = $slider[0];
			$sliderFinish["images"] = [];
			if ($slider[1]) {
				$sliderFinish["images"][0] = $slider[1];
			}
			if ($slider[2] || $pdf == true) {
				$sliderFinish["images"][1] = $slider[2];
			}
			if (($k + 1) % 2 == 0) {
				$sliderFinish["revers"] = true;
			}
			$arSliderFinish[] = $sliderFinish;
		}
		return $arSliderFinish;
	}
	public function generateDataDetailDesc($json)
    {
        ///   Инфраструктура  ///
        $infrastructures = [];
        if ($json["department_id"] == LIVE_DEPARTAMENT) {
            if ($json["park_zone_infra"] != "" || $json["security_infra"] != "" || $json["parking_infra"] != "" || $json["concierge_infra"] != "" || $json["location_infra"] != "") {
                $resJson["infrastructure"]["tabs"] = [];
            }

            array_push($infrastructures, ["text" => "park_zone_infra", "title" => GetMessage("parkZone"), "value" => "parks", 'img' => ["sources" => ["mobile" => [($json["park_img"] != "") ? $json["park_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["park_img"] != "") ? $json["park_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["park_img"] != "") ? $json["park_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Парковая зона"]]);
            array_push($infrastructures, ["text" => "security_infra", "title" => GetMessage("safety"), "value" => "safety", 'img' => ["sources" => ["mobile" => [($json["safety_img"] != "") ? $json["safety_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["safety_img"] != "") ? $json["safety_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["safety_img"] != "") ? $json["safety_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Безопасность"]]);
            array_push($infrastructures, ["text" => "parking_infra", "title" => GetMessage("parking"), "value" => "parking", 'img' => ["sources" => ["mobile" => [($json["parking_img"] != "") ? $json["parking_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["parking_img"] != "") ? $json["parking_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["parking_img"] != "") ? $json["parking_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Парковка"]]);
            array_push($infrastructures, ["text" => "concierge_infra", "title" => GetMessage("conserj"), "value" => "concierge", 'img' => ["sources" => ["mobile" => [($json["kons_img"] != "") ? $json["kons_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["kons_img"] != "") ? $json["kons_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["kons_img"] != "") ? $json["kons_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Консьерж-сервис"]]);
            array_push($infrastructures, ["text" => "location_infra", "title" => GetMessage("locality"), "value" => "location", 'img' => ["sources" => ["mobile" => [($json["place_img"] != "") ? $json["place_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["place_img"] != "") ? $json["place_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["place_img"] != "") ? $json["place_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Расположение"]]);

        } elseif ($json["department_id"] == COUNTRY_DEPARTAMENT) {
            if ($json["education_infra"] != "" || $json["parks_ponds_infra"] != "" || $json["fitness_spa_infra"] != "" || $json["cafes_restaurants_infra"] != "") {
                $resJson["infrastructure"]["tabs"] = [];
            }

            array_push($infrastructures, ["text" => "education_infra", "title" => "Образование", "value" => "parks", 'img' => ["sources" => ["mobile" => [($json["educ_img"] != "") ? $json["educ_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["educ_img"] != "") ? $json["educ_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["educ_img"] != "") ? $json["educ_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Образование"]]);
            array_push($infrastructures, ["text" => "parks_ponds_infra", "title" => "Парки и водоемы", "value" => "safety", 'img' => ["sources" => ["mobile" => [($json["park_river_img"] != "") ? $json["park_river_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["park_river_img"] != "") ? $json["park_river_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["park_river_img"] != "") ? $json["park_river_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Парки и водоемы"]]);
            array_push($infrastructures, ["text" => "fitness_spa_infra", "title" => "Фитнес и спа", "value" => "parking", 'img' => ["sources" => ["mobile" => [($json["spa_img"] != "") ? $json["spa_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["spa_img"] != "") ? $json["spa_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["spa_img"] != "") ? $json["spa_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Фитнес и спа"]]);
            array_push($infrastructures, ["text" => "cafes_restaurants_infra", "title" => "Кафе и рестораны", "value" => "concierge", 'img' => ["sources" => ["mobile" => [($json["cafe_img"] != "") ? $json["cafe_img"] : $this->__path . '/img/zaglushka_688.jpg'], "tablet" => [($json["cafe_img"] != "") ? $json["cafe_img"] : $this->__path . '/img/zaglushka_688.jpg'], "desktop" => [($json["cafe_img"] != "") ? $json["cafe_img"] : $this->__path . '/img/default.jpg']], "alt" => "", "title" => "Кафе и рестораны"]]);
        }
        foreach ($infrastructures as $infrastructures) {
            if ($json[$infrastructures["text"]] != '') {
                array_push($resJson["infrastructure"]["tabs"], ["button" => ["text" => $infrastructures["title"], "value" => $infrastructures["value"]], "image" => $infrastructures["img"], "text" => htmlspecialcharsBack($json[$infrastructures["text"]])]);
            }
        }
        if ($resJson["infrastructure"]["tabs"]) {
            $resJson["infrastructure"]["title"] = GetMessage("infra");
        }
        if ($json["map_coords"]) {
            ///  Координаты  ////
            $resJson["map"] = [
                "title" => "на карте",
                "map" => [
                    "zoom" => 14,
                    "center" => "-28.024, 140.887",
                    "markers" => [
                        [
                            "coords" => $json["map_coords"],
                            "icon" => "/assets/svg/map-pin.svg",
                            "type" => "default",
                            "id" => "marker_1",
                        ],
                    ],
                ],
            ];
        } else {
					$resJson["map"] = false;
				}
        if ($json["department_id"] == LIVE_DEPARTAMENT || $json["department_id"] == COMMERC_DEPARTAMENT) {
            ///  Район  ////
            $arDistrict = [];
            $arSelect = ["ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_PREFFIX", "CODE"];
            $arFilter = [
                "IBLOCK_CODE" => $this->arParams['ID_BLOCK_AREA'],
                "ACTIVE" => "Y",
                "NAME" => $json["locality"],
            ];
            $res = CIBlockElement::GetList(["sort" => "asc"], $arFilter, false, false, $arSelect);
            while ($ar = $res->GetNext()) {
                $arDistrict["preTitle"] = htmlspecialcharsBack($ar['PROPERTY_PREFFIX_VALUE']);
                $arDistrict["title"] = $ar["NAME"];
                $arDistrict["text"] = htmlspecialcharsBack($ar["PREVIEW_TEXT"]);
                $arDistrict["link"] = "/gorod/rayon-" . \Cutil::translit($ar["NAME"], "ru", Intrum::TRANSLIT) . "/";
                $arDistrict["image"]["sources"]["mobile"] = [Util::cropImg($ar["PREVIEW_PICTURE"], 500, 500)];
                $arDistrict["image"]["sources"]["tablet"] = [Util::cropImg($ar["PREVIEW_PICTURE"], 1000, 800)];
                $arDistrict["image"]["sources"]["desktop"] = [Util::cropImg($ar["PREVIEW_PICTURE"], 1000, 800)];
                $arDistrict["image"]["alt"] = $ar["NAME"];
                $arDistrict["image"]["title"] = $ar["NAME"];
            }
            if (!empty($arDistrict)) {
                $resJson["district"] = $arDistrict;
            }
        }
        return $resJson;
    }

    public function getSimilar($current, $JK)
	{
		$result["tabs"] = [];
		if (is_array($current['price_rub'])) {
			$avgPrice = array_sum($current['price_rub']) / count($current['price_rub']);
		} else {
			$avgPrice = $current['price_rub'];
		}
		$deltaPrice = $avgPrice * 0.15;
		$priceMin = $avgPrice - $deltaPrice;
		$priceMax = $avgPrice + $deltaPrice;
		if(is_array($current['object_type'])==false){
			$object_type = \Cutil::translit($current['object_type'], "ru", Intrum::TRANSLIT);
		}
		$tabs = [];
		$configApi = [
			"/api/objects.php?not[id]={$current['id']}",
			"size=3",
			"department_id={$current["department_id"]}"
		];
		$configApiPrice = array_merge(
			$configApi,
			[
				"price[from]={$priceMin}",
				"price[to]={$priceMax}",
				"currency=rub",
				"range=general"
			]
		);

		if ($current["department_id"] == LIVE_DEPARTAMENT) {
			if (!$JK) {
				$configApi = array_merge($configApi, ["object_type={$object_type}"]);
			}
			$locality = \CUtil::translit($current['locality'], 'ru', Intrum::TRANSLIT);
			$configApiLocal = array_merge(
				$configApi,
				[
					"locality[]={$locality}"
				]
			);
			$configApiPrice = array_merge($configApi,$configApiPrice);
			if ($JK) {
				$result["title"] = 'мы подобрали для вас похожие жилые комплексы';
				$similar = GetMessage("simularJk");
			} else {
				$result["title"] = "Мы подобрали для вас похожие " . Util::simular_form($current['object_type']);
				$similar = GetMessage("simularObject");
				$configApiLocal = array_merge($configApiLocal, ["not[parent_id]={$current['parent_id']}"]);
			}
			$apiLocal = implode("&", $configApiLocal);
			$apiPrice = implode("&", $configApiPrice);
			array_push($tabs, ["typeProp" => $current['locality'], "text" => "В этом районе", "api" => $apiLocal]);
			array_push($tabs, ["typeProp" => $current['price_rub'], "text" => "В этом бюджете", "api" => $apiPrice]);
		}
		if ($current["department_id"] == COUNTRY_DEPARTAMENT) {
			if (!$JK) {
				$configApi = array_merge($configApi, ["object_type={$object_type}"]);
			}else{
				$configApi = array_merge($configApi, ["object_type=poselok"]);
			}
			$highway =  \CUtil::translit($current['highway'], 'ru', Intrum::TRANSLIT);
			$distanceMkadMin = ((intval($current['distance_mkad']) - 20) > 0) ? intval($current['distance_mkad']) - 20 : 0;
			$distanceMkadMax = intval($current['distance_mkad']) + 20;
			$configApiHighway = array_merge(
				$configApi,
				[
					"highway={$highway}"
				]
			);
			$configApiDistance = array_merge(
				$configApi,
				[
					"distance_mkad[from]={$distanceMkadMin}",
					"distance_mkad[to]={$distanceMkadMax}",
					"range=general"
				]
			);
			$configApiPrice = array_merge($configApi,$configApiPrice);
			$apiPrice = implode("&", $configApiPrice);
			if ($JK) {
				$result["title"] = 'мы подобрали для вас похожие посёлки';
				$similar = GetMessage("simularCountry");
			} else {
				$result["title"] = "Мы подобрали для вас похожие " . Util::simular_form($current['object_type']);
				$similar = GetMessage("simularObject");
				$configApiHighway = array_merge($configApiHighway, ["not[parent_id]={$current['parent_id']}"]);
				$configApiDistance = array_merge($configApiDistance, ["not[parent_id]={$current['parent_id']}"]);
			}
			$apiHighway = implode("&", $configApiHighway);
			$apiDistance = implode("&", $configApiDistance);
			$apiPrice = implode("&", $configApiPrice);
			array_push($tabs, ["typeProp" => $current['highway'], "text" => "В этом направлении(шоссе)", "api" => $apiHighway]);
			array_push($tabs, ["typeProp" => $current['distance_mkad'], "text" => "По удаленности от МКАД", "api" => $apiDistance]);
			array_push($tabs, ["typeProp" => $current['price_rub'], "text" => "В этом бюджете", "api" => $apiPrice]);
		}
		if ($current["department_id"] == FOREIGN_DEPARTAMENT) {
			$configApi = array_merge($configApi, ["object_type={$object_type}"]);
			$country =  \CUtil::translit($current['country'], 'ru', Intrum::TRANSLIT);
			$configApiLocal = array_merge(
				$configApi,
				[
					"country={$country}"
				]
			);
			$configApiPrice = array_merge($configApi,$configApiPrice);
			$apiPrice = implode("&", $configApiPrice);
			$result["title"] = "Мы подобрали для вас похожие " . Util::simular_form($current['object_type']);
			$similar = GetMessage("simularObject");
			if($current['parent_id']!=0){
				$configApiLocal = array_merge($configApiLocal, ["not[parent_id]={$current['parent_id']}"]);
			}

			$apiLocal = implode("&", $configApiLocal);
			array_push($tabs, ["typeProp" => $current['country'], "text" => "В этой стране", "api" => $apiLocal]);
			array_push($tabs, ["typeProp" => $current['price_rub'], "text" => "В этом бюджете", "api" => $apiPrice]);
		}
		if ($current["department_id"] == COMMERC_DEPARTAMENT) {
			if (!$JK) {
				$configApi = array_merge($configApi, ["object_type={$object_type}"]);
			}
			$locality = \CUtil::translit($current['locality'], 'ru', Intrum::TRANSLIT);
			$configApiLocal = array_merge(
				$configApi,
				[
					"locality={$locality}"
				]
			);
			$result["title"] = "Мы подобрали для вас похожие " . Util::simular_form($current['object_type']);
			$similar = GetMessage("simularObject");
			if($current['parent_id']!=0){
				$configApiLocal = array_merge($configApiLocal, ["not[parent_id]={$current['parent_id']}"]);
			}

			$apiLocal = implode("&", $configApiLocal);
			$apiPrice = implode("&", $configApiPrice);
			array_push($tabs, ["typeProp" => $current['country'], "text" => "В этом районе", "api" => $apiLocal]);
			array_push($tabs, ["typeProp" => $current['price_rub'], "text" => "В этом бюджете", "api" => $apiPrice]);
		}
		foreach ($tabs as $tab) {
			if ($tab["typeProp"] != "" && $this->counElSimular($tab["api"]) > 0) {
				$result['tabs'][] = [
					"text" => $tab["text"],
					"value" => $tab["api"]
				];
			}
		}
		$result['ajaxLink'] = '';
		if (count($result['tabs'])) {
			$parts = parse_url($result['tabs'][0]['value']);
			parse_str($parts['query'], $query);
			$res = Objects::getFilterObjects($query);
			$result['cards'] = $res['cards'];
			$rootObj = $JK ? 'detailComplex' : 'detailObject';

			setJsonInit("{$rootObj}/similar", $result);
            setJsonInit("{$rootObj}/main/similar", $similar);
        }
        return $result;
    }
    public function counElSimular($value)
	{
		$parts = parse_url($value);
		parse_str($parts['query'], $query);
		$res = Objects::getFilterObjects($query);
		return count($res['cards']);
	}
}
