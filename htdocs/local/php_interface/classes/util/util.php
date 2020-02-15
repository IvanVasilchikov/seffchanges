<?php

namespace app\Util;

use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Data\Cache;

class Util
{
	public static function plural_form($number, $after, $withNum = true)
	{
		$cases = array(2, 0, 1, 1, 1, 2);
		if ($withNum)
			return $number . " " . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
		else
			return $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
	}
	public static function simular_form($word, $plural = false)
	{
		if ($plural) {
			$vocabulary = [
				"дом" => [" дом", " дома", " домов"],
				"дача" => [" дача", " дачи", " дач"],
				"коттедж" => [" коттедж", " коттеджа", " коттеджей"],
				"участок" => [" участок", " участка", " участков"],
				"часть дома" => ["часть дома", " части дома", "частей дома"],
				"Квартира" => [" квартира", " квартиры", " квартир"],
				"Апартаменты" => [" апартаменты", " апартаментов", " апартаментов"],
				"Пентхаус" => [" пентхаус", " пентхауса", " пентхаусов"],
				"Таунхаус" => [" таунхаус", " таунхауса", " таунхаусов"],
				"Вилла" => [" вилла", " виллы", " вилл"],

			];
		} else {
			$vocabulary = [
				"Дом" => "дома",
				"Дача" => "дачи",
				"Коттедж" => "коттеджи",
				"Участок" => "участоки",
				"Часть дома" => "части домов",
				"Квартира" => "Квартиры",
				"Апартаменты" => "Апартаменты",
				"Пентхаус" => "Пентхаусы",
				"Таунхаус" => "Таунхаусы",
				"Вилла" => "Виллы",

			];
		}

		if (array_key_exists($word, $vocabulary)) {
			return $vocabulary[$word];
		} else {
			return $word;
		}
	}
	/**
	 * Генератор фильтров
	 *
	 * @param   string  $fieldConfig  Конфигурация поля
	 *
	 * @return  array   Возвращает ['field'=>Поле, 'ico' => Название иконки, 'filter'=>Ф-ция преобразователь]
	 */
	public function filterValue($fieldConfig)
	{
		$fieldConfig = explode('|', $fieldConfig);
		$field = array_shift($fieldConfig);
		$field = explode('!', $field);
		if (count($field) > 1) {
			$ico = $field[1];
		} else {
			$ico = $field[0];
		}
		$field = $field[0];
		$params = array_map(function ($item) {
			return explode(':', $item);
		}, $fieldConfig);
		$fn = function ($value, $fields) use ($params) {
			if (count($params) > 0) {
				foreach ($params as $filter) {
					if ($filter[0] == 'plural') {
						$value = Util::plural_form($value, json_decode($filter[1]), true);
					} elseif ($filter[0] == 'replace') {
						$value = $filter[1];
					} elseif ($filter[0] == 'postfix') {
						if ($filter[1] == ',') {
							$value = $value . $filter[1];
						} else {
							$value = $value . '&nbsp;' . $filter[1];
						}
					} elseif ($filter[0] == 'prefix') {
						$value = $filter[1] . '&nbsp;' . $value;
					} elseif ($filter[0] == 'with-field') {
						if ($fields[$filter[1]]) {
							$value = implode($filter[2], [$value, $fields[$filter[1]]]);
						}
					} elseif ($filter[0] == 'format') {
						$value = number_format($value, 0, ' ', ' ');
					} elseif ($filter[0] == 'minmax') {
						if (is_array($value)) {
							$value = min($value) . ' - ' . max($value);
						} else {
							$value = $value;
						}
					} elseif ($filter[0] == 'hide-price') {
						if ($fields['price_hidden'] == 1) {
							$value = 'По запросу';
						}
					} elseif ($filter[0] == 'metro') {
						$value = [
							"station" => $fields['metro'],
							"walk" => Util::plural_form($fields['distance_metro'], ['минута пешком', 'минуты пешком', 'минут пешком'], true)
						];
					}
				}
			}
			return $value;
		};
		return ['field' => $field, 'ico' => $ico, 'filter' => $fn];
	}
	/**
	 * функция склейки полей (нужно для полей типа адрес или названияы)
	 *
	 * @param   array  $config     конфигурация полей
	 * @param   array  $fields     поле
	 * @param   string  $delimeter  разделитель
	 *
	 * @return  string              Возвращаемая строка
	 */
	public function generatedFields($config, $fields, $delimeter = ', ')
	{
		return implode($delimeter, array_reduce($config, function ($summ, $item) use ($fields) {
			$spec = Util::filterValue($item);
			if ($fields[$spec['field']] != '') {
				$value = $fields[$spec['field']];
				$summ[] = $spec['filter']($value, $fields);
			}
			return $summ;
		}, []));
	}


	public function getLangs()
	{
		$cache = Cache::createInstance();

		if ($cache->initCache(72000, "main_get_languages")) {
			$res = $cache->getVars();
		} elseif ($cache->startDataCache()) {

			$by = 'sort';
			$order = 'asc';
			$dbRes = \CSite::GetList($by, $order);

			$items = [];

			while ($item = $dbRes->Fetch()) {
				$lang = $item;
				if ($item['ACTIVE'] === 'N') {
					continue;
				}
				$lang['ACTIVE'] = false;
				if ($item['LANGUAGE_ID'] == LANGUAGE_ID)
					$lang['ACTIVE'] = true;
				$items[$item['LANGUAGE_ID']] = $lang;
			}

			$res['res'] = $items;

			$cache->endDataCache(['res' => $items]);
		}


		return $res['res'];
	}

	public static function getPresentation()
	{
		$arResult = [];
		$res = \Idem\CIdemStatic::getInstance();
		$arResult['picture'] = [
			"sources" => [
				"mobile" => [$res->get('main_' . LANGUAGE_ID . '.presentation_mobile_file'), ''],
				"tablet" => [$res->get('main_' . LANGUAGE_ID . '.presentation_tablet_file'), ''],
				"desktop" => [$res->get('main_' . LANGUAGE_ID . '.presentation_desktop_file'), ''],
			],
			"alt" => "presentation bg",
			"title" => "presentation"
		];
		$arResult['title'] = $res->get('main_' . LANGUAGE_ID . '.presentation_title');
		$arResult['btn'] = [
			'text' => $res->get('main_' . LANGUAGE_ID . '.presentation_btn'),
			'url' => $res->get('main_' . LANGUAGE_ID . '.presentation_url'),
		];
		return $arResult;
	}

	public function getCompanyData()
	{
		$arResult = [];
		$cache_dir = "/get_company_data";
		$arParams = ['NAME' => $cache_dir, 'CACHE_TIME' => 36000000, 'lang' => LANGUAGE_ID];
		$cache = Cache::createInstance();
		$cache_id = md5(serialize($arParams));
		if ($cache->InitCache($arParams['CACHE_TIME'], $cache_id, $cache_dir)) {
			$arResult = $cache->getVars();
		} elseif (Loader::includeModule('iblock') && $cache->startDataCache()) {
			$iblockID = getIBlockIdByCode('info_' . LANGUAGE_ID);
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache($cache_dir);
			$CACHE_MANAGER->RegisterTag('iblock_id_' . $iblockID);
			$arSelect = ["ID", "NAME", "CODE", "ACTIVE", "PREVIEW_PICTURE", "PROPERTY_MAP", "PROPERTY_COMPANY_MAP_POINTS", "PROPERTY_AGREE",];
			$arFilter = ["IBLOCK_ID" => $iblockID, "CODE" => "company_data_" . LANGUAGE_ID, "ACTIVE" => "Y"];
			$res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
			if ($ob = $res->GetNext()) {
				if (!empty($ob['PROPERTY_MAP_VALUE'])) {
					$arTemp = explode(',', $ob['PROPERTY_MAP_VALUE']);
					$arResult['map']['lat'] = $arTemp[0];
					$arResult['map']['lng'] = $arTemp[1];
					$arResult['map']['no_format'] = str_replace(',', ', ', $ob['PROPERTY_MAP_VALUE']);
				}
				if (!empty($ob['PROPERTY_COMPANY_MAP_POINTS_VALUE'])) {
					foreach ($ob['PROPERTY_COMPANY_MAP_POINTS_VALUE'] as $mapData) {
						$arTemp = explode(',', $mapData);
						$arResult['company_map_points'][] = [
							'lat' => $arTemp[0],
							'lng' => $arTemp[1],
							'no_format' => str_replace(',', ', ', $mapData),
						];
					}
				}


				if (!empty($ob['PROPERTY_AGREE_VALUE'])) {
					$arResult['privacy_policy_link'] = $ob['PROPERTY_AGREE_VALUE'];
					$arResult['privacy_policy_text'] = $ob['PROPERTY_AGREE_DESCRIPTION'];
				}
				if ($ob['PREVIEW_PICTURE'])
					$arResult['map_img'] = \CFile::GetPath($ob['PREVIEW_PICTURE']);
			}
			$CACHE_MANAGER->EndTagCache();
			$cache->endDataCache($arResult);
		}

		return $arResult;
	}

	/*
		 *$arFilter = ["IBLOCK_ID"=>$iblockID,"ACTIVE"=>"Y"];
			$arProps = ["LINK"];
			$imgsFields = ["PREVIEW_PICTURE"];
			$imgSizes = [
						"desktop" => ['width' => 1440, 'height' => 0],
						"tablet" => ['width' => 768, 'height' => 0],
						"mobile" => ['width' => 375, 'height' => 0],
				];
		 *
		 */
	public function getTypicalData($iblockCode = "", $limit = false, $getWithSectionsData = false, $arProps = [], $standartFilter = false, $newFilter = [], $imgsFields = [], $imgSizes = [], $imgExact = false, $prop = false)
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheTime = 3600 * 20;
		$cache_dir = '/custom_' . ToLower($iblockCode);
		$arCache = [];
		$arCache['section_data'] = $getWithSectionsData;
		$arCache['limit'] = $limit;
		$arCache['props'] = $arProps;
		$arCache['standart_filter'] = $standartFilter;
		$arCache['new_filter'] = $newFilter;
		$arCache['imgs_fileds'] = $imgsFields;
		$arCache['imgs_sizes'] = $imgSizes;
		$arCache['img_exact'] = $imgExact;
		$arCache['func'] = $cache_dir;
		$arCache['cache_time'] = $cacheTime;

		$cache_id = md5(serialize($arCache));
		$arResult = [];

		if ($cache->initCache($cacheTime, $cache_id, $cache_dir)) {
			$arResult = $cache->getVars();
		} elseif ($cache->startDataCache() && Loader::includeModule('iblock')) {
			$iblockID = getIBlockIdByCode($iblockCode);
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache($cache_dir);
			$CACHE_MANAGER->RegisterTag('iblock_id_' . $iblockID);

			if ($getWithSectionsData) {
				$db_list = \CIBlockSection::GetList([], ["IBLOCK_ID" => $iblockID, "ACTIVE" => "Y"], true);
				while ($ar_result = $db_list->GetNext()) {
					$arResult['SECTIONS'][$ar_result['ID']] = $ar_result;
				}
			}
			$arSelect = ["ID", "NAME", "CODE", "PREVIEW_TEXT", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE", "DETAIL_TEXT", "IBLOCK_SECTION_ID"];
			foreach ($arProps as $propCode)
				$arSelect[] = 'PROPERTY_' . $propCode;

			if ($standartFilter)
				$arFilter = ["IBLOCK_ID" => $iblockID, "ACTIVE" => "Y"];
			else
				$arFilter = $newFilter;
			if (!$limit)
				$res = \CIBlockElement::GetList(["SORT"=>"ASC"], $arFilter, false, false, $arSelect);
			else
				$res = \CIBlockElement::GetList([], $arFilter, false, ['nPageSize' => $limit], $arSelect);
			while ($row = $res->GetNext()) {
				if ($prop && !empty($arProps)) {
					foreach ($arProps as $infoProps) {
						$db_props = \CIBlockElement::GetPropertyValues($iblockID, ["ID" => $row['ID']], array("sort" => "asc"), true, ["ID" => $row["PROPERTY_'.$infoProps.'_VALUE_ID"]]);
						if ($ar_props = $db_props->Fetch()) {
							foreach ($ar_props["DESCRIPTION"] as $desc) {
								$row['PROPS_DATA'][$infoProps]['DESCRIPTION'] = $desc;
							}
						}
					}
				}
				foreach ($imgsFields as $field) {
					if (!empty($row[$field])) {
						if (!is_array($row[$field]))
							$row[$field] = [$row[$field]];
						$arImgs = [];
						foreach ($row[$field] as $imgID) {
							$arTemp = [];
							if (!empty($imgSizes)) {
								foreach ($imgSizes as $sizeName => $arSize) {
									if ($imgExact)
										$arFile = \CFile::ResizeImageGet($imgID, $arSize, BX_RESIZE_IMAGE_EXACT, true);
									else
										$arFile = \CFile::ResizeImageGet($imgID, $arSize, BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
									$arTemp[$sizeName] = [
										$arFile["src"],
										""
									];
								}
							} else {
								$arTemp = \CFile::GetPath($imgID);
							}
							$arImgs[] = $arTemp;
						}
						$row[$field] = $arImgs;
					}
				}
				if ($getWithSectionsData) {
					$arResult['SECTIONS'][$row['IBLOCK_SECTION_ID']]['ITEMS'][] = $row;
				} else
					$arResult[] = $row;
			}

			$CACHE_MANAGER->EndTagCache();
			$cache->endDataCache($arResult);
		}

		return $arResult;
	}

	public static function getArrayImg($url)
	{
		$arFile = \CFile::MakeFileArray($url);
		$size = getimagesize($arFile["tmp_name"]);
		$newArFile['FILE_NAME'] = $arFile["name"];
		$newArFile['ORIGINAL_NAME'] = $arFile["name"];
		$newArFile['SRC'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $arFile["tmp_name"]);
		$newArFile['CONTENT_TYPE'] = $arFile["type"];
		$newArFile['SUBDIR'] = str_replace(['/' . $arFile["name"], '/upload/'], "", '' . $newArFile['SRC']);
		$newArFile['MODULE_ID'] = 'iblock';
		$newArFile['DESCRIPTION'] = '';
		$newArFile['HEIGHT'] = $size[0];
		$newArFile['WIDTH'] = $size[1];
		$newArFile['FILE_SIZE'] = filesize($arFile["tmp_name"]);
		return $newArFile;
	}

	static function cropImg($picture, $width, $height)
	{
		$fileInfo = \CFile::GetFileArray($picture);
		$koef = $fileInfo['WIDTH']/$fileInfo['HEIGHT'];
		$calcWidth = $koef*$height;
		$file = \CFile::ResizeImageGet($picture, array('width' => ($calcWidth < $width ? $width : $calcWidth), 'height' => $height), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		return $file["src"];
	}

	public function getCropImgs($arImgs = [], $width = 390, $height = 300)
	{
		$arResult = [];
		foreach ($arImgs as $imgPath) {
			$arTempImg = self::getArrayImg($imgPath);
			$arResult[] = self::cropImg($arTempImg, $width, $height);
		}

		return $arResult;
	}

	public function getContactsMicroData()
	{
		$res = \Idem\CIdemStatic::getInstance();

		$arSocials = [];
		$arTempSocials = $res->get('contacts_' . LANGUAGE_ID . '.social');
		foreach ($arTempSocials as $arTempData) {
			if (!empty($arTempData['url']))
				$arSocials[] = $arTempData['url'];
		}
		$arJsonData = [
			"@context" => "http://schema.org",
			"@type" => "Organization",
			"name" => $res->get('site_' . LANGUAGE_ID . '.name'),
			"url" => $res->get('site_' . LANGUAGE_ID . '.url_site'),
			"email" => $res->get('contacts_' . LANGUAGE_ID . '.email_text'),
			"description" => strip_tags($res->get('about_' . LANGUAGE_ID . '.about_description'))
		];
		if (!empty($arSocials))
			$arJsonData['sameAs'] = $arSocials;


		ob_start(); ?>
		<script type="application/ld+json">
			<?= json_encode($arJsonData, JSON_UNESCAPED_SLASHES) ?>
		</script>
		<?
		return ob_get_clean();
	}

	public function updateSitemapIblock($departmentID = 0, $arObjects = [])
	{
		Loader::includeModule('iblock');
		if (!$departmentID || empty($arObjects))
			return false;
		switch ($departmentID) {
			case '1':
				$iblockCode = 'zhk_sitemap';
				break;
			case '2':
				$iblockCode = 'commerc_sitemap';
				break;
			case '3':
				$iblockCode = 'country_sitemap';
				break;
			case '5':
				$iblockCode = 'foreign_sitemap';
				break;
			default:
				$iblockCode = 'zhk_sitemap';
				break;
		}
		$iblockID = getIBlockIdByCode($iblockCode);
		$arFilter = ["IBLOCK_ID" => $iblockID, "ACTIVE" => "Y"];
		$result = \Bitrix\Iblock\ElementTable::getList(array(
			'select'  =>  ['IBLOCK_ID', 'ID'],
			'filter'  =>  $arFilter,
		))->fetchAll();
		$el = new \CIBlockElement;
		foreach ($result as $arElem) {
			$el->Delete($arElem['ID']);
		}


		foreach ($arObjects as $key => $arData) {
			if (!$arData['publish'])
				continue;
			$arWriteData = ['NAME' => $arData['name'], "IBLOCK_ID" => $iblockID, 'CODE' => $arData['code'], 'ACTIVE' => 'Y'];

			$el->Add($arWriteData);
		}

		if (Loader::IncludeModule('search')) {
			//В этом массиве будут передаваться данные "прогресса". Он же послужит индикатором окончания исполнения.
			$NS = array();
			//Задаем максимальную длительность одной итерации равной "бесконечности".
			$sm_max_execution_time = 0;
			//Это максимальное количество ссылок обрабатываемых за один шаг.
			//Установка слишком большого значения приведет к значительным потерям производительности.
			$sm_record_limit = 5000;
			do {
				$cSiteMap = new \CSiteMap;
				//Выполняем итерацию создания,
				$NS = $cSiteMap->Create(LANGUAGE_ID == 'ru' ? "s1" : "s2", array($sm_max_execution_time, $sm_record_limit), $NS);
				//Пока карта сайта не будет создана.
			} while (is_array($NS));
		}
		return true;
	}
	public function sorterFields($sortConfig, $data) {
		foreach($data as $k=>$value){
			$data[$k]["sort"]=0;
			if(array_key_exists($value["value"], $sortConfig)){
				$data[$k]["sort"]= $sortConfig[$value["value"]];
			}
		}
		usort($data, Util::build_sorter('sort'));
		return($data);

	}
	public function build_sorter($key) {
		return function ($a, $b) use ($key) {
			return strnatcmp($a[$key], $b[$key]);
		};
	}
}
