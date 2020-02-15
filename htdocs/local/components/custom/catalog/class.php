<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Idem\Realty\Realty\Data;
use Elasticsearch\ClientBuilder;
use app\Util\Util;
use app\Util\Convert;
use app\Util\RuleSeoList;

class Catalog extends CBitrixComponent
{
	const arSeoFields = ['object_type', 'built_status', 'parking', 'deal_type', 'finish_type', 'country_type', 'foreign_type', 'commerc_type', 'built_type', 'water', 'forest', 'transport_ring', 'district', 'country'];
	const NAME_CATEGORY = [
		1 => "Городская",
		2 => "Коммерческая",
		3 => "Загородная",
		5 => "Зарубежная"
	];
	/**
	 * Генерация хлебных крошек
	 *
	 * @param   array $arBreadCrumbs Массив крошек
	 *
	 * @return  array Представление крошек для верстки
	 */
	public function breadCrumbsFormat($arBreadCrumbs)
	{
		$arData = [];
		foreach ($arBreadCrumbs as $arBreadCrumb) {
			$arData[] = [
				'title' => $arBreadCrumb['TITLE'],
				'href' => $arBreadCrumb['LINK']
			];
		}

		return $arData;
	}

	/**
	 * Запрос в эластик
	 *
	 * @param   array $filter Фильтр для запроса
	 * @param   integer $size Кол-во элементов
	 * @param   array $sorts Сортировки необходимые
	 * @param   integer $page Нужная страница
	 *
	 * @return  array           Ответ эластика
	 */
	public function elasticRequest($filter, $size, $sorts, $page, $group = false)
	{
		if ($_REQUEST['debug']) {
			dump($filter);
		}
		$client = ClientBuilder::create()->setHosts(['elastic'])->build();

		$indexParams = ['index' => ELASTIC_INDEX];

		if (!$client->indices()->exists($indexParams))
			return false;

		$params = [
			'index' => ELASTIC_INDEX,
			'type' => '_doc',
			'body' => [
				'sort' => $sorts,
				'query' => array('match_all' => new \stdClass())
			]
		];
		if ($group) {
			$params['body']['aggs'] = $group;
		}
		if ($size) {
			$params['size'] = $size;
			$params['from'] = (intval($page) ? intval($page) - 1 : 0) * $size;
		} else {
			$params['size'] = 10000;
		}
		if ($filter) {
			$params['body']['query'] = $filter;
		}
		$result = $client->search($params);
		if ($_REQUEST['debug']) {
			dump($result);
		}
		foreach ($result['hits']['hits'] as &$arObject) {
			$arObject['_source'] = Convert::fromElasticFields($arObject['_source']);
		}
		unset($arObject);
		return $result;
	}

	/**
	 * Получение заданных SEO правил
	 *
	 * @return  array  Запись из БД
	 */
	public function searchSeo()
	{
		$arSqlReq = [];
		$sqlFilter = " WHERE LINK LIKE '/catalog/" . Data::DEPARTAMENT_URL[$this->departmentID] . "/?";

		foreach ($this->request as $field => $val) {
			if (in_array($field, self::arSeoFields)) {
				$arSqlReq[] = $field . '=' . $val;
			}
		}

		if (!empty($arSqlReq)) {
			sort($arSqlReq);
			$sqlFilter .= implode('&', $arSqlReq) . "'";
		} else
			$sqlFilter .= "'";

		$connection = \Bitrix\Main\Application::getConnection();
		$result = $connection->query('select ID from i_seo' . $sqlFilter)->fetchAll();
		return $result;
	}

	public function tease($body, $sentencesToDisplay = 2)
	{
		$result = $body;
		if ($body) {
			$bodytag = str_ireplace("\n", " ",$body);
			$string_new = substr($bodytag, 0, 170);
			$string = $string_new;
			if ($string != $bodytag) {
				$string = rtrim($string, "!,.-");
				$result = $string . "… ";
			}
		}
		return $result;
	}

	public function subText($string, $limit)
	{
		$string = strip_tags($string);
		$string = substr($string, 0, $limit);
		$string = rtrim($string, "!,.-");
		$string = substr($string, 0, strrpos($string, ' '));
		return $string . "… ";
	}

	/**
	 * Генерация SEO параметров на основе заполнения и автогенерации
	 *
	 * @return  array  Сгенерированные параметры
	 */
	public function createSeoParams($requestElastic = false)
	{
		global $APPLICATION;
		$arSeoData = [
			"title" => "",
			"description" => "",
			"keywords" => "",
			"title_page" => "",
			"title_text_seo" => "",
			"text_seo" => "",
		];
		$arSeoDataDb = Data::searchSeoData($APPLICATION->GetCurUri());
		if ($arSeoDataDb) {
			if (!empty($arSeoDataDb['seo_title']))
				$arSeoData['title'] = $arSeoDataDb['seo_title'];
			if (!empty($arSeoDataDb['seo_description']))
				$arSeoData['description'] = $arSeoDataDb['seo_description'];
			if (!empty($arSeoDataDb['seo_keywords']))
				$arSeoData['keywords'] = $arSeoDataDb['seo_keywords'];
			if (!empty($arSeoDataDb['seo_page']))
				$arSeoData['title_page'] = $arSeoDataDb['seo_page'];
			if (!empty($arSeoDataDb['seo_title_text']))
				$arSeoData['title_text_seo'] = $arSeoDataDb['seo_title_text'];
			if (!empty($arSeoDataDb['seo_text']))
				$arSeoData['text_seo'] = $arSeoDataDb['seo_text'];
		}

		if (empty($arSeoData['title']) || empty($arSeoData['description']) || empty($arSeoData['keywords'])) {
			$arJsonData = [];
			foreach ($this->request as $field => $val) {
				// if (in_array($field, self::arSeoFields)) {
				$arJsonData[$field] = $val;
				// }
			}
			if ($this->request['tags'] && array_search(NOVOSTROIKA_CODE, $this->request['tags']) !== false) {
				$arJsonData['object_type'] = NOVOSTROIKA_CODE;
			}
			if ($requestElastic) {
					$count = Util::plural_form($requestElastic['hits']['total']['value'], ['предложение', 'предложения', 'предложений']);
			}
			$createSeoData = RuleSeoList::getSeoData($this->request, $this->departmentID, false,$count);

			if (empty($arSeoData['title']))
				$arSeoData['title'] = $createSeoData['seo_title'];
			if (empty($arSeoData['description']))
				$arSeoData['description'] = $createSeoData['seo_description'];
			if (empty($arSeoData['keywords']))
				$arSeoData['keywords'] = $createSeoData['seo_keywords'];
			if (empty($arSeoData['title_page']))
				$arSeoData['title_page'] = $createSeoData['seo_page'];
		}
		return $arSeoData;
	}

	/**
	 * Получение объектов
	 *
	 * @return  array  json данные каталога
	 */
	public function getObjectsData()
	{
		global $APPLICATION;
		$arResult = [
			'cards' => [],
			'pagination' => [],
			'requiesData' => [],
			"url" => Data::createUrl($this->request)
		];
		/** Подготовка для сортировки */
		$sorts = [];
		$orders = ['area|desc', 'area|asc','area_building|desc', 'area_building|asc','area_weaving|desc', 'area_weaving|asc', 'sort_date_update|desc', 'price_rub|desc', 'price_rub|asc'];
		if ($this->request['order'] && in_array($this->request['order'], $orders)) {
			$arTempSort = explode('|', $this->request['order']);
			$field = $arTempSort[0];
			$order = $arTempSort[1];
			$sorts[$field] = ['unmapped_type' => 'long', 'order' => $order];
			if($field != 'sort_date_update'){
				$sorts['sort_date_update'] = ['order' => 'desc'];
			}

		} else {
			if($this->request["object_type"]!="poselok" && $this->request["department_id"]==COUNTRY_DEPARTAMENT){
				$sorts['top9'] = ['order' => 'asc'];
				$sorts['sort_date_update'] = ['order' => 'desc'];
			}else{
				$sorts['top9jk'] = ['order' => 'asc'];
				$sorts['sort_date_update'] = ['order' => 'desc'];
			}
		}
		if($this->arParams["SORT"]){
			$parSort = $this->arParams["SORT"];
			$sorts[$parSort["name"]] = ['order' => $parSort["order"]];
		}
		if ($this->request['sortField'] && $this->request['sortDirection']) {
			$sorts = [$this->request['sortField'] => ['unmapped_type' => 'long', 'order' => $this->request['sortDirection']]];
		}
		/** Подготовка размерности страницы */
		$size = $this->request['size'] ? $this->request['size'] : 17;

		if ($this->request['all_count'] === '1') {
			$size = false;
			unset($this->arParams['LIMIT']);
		}

		if (isset($this->arParams['LIMIT']) && $this->arParams['LIMIT'])
			$size = $this->arParams['LIMIT'];

		/** Подготовка страницы */
		$currentPage = intval($this->request['page']) ? intval($this->request['page']) : 1;
		$isReplace = false;
		foreach($this->arParams['FILTER']['bool']['filter'] as $item) {
			if (isset($item['term']['parent_id']) && $item['term']['parent_id'] == 0) {
				$isReplace = true;
			}
		}
		$elementView = (
			($this->departmentID == COUNTRY_DEPARTAMENT && $this->request['object_type'] !== 'poselok' && $this->request['object_type']!=false) ||
			($this->departmentID == LIVE_DEPARTAMENT && in_array("vtorichka", $this->request['tags']) && !is_null($this->request['tags']) && count($this->request['tags'])==1) ||
			$this->departmentID == FOREIGN_DEPARTAMENT);
		$onlyJk = ($this->departmentID == COUNTRY_DEPARTAMENT && $this->request['object_type'] === 'poselok');
		if ($isReplace) {
			if ($this->departmentID == COUNTRY_DEPARTAMENT && $this->request['object_type'] === 'poselok') {
				$this->arParams['FILTER'] = $this->changeFilter($this->arParams['FILTER'], ['translit_object_type' => '']);
			}
			$filter = $this->changeFilter($this->arParams['FILTER'], ['parent_id' => ''],['isJk'=>1]);
			if(!$elementView && !$onlyJk && $this->departmentID == COUNTRY_DEPARTAMENT){
				$this->arParams['FILTER'] = $this->changeFilter($this->arParams['FILTER'], ['parent_id' => '']);
			}
			if ($elementView) {
				$this->arParams['FILTER'] = $filter;
			} else{
				$resGroupById = $this->elasticRequest($filter,1,[],1, ['group_parent'=>[
					'terms'=>['field'=>'parent_id', 'size'=>10000]
				]]);
				$child = $resGroupById;
				$tmp = [];
				foreach($resGroupById['aggregations']['group_parent']['buckets'] as $res) {
					if ($res['key'] != 0) {
						$tmp[] = $res['key'];
					}
				}
				$mainFilter = $this->changeFilter($this->arParams['FILTER'], [] , ['isJk'=>1]);
				$mainFilter = ['bool' => [
					'should' => [
						($onlyJk ? null : ['bool'=>$mainFilter['bool']]),
						['terms'=>['_id' => $tmp ? $tmp : []]],
					],
					"minimum_should_match"=> 1
				]];
			}
		}
		if (!$mainFilter) {
			$mainFilter = $this->arParams['FILTER'];
		}
		$results = $this->elasticRequest($mainFilter, $size, $sorts, $currentPage);
		if (!$child) {
			$child = $results;
		}
		if ($results) {
			foreach ($results['hits']['hits'] as $arObject) {
				$arResult['cards'][] = $this->generateView($arObject, $this->request['currency'] ? $this->request['currency'] : 'rub');
			}

			if ($size) {
				$arResult['pagination'] = [
					"current" => $currentPage,
					"count" => ceil($results['hits']['total']['value'] / $size),
					'total' => $child['hits']['total']['value'],
					"objects_count" => LANGUAGE_ID == 'ru' ? Util::plural_form($child['hits']['total']['value'], ['предложение', 'предложения', 'предложений']) : Util::plural_form($child['hits']['total']['value'], ['offer', 'offers', 'offers']),
					"url" => $APPLICATION->GetCurDir(),
					"param" => "page"
				];
			}
		}
		$arResult['mapUrl']="/map/?type_page=".LIVE_DEPARTAMENT;
		if($this->departmentID == COUNTRY_DEPARTAMENT){
			$arResult['mapUrl']="/map/?type_page=".COUNTRY_DEPARTAMENT;
		}
		if($this->departmentID == COMMERC_DEPARTAMENT){
			$arResult['mapUrl']="/map/?type_page=".COMMERC_DEPARTAMENT;
			if($this->request["object_type"]==COMMERC_OFFICE){
				$arResult['mapUrl']="/map/?type_page=".COMMERC_OFFICE;
			}elseif($this->request["object_type"]==COMMERC_SKLAD){
				$arResult['mapUrl']="/map/?type_page=".COMMERC_SKLAD;
			}elseif($this->request["object_type"]==COMMERC_TORG){
				$arResult['mapUrl']="/map/?type_page=".COMMERC_TORG;
			}			
		}
		if($this->departmentID == FOREIGN_DEPARTAMENT){
			$arResult['mapUrl']="/map/?type_page=".FOREIGN_DEPARTAMENT;
		}
		$arResult['seo'] = $this->createSeoParams($child);
		$arResult['seo']["items"] = $this->getSeoLinks($this->request['department_id'],$this->request);
		return $arResult;
	}

	/**
	 *  Генератор строчного представления элемента
	 *
	 * @param   array $info Информация
	 * @param   array $offerConfig Конфигурация полей
	 *
	 * @return  array                json представление элемента
	 */
	public function generateRowView($info, $offerConfig)
	{
		$fields = Convert::fromElasticFields($info['_source']);
		$fields['id'] = $info['_id'];
		$info = [];
		foreach ($offerConfig as $fieldConfig) {
			$spec = Util::filterValue($fieldConfig);
			$value = $fields[$spec['field']];
			if ($value) {
				$value = $spec['filter']($value, $fields);
				$info[] = ["name" => '', "text" => $value];
			} else {
				if (strpos($spec['field'], 'price') !== false) {
					$info[] = ["name" => '', "text" => 'По запросу'];
				} else {
					$info[] = ["name" => '', "text" => ''];
				}
			}
		}
		$view = [
			"link" => Data::createUrl([], $fields),
			"info" => $info
		];
		return $view;
	}

	/**
	 * Изменения базового фильтра
	 *
	 * @param   array $filter Базовый фильтр
	 * @param   array $config Конфиг замен в виде [fieldCode => fieldValue]
	 * @param   array $not Конфиг замен в виде [fieldCode => fieldValue]
	 * @return  array  Новый фильтр
	 */
	private function changeFilter($filter, $config, $not = false)
	{
		if (!$filter['bool']['filter']) {
			$filter['bool']['filter'] = [];
		}
		unset($filter['ids']);
		$fields = array_keys($config);

		foreach ($filter['bool']['filter'] as $index => &$item) {
			foreach ($fields as $key => $field) {
				if (array_key_exists($field, $item['term'])) {
					if (is_array($config[$field])) {
						if($filter['bool']['filter'][$index]['term'][$field]==0){
							unset($filter['bool']['filter'][$index]['term']);
							$item['terms'][$field] = $config[$field];
						}
					}elseif ($config[$field] !== '') {
						$item['term'][$field] = $config[$field];
					} else {
						unset($filter['bool']['filter'][$index]);
					}
					unset($fields[$key]);
				}
			}
		}

		foreach ($fields as $field) {
			$term = 'term';
			if (is_array($config[$field])) {
				$term = 'terms';
			}
			$filter['bool']['filter'][] = [$term => [$field => $config[$field]]];
		}
		$filter['bool']['filter'] = array_values($filter['bool']['filter']);
		if ($not) {
				foreach ($not as $field => $value) {

					$term = 'term';
					if (is_array($value)) {
						$term = 'terms';
					}
					foreach($filter['bool']['filter'] as $k => $filt){
						if(array_key_exists($field, $filt['term'])){
							unset($filter['bool']['filter'][$k]);
						}
					}
					unset($filter['bool']['filter'][$field]['term']);
					$filter['bool']['must_not'][] = [$term => [$field => $value]];
				}
		}

		return $filter;
	}

	/**
	 * Генератор базового представления карточки
	 *
	 * @param   array $info Информация о карточке
	 * @param   string $valute Валюта
	 *
	 * @return  array           json представление карточки
	 */
	public function generateView($info, $valute)
	{
		$fields = Convert::fromElasticFields($info['_source']);
		$fields['id'] = $info['_id'];
		$isGroup = ($fields["isJk"] === 1);


		/** Подготовка валюты */
		switch ($valute) {
			case 'dol':
				$showValute = '$';
				break;
			case 'eur':
				$showValute = '€';
				break;
			case 'pound':
				$showValute = '£';
				break;
			default:
				$showValute = 'р.';
		}
		$typePrice='price_';
		if ($this->request['range'] == 'meters'){
			$typePrice='square_price_';
			$showValute=$showValute.'/м²';
		}

		/** Блок конфигураций */
		if ($fields['department_id']) {
			$departamentId = $fields['department_id'];
		} else {
			$departamentId = $this->departmentID;
		}
		if ($departamentId == LIVE_DEPARTAMENT) {
			$titleConfig = ['object_type', 'area|postfix:м²'];
			$addressConfig = ['district', 'locality', 'metro|prefix:м.', 'district_area', 'address', 'house'];
			$offerConfig = ['object_type', 'area|postfix:м²', 'rooms|plural:["комната","комнаты","комнат"]', 'floor|postfix:этаж', 'price_' . $valute . '|format|postfix:' . $showValute . '|hide-price'];
			$iconConfig = ['area!square|postfix:м²', 'rooms', 'floor|with-field:floors: / ', 'finish_type!facing'/*, 'metro|metro'*/];
			if ($isGroup) {
				$iconConfig = ['area!square|minmax|postfix:м²', 'finish_type!facing', 'finishyear!date'];
			}
		} else if ($departamentId == COUNTRY_DEPARTAMENT) {
			$titleConfig = ['object_type', 'area_building|postfix:м²'];
			$addressConfig = ['district_area', 'highway|postfix:шоссе', 'distance_mkad|postfix:км'];
			$offerConfig = ['object_type', 'bedrooms|plural:["спальня","спальни","спален"]', 'area_building|postfix:м²', 'price_' . $valute . '|format|postfix:' . $showValute . '|hide-price'];
			$iconConfig = ['area_weaving!area|minmax|postfix:соток', 'bedrooms!bedrooms', 'finish_type!facing', 'area_building!square|postfix:м²', 'distance_mkad!distance|postfix:км'];
			if ($fields['translit_object_type'] == 'uchastok') {
				$titleConfig = ['object_type', 'area_weaving|postfix:сот.'];
				$iconConfig =  ['area_weaving!area|minmax|postfix:сот.','gas_objects!gas|replace:Газ(Магистральный)', 'vodosn_objects!pump|replace:Водопровод', 'distance_mkad!distance|postfix:км'];
			}
			if ($isGroup) {
				$iconConfig = ['area_building!square|minmax|postfix:м²', 'area_weaving!area|minmax|postfix:сот.', 'distance_mkad!distance|postfix:км'];
			}
		} else if ($departamentId == FOREIGN_DEPARTAMENT) {
			$titleConfig = ['lot_name'];
			$addressConfig = ['country', 'city'];
			$iconConfig = ['area!square|postfix:м²', 'finishyear!date', 'bedrooms!bedrooms'];
			if ($fields['translit_object_type'] == 'uchastok') {
				$iconConfig =  ['area_weaving!area|minmax|postfix:сот.'];
			}
		} else if ($departamentId == COMMERC_DEPARTAMENT) {
			$titleConfig = ['lot_name'];
			$addressConfig = ['district', 'locality', 'metro|prefix:м.', 'district_area', 'address', 'house'];
			$iconConfig = ['area!square|format|postfix:м²', 'realty_class!class|prefix:Класс', 'metro|metro'];
			$offerConfig = ['area|format|postfix:м²', 'floor|postfix:этаж', 'finish_type', $typePrice . $valute . '|format|postfix:' . $showValute . '|hide-price'];

		}

		/** Логика формирования */
		$images = array_slice(array_reduce(['main_img', 'zhk_main_img'], function ($summ, $item) use ($fields) {
			$summ = array_merge($summ, array_filter(explode(',', $fields[$item]), function ($item) {
				return $item != '';
			}));
			return array_unique($summ);
		}, []), 0, 4);

		/** Логика формирования табличного вида для Сгруппированных объектов */

		$tableItems = [];
		if ($isGroup) {
			$elasticRes = $this->elasticRequest($this->changeFilter($this->arParams['FILTER'], [
				'parent_id' => $info['_id'],
				'department_id' => $departamentId,
			]), 3, [], 0);
			$arOffersCount = $elasticRes['hits']['total']['value'];
			$arOffers = $elasticRes['hits']['hits'];
			if ($arOffers) {
				foreach ($arOffers as $offer) {
						$tableItems[] = $this->generateRowView($offer, $offerConfig);
				}
			}
		}
		/** Логика формирования заголовоков */
		if ($isGroup) {
			$title = $fields['lot_name'];
		} else {
			$title = Util::generatedFields($titleConfig, $fields);
		}

		/** Получение информации о менеджере */
		$manager = [];
		if (!empty($fields['manager_id'])) {
			$arManager = Data::getEntityDataByFilter("Idem\Realty\Core\Manager\ManagerTable", ['ID' => $fields['manager_id']]);
			if (!empty($arManager['PHONE'])) {
				$manager['href'] = str_replace(['(', ')', ' ', '-'], '', $arManager['PHONE']);
				$manager['text'] = $arManager['PHONE'];
			}
		}
		/** Работа с ценой */
		$price = [];
		if ($fields['price_hidden'] == 1 || !$fields['price_' . $valute] || $fields['price_hidden_lot'] == 1) {
			$price['request'] = true;
		} else {
			if ($isGroup) {
				if (min($fields['price_' . $valute]) != 0 && is_array($fields['price_' . $valute])) {
					$priceTotal = 'от ' . number_format(min($fields['price_' . $valute]), 0, ' ', ' ');
					$priceSqr = 'от ' . number_format(min($fields['square_price_' . $valute]), 0, ' ', ' ');
				} elseif($fields['price_' . $valute] != 0 && $fields['price_' . $valute] != NULL) {
					$priceTotal = 'от ' . number_format($fields['price_' . $valute], 0, ' ', ' ');
					$priceSqr = 'от ' . number_format($fields['square_price_' . $valute], 0, ' ', ' ');
				}else {
					$price['request'] = true;
				}
			} else {
				$priceTotal = number_format($fields['price_' . $valute], 0, ' ', ' ');
				$priceSqr = number_format($fields['square_price_' . $valute], 0, ' ', ' ');
			}
			if ($priceTotal) {
				$price['total'] = $priceTotal . ' ' . $showValute;
			}
			if ($priceSqr) {
				$price['meters'] = $priceSqr . ' ' . $showValute . '/м²';
			}
		}

		/** Генерация иконок */
		$icons = [];
		foreach ($iconConfig as $fieldConfig) {
			$icon = Util::filterValue($fieldConfig);
			$value = $fields[$icon['field']];
			if ($value) {
				if(is_array($value) && count($value)==1){
					$value=$value[0];
				}
				$value = $icon['filter']($value, $fields);
				$icons[$icon['ico']] = $value;
			}
		}

		$card_type="lot";
		if($isGroup){
			$card_type="zk";
		}
		if($this->departmentID == COMMERC_DEPARTAMENT){
			$namePar=$info["_source"]["type_real"];
		}elseif($this->departmentID == FOREIGN_DEPARTAMENT){
			$namePar=$info["_source"]["object_type"];
		}elseif($fields["object_type"]=="Поселок"){
			$namePar="Посёлок";
			$card_type="plot";
		}elseif(in_array("Новостройка",$fields['tags'])){
			$ind= array_search("Новостройка",$fields['tags']);
			unset($fields['tags'][$ind]);
			$namePar="Новостройка";
		}elseif($this->departmentID!=COUNTRY_DEPARTAMENT && $this->departmentID!=FOREIGN_DEPARTAMENT){
			$ind= array_search("Вторичка",$fields['tags']);
			unset($fields['tags'][$ind]);
			$namePar="Вторичка";
		}

		if($info["_source"]["parent_id"]!=0 && $this->departmentID!=FOREIGN_DEPARTAMENT){
			$resultsParent = $this->elasticRequest([ "bool"=>["filter"=>[0=>["term"=>["_id"=>$info["_source"]["parent_id"]]]]]],1, [], 1);
			$namePar=$resultsParent["hits"]["hits"][0]["_source"]["lot_name"];
		}


		/** Генерация карточки */
		$view = [
			"type" => ($isGroup) ? 'table' : 'default',
			"card_type"=> $card_type,
			"deal_type" => $this->res->get('site_' . LANGUAGE_ID . '.' . $fields['deal_type']),
			"id" => $info['_id'] . '',
			"name"=>$namePar,
			"images" => (count($images) > 0) ? $images : [$this->defaultImage],
			"title" => $title,
			"finish_type" => $fields['finish_type'],
			"labels" => $fields['tags'],
			"address" => Util::generatedFields($addressConfig, $fields),
			"specs" => array_keys($icons),
			"table" => $tableItems,
			"info" => $icons,
			"price" => $price,
			"phone" => '', //$manager,
			"description" => $this->tease($fields['description'], 2),
			"link" => Data::createUrl([], $fields),
			"isFav" => false,
			"map_coords" => $fields['map_coords'],
			"category" => $fields['department_id'] . '',
			"objects"=>($isGroup)?Util::plural_form($arOffersCount, ['предложение', 'предложения', 'предложений']):'Подробнее'
		];
		return $view;
	}


	public function executeComponent()
	{
		global $APPLICATION;
		$this->request = array_merge([], $_REQUEST);

		if ($this->arParams['PARAMS']) {
			$this->request = array_merge_recursive((array) $this->request, (array) $this->arParams['PARAMS']);
		}

		if ($this->request['department_id']) {
			$this->departmentID = $this->request['department_id'];
		} else {
			$this->departmentID = $this->arParams['DEPARTAMEN_ID'];
			$this->request['department_id'] = $this->departmentID;
		}
		if ($this->request['search'] && intval($this->request['search']) == $this->request['search']) {
			if ($element = \Idem\Realty\Core\Objects\ObjectsTable::getList(['filter' => ['DEPARTAMENT_ID'=>$this->departmentID,'ID'=>$this->request['search']]])->fetch()) {
				$detailInfo = Convert::fromElasticFields($element['INFO']);
				$data = array_merge(['id'=>$element['ID']], (array)$detailInfo);
				$url = Data::createUrl([],$data);
				$this->arResult['catalog']['url'] = $url;
				$this->arResult['catalog']['reload'] = true;
				if ($this->arParams['RETURN']) {
					return $this->arResult['catalog'];
				} else {
					LocalRedirect($url, false, '301 Moved permanently');
				}
			}
		}
		$this->defaultImage = $this->GetPath() . '/Zaglushka.jpg';

		$this->res = \Idem\CIdemStatic::getInstance();
		$this->arResult = [];
		$chain = $APPLICATION->GetNavChain(false, false, false, true);

		$arData = $this->getObjectsData();
		$this->arResult['catalog'] = $arData;
		if ($this->arParams['RETURN']) {
			return $this->arResult['catalog'];
		}
		$this->arResult['catalog']['typeEstate'] =  self::NAME_CATEGORY[$this->arParams['DEPARTAMEN_ID']];
		$this->arResult['catalog']['filter'] = $this->arParams['json'];
		$this->arResult['catalog']['order'] = $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sale_order');
		$this->arResult['catalog']['requiesData'] = [
			'order' => 'asc',
			'page' => 1,
			'tags' => [],
		];
		$sortArea='area';
		if($this->request["object_type"]!="poselok" && $this->request["department_id"]==COUNTRY_DEPARTAMENT && $this->request["department_id"]==FOREIGN_DEPARTAMENT){
			$sortTop='top9|asc,sort_date_update|desc';
		}else{
			$sortTop="top9jk|asc,sort_date_update|desc";
		}
		if($this->request["department_id"]==COUNTRY_DEPARTAMENT){
			if($this->request["object_type"]=="uchastok"){
				$sortArea='area_weaving';
			}else{
				$sortArea='area_building';
			}
		}
		$this->arResult['catalog']['sort'] = [
			"name" => "sort",
			"values" => [
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_top9_asc'),
					"value" => $sortTop,
					"selected" => true
				],
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_price_asc'),
					"value" => "price_rub|asc",
				],
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_price_desc'),
					"value" => "price_rub|desc"
				],
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_area_asc'),
					"value" => $sortArea."|asc"
				],
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_area_desc'),
					"value" =>  $sortArea."|desc"
				],
				[
					"text" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_sort_date_update'),
					"value" => "sort_date_update|desc"
				]
			]
		];
		$this->arResult['catalog']['request'] = [
			"picture" => [
				"sources" => [
					"mobile" => [
						"/assets/images/how-back.jpg",
						"/assets/images/album.webp"
					],
					"tablet" => [
						"/assets/images/album.jpg",
						"/assets/images/album.webp"
					],
					"desktop" => [
						"/assets/images/album.jpg",
						"/assets/images/album.webp"
					]
				],
				"alt" => "album",
				"title" => "album"
			],
			"title" => GetMessage("textFormFind"),
			"form" => [
				"url" => "/ajax/helpBest.php",
				"hidden" => [
					"page" => $APPLICATION->GetCurDir()
				],
				"inputs" => [
					[
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
						"type" => "input",
						"name" => "phone",
						"placeholder" => "+7 (___) ___-__-__",
						"value" => "",
						"maskInfo" => [
							"options" => [
								"mask" => "+{7}(000) 000-00-00"
							],
							"complete" => false
						],
						"checked" => [
							"value" => "waiting",
							"required" => false,
							"lengthString" => [
								"min" => 17,
								"max" => 17
							]
						]
					],
					[
						"placeholder" => "E-mail*",
						"value" => "",
						"name" => "email",
						"type" => "text",
						"className" => "input--email",
						"checked" => [
							"value" => "waiting",
							"required" => true,
							"email" => true,
							"lengthString" => [
								"min" => 5,
								"max" => 250
							]
						]
					]
				],
				"btn" => "Отправить заявку",
				"checkbox" => [
					"text" => GetMessage("agreePersonal"),
					"name" => "checkbox",
					"value" => "y",
					"checked" => false
				]
			]
		];

		$this->arResult['catalog']["bannerSend"] = [
			"title" => $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_help_form_success_mess')
		];
		$this->arResult['catalog']["presentation"] = Util::getPresentation();

		$this->arResult['catalog']["desc"] = $this->getSeoBlock($this->departmentID);
		$this->arResult['catalog']["error"] = $this->res->get('site_' . LANGUAGE_ID . '.empty_error');

		/** Работа с SEO  */
		if (!empty($arData['seo']['title'])) {
			$APPLICATION->SetTitle($arData['seo']['title']);
			$APPLICATION->SetPageProperty("og:title", '<meta property="og:title" content="' . $arData['seo']['title'] . '"/>');
		}
		if (!empty($arData['seo']['keywords']))
			$APPLICATION->SetPageProperty("keywords", $arData['seo']['keywords']);
		if (!empty($arData['seo']['description'])) {
			$APPLICATION->SetPageProperty("description", $arData['seo']['description']);
			$APPLICATION->SetPageProperty("og:description", '<meta property="og:description" content="' . $arData['seo']['description'] . '"/>');
		}
		$APPLICATION->SetPageProperty("og:image", '<meta property="og:image" content="' . $this->res->get('site_' . LANGUAGE_ID . '.og_logo_file') . '"/>');
		$this->arResult['catalog']['title'] = $arData['seo']['title_page'];

		$this->arResult['catalog']["seo"]["items"] = $this->getSeoLinks($this->request['department_id'],$this->arParams['PARAMS']);
		$urlCategory = Data::createUrl([], ["department_id" => $this->request["department_id"]]);
		$this->arResult['catalog']['breadcrumbs']=[
			[
				"href" => "/",
				"title" => "Главная"
			],
			[
				"href" => $urlCategory,
				"title" => self::NAME_CATEGORY[$this->arParams['DEPARTAMEN_ID']]." недвижимость"
			]
		];
		/** Синхронизация реактивности */
		$this->syncVue();

		$this->includeComponentTemplate();
	}

	/**
	 * Герация доп данных для страницы и синхронизации с vue
	 *
	 * @return  void
	 */
	public function syncVue()
	{
		global $APPLICATION;
		setJsonInit('catalog', $this->arResult['catalog']);
		setJsonInit('popups/form/brokerSelection', [
			"title" => GetMessage("zakazPod"),
			"action" => "/ajax/broker.php",
			"hidden" => [
				"page" => $APPLICATION->GetCurDir()
			],
			"inputs" => [
				[
					"type" => "select",
					"title" => GetMessage("livTown"),
					"info" => [
						"name" => "typeEstate",
						"values" => [
							[
								"text" => GetMessage("livTown"),
								"value" => GetMessage("livTown"),
								"selected" => true
							],
							[
								"text" => GetMessage("liveOffTown"),
								"value" => GetMessage("liveOffTown")
							]
						]
					]
				],
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
				],	[
					"type" => "input",
					"name" => "email",
					"placeholder" => "E-mail*",
					"value" => "",
					"checked" => [
						"value" => "waiting",
						"required" => true,
						"email" => true,
						"lengthString" => [
							"min" => 5,
							"max" => 250
						]
					]
				],
				[
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
				"param" => "PARAM_1",
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
	}
	/**
	 *  Получение ссылок в для заданного списка объектов
	 *
	 * @param   string $department департамент
	 *
	 * @return  array  json представление для рендера
	 */
	public function getSeoLinks($department,$filter=[],$obj='')
	{
		$deal_type=($filter['deal_type']=="arenda")?"Аренда":"Продажа";
		if($filter["object_type"]){
			$target1 = mb_strtolower(morpher_inflect(RuleSeoList::getTargetByDepartament($filter["object_type"], 1, true), 'rod mn'));
			if($target1=="#error: parameter 1 'text' is plural."){
				$target1=mb_strtolower(morpher_inflect(RuleSeoList::getTargetByDepartament($filter["object_type"], 1, true), 'rod'));
			}
		}
		$data = new Data();
		$fielsd = [];
		$nameItem = 'items';		
		if ($department == LIVE_DEPARTAMENT || $department == COMMERC_DEPARTAMENT) {
			$fielsd = ['locality'];
			$title = $this->res->get('catalog_' . LANGUAGE_ID . '.know_more_moscow_location');
			$btn = $this->res->get('catalog_' . LANGUAGE_ID . '.show_more_location');
			$itemsDistricts = $data->getLocations();
			if($filter["metro"] || $filter["locality"]){
				$seoItemType=[];
				if($filter["object_type"]){
					$itemsEl=$data->getSeoLinks(['metro'],$filter["object_type"],$department);
					$seoItemType["title"]=$deal_type.' '.$target1." у метро";
				}else{
					$itemsEl=$data->getSeoLinks(['metro'],'',$department );
					$seoItemType["title"]="Предложения у метро";
				}

				$seoItemType["btnOpen"]="Показать больше станций";
				$seoItemType["items"]=$itemsEl["items"][0]["items"];
			}elseif($filter["district"]){
				$seoItemType=[];
				if($filter["object_type"]){
					$itemsEl=$data->getSeoLinks(['locality'],$filter["object_type"],$department );
					$seoItemType["title"]=$deal_type.' '.$target1." в районе";
				}else{
					$itemsEl=$data->getSeoLinks(['locality'],'',$department);
					$seoItemType["title"]="Предложения в районе";
				}
				$seoItemType["btnOpen"]="Показать больше районов";
				$seoItemType["items"]=$itemsEl["items"][0]["items"];
			}else{
				$seoItemType=[];				
				if($filter["object_type"]){
					$itemsEl=$data->getSeoLinks(['district'],$filter["object_type"],$department);					
					$seoItemType["title"]=$deal_type.' '.$target1." в округе";
				}else{
					$itemsEl=$data->getSeoLinks(['district'],'',$department);
					$seoItemType["title"]="Предложения в округе";
				}
				$seoItemType["btnOpen"]="Показать больше округов";
				$seoItemType["items"]=$itemsEl["items"];
			}
			//dump($seoItemType["items"]);
		} elseif ($department == COUNTRY_DEPARTAMENT) {
			$seoItemType=[];
			if($filter["object_type"]){
				$itemsEl=$data->getSeoLinks(['highway'],$filter["object_type"],$department);
				$seoItemType["title"]=$deal_type.' '.$target1."  по шоссе";
			}else{
				$itemsEl=$data->getSeoLinks(['highway'],'',$department);
				$seoItemType["title"]="Предложения  по шоссе";
			}
			$seoItemType["btnOpen"]="Показать больше шоссе";
			$seoItemType["items"]=$itemsEl["items"];

		} elseif ($department == FOREIGN_DEPARTAMENT) {
			$fielsd = ['country'];
			$title = GetMessage("country");
			$btn = GetMessage("seeMoreCountry");
		}
		$seoLinks = $data->getSeoLinks($fielsd,'',$department);
		if (count($itemsDistricts) > 0) {
			$arItems = $itemsDistricts;
		} else {
			$arItems = $seoLinks["items"][0][$nameItem];
		}
		if (count($arItems) > 0) {
			$arResult = [
				[
					"title" => $title,
					"items" => $arItems,
					"btnOpen" => $btn
				]
			];
			if($seoItemType){
				array_unshift($arResult,$seoItemType);
			}
		}elseif($seoItemType){
			$arResult=[$seoItemType];
		}
		return $arResult;
	}
	/**
	 *  Получение описание для сео по категории
	 *
	 * @param   string $department департамент
	 *
	 * @return  array  json представление для блока сео
	 */
	public function getSeoBlock($department)
	{
		$data = $this->createSeoParams();
		if ($department == LIVE_DEPARTAMENT) {
			$titleDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_descr_title');
			$describeDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.live_realty_desct_text');
		} elseif ($department == COMMERC_DEPARTAMENT) {
			$titleDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.commers_realty_descr_title');
			$describeDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.commers_realty_desct_text');
		} elseif ($department == COUNTRY_DEPARTAMENT) {
			$titleDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.country_realty_descr_title');
			$describeDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.country_realty_desct_text');
		} elseif ($department == FOREIGN_DEPARTAMENT) {
			$titleDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.foreight_realty_descr_title');
			$describeDesc = $this->res->get('catalog_' . LANGUAGE_ID . '.foreight_realty_desct_text');
		}
		if ($data["title_text_seo"]) {
			$titleDesc = $data["title_text_seo"];
		}
		if ($data["text_seo"]) {
			$describeDesc = $data["text_seo"];
		}
		$arResult = [
			"title" => $titleDesc,
			"describe" => $describeDesc
		];
		return $arResult;
	}
}
