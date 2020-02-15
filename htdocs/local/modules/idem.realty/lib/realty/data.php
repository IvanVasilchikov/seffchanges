<?php

namespace Idem\Realty\Realty;

use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Elasticsearch\ClientBuilder;
use Idem\Realty\Import\Intrum;

class Data
{
	const TRANSLIT = array("replace_space" => "-", "replace_other" => "-");
	const DEPARTAMENT_URL = [
		1 => LIVE_REALTY_URL,
		2 => COMMERC_REALTY_URL,
		3 => COUNTRY_REALTY_URL,
		5 => FOREIGN_REALTY_URL
	];
	public static function getNumberFormat($val)
	{
		$val = number_format($val, 0, '', ' ');
		return $val;
	}
	public function getResizeImgPath($id = 0, $arSize = [])
	{
		$file = \CFile::ResizeImageGet($id, $arSize, BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
		return $file['src'];
	}
	public static function cr_post($a,$b=0,$c=0){
			if (!is_array($a)) return false;
			foreach ((array)$a as $k=>$v){
					$cmp = (intval($k).'' == $k) ? '' : $k;
					if ($c) $k=$b."[".$cmp."]"; elseif (is_int($k)) $k=$b.$k;
					if (is_array($v)||is_object($v)) {
							$r[]=self::cr_post($v,$k,1);continue;
					}
					$r[]=urlencode($k)."=" .urlencode($v);
			}
			return implode("&",$r);
	}
	public function getExistVariables($field = "", $departamentID = 0, $retSimpleList = false, $additionalFilter = [], $filterByParentNull = false, $needLocality = false, $needCountry = false)
	{
		$cache_dir = "/exist_variables";
		$arParams = ['NAME' => $cache_dir, 'CACHE_TIME' => 36000000, 'field' => $field, 'departament' => $departamentID, 'simple_list' => $retSimpleList, 'additional_filter' => $additionalFilter, 'filter_by_parent' => $filterByParentNull, 'needLocality' => $needLocality];
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cache_id = md5(serialize($arParams));
		$arResult = [];
		if ($cache->InitCache($arParams['CACHE_TIME'], $cache_id, $cache_dir)) {
			$arResult = $cache->getVars();
		} elseif ($cache->startDataCache()) {
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache($cache_dir);
			$CACHE_MANAGER->RegisterTag("iblock_id_exist_variables");
			if (empty($field) || empty($departamentID))
				return [];

			$arResult = [];
			$this->client = ClientBuilder::create()->setHosts(['elastic'])->build();
			$indexParams = ['index' => ELASTIC_INDEX];
			if (!$this->client->indices()->exists($indexParams))
				return [];
			$sorts = [
				$field => [
					'order' => 'asc'
				],
			];

			$scoreFunctions = [];
			$term = "term";
			if (is_array($departamentID)) {
				if (count($departamentID) > 1)
					$term = "terms";
				else
					$departamentID = $departamentID[0];
			}
			$filter = [
				'bool' => [
					'filter' => [
						[
							$term => [
								"department_id" => $departamentID,
							]
						]
					],
				]
			];
			if (!empty($additionalFilter)) {
				$filter['bool']['filter'][] = $additionalFilter;
			}
			if ($filterByParentNull) {
				$filter['bool']['filter'][] = ['term' => ['parent_id' => 0]];;
			}
			$agg = [
				'group_by_' . $field => [
					'terms' => [
						'field' => $field
					]
				]
			];
			if ($needLocality) {
				$agg = [
					'group_by_district' => [
						'terms' => [
							'field' => 'district'
						],
						'aggs' => $agg,
					]
				];
			}
			if ($needCountry) {
				$agg = [
					'group_by_country' => [
						'terms' => [
							'field' => 'country'
						],
						'aggs' => $agg,
					]
				];
			}
			$params = [
				'index' => ELASTIC_INDEX,
				'type' => '_doc',
				'size' => 0,
				'body' => [
					'sort' => $sorts,
					'query' => [
						'function_score' => array(
							'functions' => $scoreFunctions,
							"score_mode" => "sum",
							'boost_mode' => 'replace',
							'query' => $filter
						),
					],
					'aggs' => $agg,
				]
			];
			$results = $this->client->search($params);
			if ($needLocality) {
				$results['aggregations']['group_by_' . $field]['buckets'] = [];
				foreach ($results['aggregations']['group_by_district']['buckets'] as $district) {
					$district['group_by_' . $field]['buckets'] = array_map(function ($metro) use ($district) {
						$metro['district'] = $district['key'];
						return $metro;
					}, $district['group_by_' . $field]['buckets']);
					$results['aggregations']['group_by_' . $field]['buckets'] = array_merge($results['aggregations']['group_by_' . $field]['buckets'], $district['group_by_' . $field]['buckets']);
				}
				$results['aggregations']['group_by_' . $field]['buckets'];
			}
			if ($needCountry) {
				$results['aggregations']['group_by_' . $field]['buckets'] = [];
				foreach ($results['aggregations']['group_by_country']['buckets'] as $country) {
					$country['group_by_' . $field]['buckets'] = array_map(function ($metro) use ($country) {
						$metro['country'] = $country['key'];
						return $metro;
					}, $country['group_by_' . $field]['buckets']);
					$results['aggregations']['group_by_' . $field]['buckets'] = array_merge($results['aggregations']['group_by_' . $field]['buckets'], $country['group_by_' . $field]['buckets']);
				}
				$results['aggregations']['group_by_' . $field]['buckets'];
			}
			$arTempData = $results['aggregations']['group_by_' . $field]['buckets'];
			foreach ($arTempData as $tempData) {
				if (!empty($tempData['key'])) {
					if ($retSimpleList) {
						$arResult[] = $tempData['key'];
					} else {
						$name = $tempData['key'];
						$tmp = [
							'NAME' => $name,
							'CODE' => \Cutil::translit($name, "ru", self::TRANSLIT)
						];
						if ($needLocality) {
							$tmp['DISTRICT'] = \Cutil::translit($tempData['district'], "ru", self::TRANSLIT);
						}
						if ($needCountry) {
							$tmp['COUNTRY'] = \Cutil::translit($tempData['country'], "ru", self::TRANSLIT);
						}
						$arResult[] = $tmp;
					}
				}
			}
			usort($arResult, "compareByName");
			$CACHE_MANAGER->EndTagCache();
			$cache->endDataCache($arResult);
		}
		return $arResult;
	}

	public static function getEntityDataByFilter($entityClass = "", $arFilter, $multiple = false, $order = true)
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheTime = 3600 * 2;
		$cache_dir = '/getEntityDataByFilter';
		$arResult = [];
		$arCache = ['func' => $cache_dir, 'cache_time' => $cacheTime, 'entity' => $entityClass, 'multiple' => $multiple, 'filter' => $arFilter];
		$cache_id = md5(serialize($arCache));
		if ($cache->initCache($cacheTime, $cache_id, $cache_dir)) {
			$arResult = $cache->getVars();
		} elseif ($cache->startDataCache()) {
			$arParams = [
				'select' => array('*'),
				'filter' => $arFilter,
				'order' => ["NAME" => "ASC"],
			];
			if ($entityClass == "Idem\Realty\Core\Departament\DepartamentTable")
				$arParams["order"] = ["ID" => "ASC"];
			if (!$order)
				unset($arParams['order']);
			$resVal = $entityClass::getList($arParams);


			while ($arValue = $resVal->fetch()) {
				if (!$multiple)
					$arResult = $arValue;
				else
					$arResult[] = $arValue;
			}

			$cache->endDataCache($arResult);
		}
		return $arResult;
	}

	public function getLocations()
	{
		Loader::includeModule('iblock');
		$arResult = [];
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheTime = '3600';
		$cacheId = "arDistrictsDataList";
		$cacheDir = 'arDistrictsDataList';
		if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
			$arResult = $cache->getVars();
		} elseif ($cache->startDataCache()) {
			$arSelect = ["NAME"];
			$arFilter = array("IBLOCK_CODE" => "areas_ru", "ACTIVE" => "Y");
			$res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
			while ($ob = $res->GetNext()) {
				$arResult[] = [
					"text" => $ob['NAME'],
					"url" => "/gorod/rayon-" . \Cutil::translit($ob["NAME"], "ru", Intrum::TRANSLIT) . "/"
				];
			}
			$cache->endDataCache($arResult);
		}
		return $arResult;
	}


	public static function getFromElasticParentData($id = [])
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheTime = 3600 * 2;
		$cache_dir = '/getFromElasticParentData';
		$arResult = [];
		$arCache = ['func' => $cache_dir, 'cache_time' => $cacheTime, 'id' => $id];
		$cache_id = md5(serialize($arCache));
		if ($cache->initCache($cacheTime, $cache_id, $cache_dir)) {
			$arResult = $cache->getVars();
		} elseif ($cache->startDataCache()) {
			$client = ClientBuilder::create()->setHosts(['elastic'])->build();
			if (count($id) == 1)
				$arFilter = ['term' => ['_id' => (int) $id[0]]];
			else
				$arFilter = ['terms' => ['_id' => $id]];
			$params = [
				'index' => ELASTIC_INDEX,
				'type' => '_doc',
				'size' => 15,
				'from' => 0,
				'body' => [
					'sort' => [
						'_id' => [
							'order' => 'desc'
						],
					],
					'query' => [
						'function_score' => array(
							'functions' => [],
							"score_mode" => "sum",
							'boost_mode' => 'replace',
							'query' => [
								'bool' => [
									'filter' => $arFilter
								]
							]
						),
					]
				]
			];
			$arData = $client->search($params);
			foreach ($arData['hits']['hits'] as $arObject) {
				$arResult[$arObject['_id']] = $arObject['_source'];
			}

			$cache->endDataCache($arResult);
		}
		return $arResult;
	}

	public function getRealtyTypes()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheTime = 3600 * 2;
		$cache_dir = '/realty_types';
		$arRealtyTypes = [];
		$arCache = ['func' => $cache_dir, 'cache_time' => $cacheTime,];
		$cache_id = md5(serialize($arCache));
		if ($cache->initCache($cacheTime, $cache_id, $cache_dir)) {
			$arRealtyTypes = $cache->getVars();
		} elseif ($cache->startDataCache()) {
			$realtyTypes = new RealtyTable();
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache($cache_dir);
			$CACHE_MANAGER->RegisterTag(ToLower('Idem\Realty\Core\Type\Realty\RealtyTable'));

			$arRealtyTypes = [];
			$resVal = $realtyTypes::getList([
				'select' => array('*'),
			]);

			while ($arValue = $resVal->fetch()) {
				if (!isset($arValue['UF_NAME'])) {
					$arRealtyTypes[$arValue['ID']] = $arValue['NAME'];
				} else
					$arRealtyTypes[$arValue['ID']] = $arValue['UF_NAME'];
			}

			$CACHE_MANAGER->EndTagCache();
			$cache->endDataCache($arRealtyTypes);
		}
		return $arRealtyTypes;
	}



	public function getMultipleFieldData($entity = "", $parentId = 0)
	{
		if (!$parentId || empty($entity))
			return [];
		$arData = [];
		$arIds = [];
		$resVal = $entity::getList([
			'filter' => array('PARENT_ID' => $parentId),
			'select' => array('*'),
		]);
		while ($arValue = $resVal->fetch()) {
			$arIds[] = $arValue['TYPE_ID'];
		}

		if (count($arIds) > 0) {
			$arFields = $this->getRefFieldsByEntity($entity);
			if (array_key_exists('TYPE_ID', $arFields)) {
				$refEntity = $arFields['TYPE_ID'];
				$nameField = $this::getNameFieldByEntity($refEntity);
				$sortField = $this::getSortFieldByEntity($refEntity);
				$refRes = $refEntity::getList([
					'filter' => array('ID' => $arIds),
					'select' => array('*'),
					'order' => array($sortField => 'ASC'),
				]);
				while ($arRefValue = $refRes->fetch()) {
					$arData[] = $arRefValue[$nameField];
				}
			}
		}
		return $arData;
	}

	public function getRefFieldsByEntity($entityTable)
	{
		$fieldsMap = $entityTable::getMap();
		$arFields = [];
		foreach ($fieldsMap as &$fieldObj) {
			$data_type = self::GetFieldType($fieldObj);
			if ($data_type == 'reference') {
				$class = $fieldObj->getRefEntity()->getDataClass();
				$arTempRef = $fieldObj->getReference();
				reset($arTempRef);
				$tempKey = key($arTempRef);
				$arTempKey = explode('=this.', $tempKey);
				$field = $arTempKey[1];
				$arFields[$field] = $class;
			}
		}
		return $arFields;
	}


	public static function GetFieldType(Entity\Field $field)
	{
		if ($field instanceof Entity\IntegerField)
			return 'integer';
		if ($field instanceof Entity\DatetimeField)
			return 'datetime';
		if ($field instanceof Entity\DateField)
			return 'date';
		if ($field instanceof Entity\BooleanField)
			return 'boolean';
		if ($field instanceof Entity\FloatField)
			return 'float';
		if ($field instanceof Entity\EnumField)
			return 'enum';
		if ($field instanceof Entity\TextField)
			return 'text';
		if ($field instanceof Entity\StringField)
			return 'string';
		if ($field instanceof Entity\ExpressionField)
			return 'expression';
		if ($field instanceof Entity\ReferenceField)
			return 'reference';
	}





	/**
	 * Получение заданных SEO правил
	 *
	 * @return  array  Запись из БД
	 */

	public function searchSeoData($url)
	{
		$connection = \Bitrix\Main\Application::getConnection();
		$url = str_replace("index.php", "", $url);
		$arUrl = array_filter(explode("/", $url));
		$res = [];
		for ($x = 0; $x < count($arUrl); $x++) {
			$res[$x] = ($x == 0) ? '/' . $res[$x] . $arUrl[$x + 1] . "/" : $res[$x - 1] . $arUrl[$x + 1] . "/";
		}
		krsort($res);
		$sqlResult = [];
		foreach ($res as $el) {
			if (!empty($sqlResult)) {
				continue;
			}
			$sqlFilter = " WHERE LINK ='" . $el . "'";
			$sqlResult = $connection->query('select INFO from i_seo' . $sqlFilter)->fetchAll();
		}
		$result = json_decode($sqlResult[0]["INFO"], true);
		return $result;
	}
	public function nameParent($id)
	{
		$connection = \Bitrix\Main\Application::getConnection();
		$sqlResult = $connection->query('select INFO from i_objects WHERE ID ='.$id)->fetchAll();
		$result = json_decode($sqlResult[0]["INFO"], true);
		return $result["lot_name"];
	}

	public function searchExistDetail($id = 0)
	{
		$res = false;
		if (!$id)
			return $res;
		$arSearch = $this->getEntityDataByFilter("Idem\Realty\Core\Objects\ObjectsTable", ['ID' => $id], false, false);
		if (!empty($arSearch))
			$res = true;

		return $res;
	}

	public function getSeoLinks($arShowFieds = ['locality'],$type_object='',$depart=1)
	{
		$arUrl=[
			LIVE_DEPARTAMENT=>LIVE_REALTY_URL,
			COMMERC_DEPARTAMENT=>COMMERC_REALTY_URL,
			COUNTRY_DEPARTAMENT=>COUNTRY_REALTY_URL,
			FOREIGN_DEPARTAMENT=>FOREIGN_REALTY_URL
		];
		$data = new Data();

		$res = \Idem\CIdemStatic::getInstance();
		$arResult = [
			"items" => []
		];
		if($type_object!=''){
			$typeObjUrl='/' .$type_object;
		}else{
			$typeObjUrl='';
		}

		if (in_array('metro', $arShowFieds)) {
			if($type_object!=''){
				$metroFilter = [
					'term' => [
						"translit_object_type" => $type_object
					]
				];

			}
			$arTempMetro = $data->getExistVariables("metro", $depart, false, $metroFilter, true, true);
			$arMetro = [];
			foreach ($arTempMetro as $key => $arData) {
				$arMetro[$arData['CODE']] = [
					'text' => $arData['NAME'],
					'url' => '/'.$arUrl[$depart].'/sale'. $typeObjUrl . '/' . $arData['DISTRICT'] . '/metro-' . $arData['CODE'] . '/'
				];
			}
			$arResult['items'][] = [
				"titleBtn" => $res->get('main_' . LANGUAGE_ID . '.seo_flats_title'),
				"title" => $res->get('main_' . LANGUAGE_ID . '.seo_metro_title'),
				"items" => $arMetro,
				"btnOpen" => $res->get('main_' . LANGUAGE_ID . '.seo_metro_more_title')
			];
		}
		if (in_array('locality', $arShowFieds)) {
			if($type_object!=''){
				$localityFilter = [
					'term' => [
						"translit_object_type" => $type_object,
					]
				];
			}
			$arTempLocations = $data->getExistVariables("locality", $depart, false, $localityFilter, true, true);
			$arLocality = [];
			foreach ($arTempLocations as $key => $arData) {
				$arLocality[$arData['CODE']] = [
					'text' => $arData['NAME'],
					'url' => '/'.$arUrl[$depart].'/sale' . $typeObjUrl . '/' . $arData['DISTRICT'] . '/rayon-' . $arData['CODE'] . '/'
				];
			}
			$arResult['items'][] = [
				"titleBtn" => $res->get('main_' . LANGUAGE_ID . '.seo_flats_title'),
				"title" => $res->get('main_' . LANGUAGE_ID . '.seo_locality_title'),
				"items" => $arLocality,
				"btnOpen" => $res->get('main_' . LANGUAGE_ID . '.seo_locality_more_title')
			];
		}
		if (in_array('district', $arShowFieds)) {
			if($type_object!=''){
				$districtFilter = [
					'term' => [
						"translit_object_type" => $type_object,
					]
				];
			}
			$arTempDistrict = $data->getExistVariables("district", $depart, false, $districtFilter, false, false);
			$arDistrict = [];
			foreach ($arTempDistrict as $key => $arData) {
				$arDistrict[$arData['CODE']] = [
					'text' => $arData['NAME'],
					'url' => '/'.$arUrl[$depart].'/sale' . $typeObjUrl . '/' . $arData['CODE']. '/'
				];
			}
			$arResult['items'] = $arDistrict;
		}

		if (in_array('highway', $arShowFieds)) {
			$arTempHighway = $data->getExistVariables("highway", 3, false, [], true, true);
			$arHighways = [];
			foreach ($arTempHighway as $key => $arData) {
				$arHighways[$arData['CODE']] = [
					'text' => $arData['NAME'] . ' шоссе',
					'url' => '/'.$arUrl[$depart].'/sale' . $typeObjUrl.'/'. $arData['CODE'] . '-shosse/'
				];
			}
			$arResult['items']= $arHighways;
		}

		return $arResult;
	}

	public static function createUrl($request, $params = [])
	{
		if (empty($request) && !empty($params)) {
			foreach (['department_id', 'object_type', 'tags', 'id','deal_type','parent_id','highway','country','city','isJk','lot_name'] as $field) {
				if (array_key_exists($field, $params)) {
					if (is_array($params[$field])) {
						$params[$field] = $params[$field][0];
					}
					$request[$field] = $params[$field];
				}
			}
		}

		/** Массив служебных полей которые не должны отображаться клиенту */
		$notViewParams = ['sessid_id', 'deal_type', 'parent_id', 'department_id','isJk'];
		$type = '';
		$nameParent = '';
		if ($request['department_id']) {
			$type = '/' . self::DEPARTAMENT_URL[$request['department_id']];
		}
		if ($request['deal_type']) {
			$dealType = '/' . $request['deal_type'];
		}
		if ($request['object_type']) {
			$subType = '/' . \Cutil::translit($request['object_type'], "ru", Intrum::TRANSLIT);
		}
		if ($request['parent_id']) {
			$nameParent = \Cutil::translit(Data::nameParent($request['parent_id']), "ru", Intrum::TRANSLIT).'-';
		}
		if ($request['isJk']==1) {
			$nameParent = \Cutil::translit($request['lot_name'], "ru", Intrum::TRANSLIT).'-';
		}
		if ($request['district'] && count($request['district'])==1) {
			$nameDistrict = '/'.\Cutil::translit($request['district'][0], "ru", Intrum::TRANSLIT);
			array_push($notViewParams, "district");
		}
		if ($request['locality'] && count($request['locality'])==1) {
			$nameLocality = '/rayon-'.\Cutil::translit($request['locality'][0], "ru", Intrum::TRANSLIT);
			$connection = \Bitrix\Main\Application::getConnection();
			$dataDistr =  $connection->query("select * from i_locality_district WHERE locality='".$request['locality'][0]."'")->fetch();
			if ($nameDistrict != $dataDistr["district"]) {
				$nameDistrict = '/'.$dataDistr["district"];
				array_pop($notViewParams);
			}
			array_push($notViewParams, "locality");
		}
		if ($request['metro'] && count($request['metro'])==1) {
			$nameMetro = '/metro-'.\Cutil::translit($request['metro'][0], "ru", Intrum::TRANSLIT);
			array_push($notViewParams, "metro");
			if($nameDistrict == false){
				$connection = \Bitrix\Main\Application::getConnection();
				$dataDistr =  $connection->query("select * from i_metro_district WHERE metro='".$request['metro'][0]."'")->fetch();
				$nameDistrict = '/'.$dataDistr["district"];
				array_push($notViewParams, "district");
			}
		}
		if ($request['highway']) {
			if(is_array($request['highway']) && count($request['highway'])==1){
				$nameHighway = '/'.\Cutil::translit($request['highway'][0], "ru", Intrum::TRANSLIT).'-shosse';
				array_push($notViewParams, "highway");
			}elseif(is_array($request['highway'])==false){
				$nameHighway = '/'.\Cutil::translit($request['highway'], "ru", Intrum::TRANSLIT).'-shosse';
			}
		}
		if ($request['country']) {
			if(is_array($request['country']) && count($request['country'])==1){
				$nameCountry = '/'.\Cutil::translit($request['country'][0], "ru", Intrum::TRANSLIT);
				array_push($notViewParams, "country");
			}elseif(is_array($request['country'])==false){
				$nameCountry = '/'.\Cutil::translit($request['country'], "ru", Intrum::TRANSLIT);
			}
		}
		if ($request['city']) {
			if(is_array($request['city']) && count($request['city'])==1){
				$nameCity = '/'.\Cutil::translit($request['city'][0], "ru", Intrum::TRANSLIT);
				array_push($notViewParams, "city");
				if($nameCountry == false){
					$connection = \Bitrix\Main\Application::getConnection();
					$dataCountry =  $connection->query("select * from i_city_country WHERE city='".$request['city'][0]."'")->fetch();
					$nameCountry = '/'.$dataCountry["country"];
					array_push($notViewParams, "country");
				}
			}elseif(is_array($request['city'])==false){
				$nameCity = '/'.\Cutil::translit($request['city'], "ru", Intrum::TRANSLIT);
			}
		}
		$url = "${type}${dealType}${subType}";
		if($request["department_id"]==FOREIGN_DEPARTAMENT){
			$url = "${type}${dealType}${subType}${nameCountry}${nameCity}";
		}elseif($request["department_id"]==COUNTRY_DEPARTAMENT){
			$url = "${type}${dealType}${subType}${nameHighway}";
		}elseif($request["department_id"]==LIVE_DEPARTAMENT || $request["department_id"]==COMMERC_DEPARTAMENT){
			$url = "${type}${dealType}${subType}${nameDistrict}${nameLocality}${nameMetro}";
		}else{
			$url = "${type}${dealType}${subType}";
		}
		/** Логика новостроек */
		if ($request['tags']) {
			if (is_array($request['tags'])) {
				$tag = array_shift($request['tags']);
			} else {
				$tag = $request['tags'];
				unset($request['tags']);
			}
			$url = $type . '/' . $tag;

			if($request['object_type']){
				$url = $type . $subType . '/' . $tag;
				$notViewParams = array_merge($notViewParams, ['object_type']);
			}
		} else {
			$notViewParams = array_merge($notViewParams, ['object_type']);
		}

		/**  Логика для получения ссылки на детальные страницы */
		if ($request['id']) {
				$url = $type .$dealType.'/'.$nameParent.'ID' . $request['id'] . '/';
				if($type=="/zagorod"){
					$url = $type .$dealType.$nameHighway.'/'.$nameParent.'ID' . $request['id'] . '/';
					if($request['isJk']){
						$url = $type .'/poselok'.$nameHighway.'/'.$nameParent.'ID' . $request['id'] . '/';
					}
				}
				if($type=="/foreign-real-estate"){
					$url = $type .$dealType.$nameCountry.$nameCity.'/ID' . $request['id'] . '/';
				}
		} else {
			$url .= '/';
			$diffParams = array_diff_key($request, array_flip($notViewParams));
			$tmp = [];
			foreach($diffParams as $key => $value) {
				if ($value != CURRENCY_CATALOG && $value != ORDER_CATALOG && $value != ORDER_CATALOG_JK && $value != PAGE_CATALOG && $value != RANGE_CATALOG) {
					if (!empty($value)) {
						$tmp[$key] = $value;
					}
				}
			}
			$diffParams = $tmp;
			unset($tmp);
			if (!empty($diffParams)) {
				$url .= '?' . self::cr_post($diffParams);
			}
		}
		return $url;
	}

	/**
	 * Получение вариантов значения по полю
	 *
	 * @param   int  $departamentId     департамент
	 * @param   string  $code     код поля для которого получить варианты
	 * @param   array  $dFilter  фильтр для уточнения запроса (необходимо для деталок)
	 *
	 * @return  array            Варианты поля
	 */
	public static function getGroupByField($departamentId, $code, $dFilter = false)
	{
		$client = ClientBuilder::create()->setHosts(['elastic'])->build();
		$indexParams = ['index' => ELASTIC_INDEX];
		if (!$client->indices()->exists($indexParams))
			return [];
		$sorts = [
			$code => [
				'order' => 'desc'
			],
		];
		$filter = array('match_all' => new \stdClass());
		if ($departamentId && $dFilter == false) {
			$filter = [
				'bool' => [
					'filter' => [
						[
							'term' => ["department_id" => $departamentId],
						],
						[
							'term' => ["active" => 1]
						]
					]
				]
			];
		} else {
			if ($dFilter) {
				$filter = [
					'bool' => $dFilter
				];
			}
		}
		$params = [
			'index' => ELASTIC_INDEX,
			'type' => '_doc',
			'size' => 0,
			'body' => [
				'sort' => $sorts,
				'query' => $filter,
				'aggs' => [
					'group_field' => [
						'terms' => [
							'field' => $code
						]
					]
				]
			]
		];
		$elasticRequest = $client->search($params);
		$result = [];
		foreach ($elasticRequest['aggregations']['group_field']['buckets'] as $item) {
			if (!empty($item['key'])) {
				$result[] = [
					"text" => $item['key'],
					"value" => \CUtil::translit($item['key'], 'ru', Intrum::TRANSLIT)
				];
			}
		}
		return $result;
	}
}
