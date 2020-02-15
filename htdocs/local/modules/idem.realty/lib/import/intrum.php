<?php

namespace Idem\Realty\Import;

use Idem\Realty\Utilities\Currency;
use Idem\Realty\Realty\Data;
use app\Util\Convert;
use app\Util\Util;

/**
 * Класс для получение данных из интрума
 */
class Intrum
{

	const KEY = 'b6c225e9408074c968f07e55bc7f732b';
	const API = 'http://saffariestate.intrumnet.com:81/sharedapi';
	const TRANSLIT = array("replace_space" => "-", "replace_other" => "-");

	/**
	 * получение контента
	 *
	 * @param  mixed $url - ссылка
	 *
	 * @return array - []
	 */

	static private function getContent($url)
	{
		$out = [];
		if ($curl = curl_init()) {
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			$out = curl_exec($curl);
			$curl_error = curl_errno($curl);
			curl_close($curl);
		}

		return json_decode($out, 1);
	}

	static private function log($name = "", $time = "", $data)
	{
		if (empty($time))
			$time = date('dmYH', time());
		$logDir = dirname(__FILE__) . "/../../../../../upload/intrum_import/";
		if (!is_dir($logDir)) {
			mkdir($logDir);
		}
		$fileName = $name . "-{$time}.log";
		$logFullPath = $logDir . $fileName;
		if (!file_put_contents($logFullPath, $data))
			echo 'Нет доступа на запись';
	}

	static public function arrayLog($name = "", $arData)
	{
		$logDir = dirname(__FILE__) . "/../../../../../upload/intrum_import/";
		if (!is_dir($logDir)) {
			mkdir($logDir);
		}
		$fileName = $name . ".log";
		$logFullPath = $logDir . $fileName;
		$log = "";
		foreach ($arData as $data)
			$log .=  $data . PHP_EOL;
		if (!file_put_contents($logFullPath, $log)) {
			printf('Нет доступа на запись');
		}
	}

	/**
	 * генерации url
	 *
	 * @param  mixed $url - url маска
	 * @param  mixed $data - данные которые требуется заменить формат ключ - значение
	 *
	 * @return string - сгенерированный url
	 */
	static private function generateUrl($url, $data = [])
	{
		$replacment = [
			'#API#' => self::API,
			'#KEY#' => self::KEY,
		];
		$replacment = array_merge($replacment, $data);
		return str_replace(array_keys($replacment), array_values($replacment), $url);
	}

	/**
	 * Получение типов недвижимостей
	 * @return [] - Ассоциативный массив ключ значение
	 */
	public function getTypes()
	{
		$responce = self::getContent(self::generateUrl('#API#/stock/types?apikey=#KEY#', []));
		$types = [];
		foreach ($responce['data'] as $item) {
			$types[$item['id']] = [
				'id' => $item['id'],
				'value' => $item['name']
			];
		}
		return $types;
	}

	/**
	 * getCategories - получение категорий
	 *
	 * @return [] - Категории элементов
	 */
	public function getCategories()
	{
		$responce = self::getContent(self::generateUrl('#API#/stock/category?apikey=#KEY#', []));
		$arDepartments = $this->getTypes();
		$categories = [];
		foreach ($responce['data'] as $type => $items) {
			foreach ($items as $item) {
				$categories[$item['id']] = [
					'id' => $item['id'],
					'value' => $item['name'],
					//'value' => $item['name']."(".$arDepartments[$type]['value'].")",
					'type' => $type,
					'type_name' => $arDepartments[$type]['value']
				];
			}
		}
		return $categories;
	}

	/**
	 * получение вариантов для поля
	 *
	 * @param integer $fieldID
	 * @return array массив с вариантами значений
	 */
	public static function getVariants($fieldID)
	{
		$responce = self::getContent(self::generateUrl('#API#/utils/variants?apikey=#KEY#&params[property_id]=#ID#', [
			'#ID#' => $fieldID,
		]));
		return $responce['data'];
	}

	/**
	 * получение менеджеров
	 *
	 * @param integer $fieldID
	 * @return array массив с вариантами значений
	 */
	public static function getManagers()
	{
		$responce = self::getContent(self::generateUrl('#API#/sharedapi/worker/filter?apikey=b11d4baba25661d2d467d491482c5f07', []));
		return $responce['data'];
	}

	/**
	 * Запись в справочники вариантов
	 */
	public function writeReferenceTables()
	{
		$rootDir = dirname(__FILE__) . "/../../../../..";
		$jsonFilePath = "/local/modules/idem.realty/lib/core/objects/admininterface/object_admin_template.json";
		$arTemp = file_get_contents($rootDir . $jsonFilePath);
		$arDataByTabs = json_decode($arTemp, 1);
		foreach ($arDataByTabs as $key => $arTabData) {
			foreach ($arTabData as $fieldID => $arField) {
				if ($arField['helper'] != "Departament")
					continue;
				if (($arField['datatype'] == 'select' || $arField['datatype'] == 'multiselect') && (!empty($arField['intrum_property_id']) || $arField['helper'] == "Departament" || $arField['helper'] == "Dealtype")) {
					if ($arField['helper'] == "Departament") {
						$arData = $this->getTypes();
						$this->dataCollect($arData, $arField['helper']);
					} elseif ($arField['helper'] == "Dealtype") {
						$arData = $this->getCategories();
						$this->dataCollect($arData, $arField['helper']);
					} elseif (isset($arField['intrum_property_id']) && !empty($arField['intrum_property_id'])) {
						foreach ($arField['intrum_property_id'] as $departamentID => $propID) {
							$arData = self::getVariants($propID);
							if (!empty($arData)) {
								$this->dataCollect($arData, $arField['helper']);
								echo "Записали " . $arField['helper'] . "департамент " . $departamentID . '<br>';
							} else
								echo 'нет данных для ' . $arField['helper'] . '<br>';
						}
					}
				}
			}
		}
	}


	/*
		 * формирует данные для записи и делает запись в справочник
		 */
	public function dataCollect($arData = [], $helper = "")
	{
		if (!empty($arData) && !empty($helper)) {
			foreach ($arData as $data) {
				$data['value'] = trim($data['value']);
				$arWriteData = [
					'NAME' => $data['value'],
					'CODE' => \Cutil::translit($data['value'], "ru", self::TRANSLIT),
				];
				if ($helper == "Valute")
					$arWriteData['CODE'] = $data['id'];
				$this->writeDataByEntity("Idem\Realty\Core\\" . $helper . "\\" . $helper . "Table", $arWriteData);
			}
		}
	}

	/*
		 * делает запись в справочник
		 */
	public function writeDataByEntity($entity = "", $data = [])
	{
		$res = $entity::add($data);
		$ID = $res->getId();
		$arFields['ID'] = $ID;
		if (!$ID) {
			self::log("import_variants_", "", $res->getErrorMessages());
			die('');
		}
	}
	/**
	 * Получение элементов
	 *
	 * @param integer $type - департамент объектов
	 * @param string $lastTime - время от которого нужно выгружать объекты
	 * @param integer $page - номер страницы
	 * @param integer $limit - ограничение на кол-вл
	 * @return array - элементы
	 */

	public function getElements($type, $lastTime = '', $page = 1, $limit = 200)
	{
		$elements = [];
		do {
			$url = self::generateUrl('#API#/stock/filter?apikey=#KEY#&params[type]=#TYPE#&params[limit]=#LIMIT#&params[page]=#PAGE#&params[date_field]=stock_activity_date&params[date][from]=#LAST_TIME#', [
				'#TYPE#' => $type,
				'#PAGE#' => $page,
				'#LAST_TIME#' => urlencode($lastTime),
				'#LIMIT#' => $limit,
			]);
			$responce = self::getContent($url);
			foreach ($responce['data']['list'] as &$item) {
				$item['fields'] = array_reduce($item['fields'], function ($summ, $item) {
					if ($item['value'] == "") {
						return $summ;
					}
					if (!isset($summ[$item['id']])) {
						if ($item['type'] == 'multiselect') {
							$values = explode(',', $item['value']);
							$summ[$item['id']] = $values;
						} else {
							if (is_numeric($item['value'])) {
								$item['value'] = floatval($item['value']);
							}
							$summ[$item['id']] = $item['value'];
						}
					} else {
						if (!is_array($summ[$item['id']])) {
							$summ[$item['id']] = [$summ[$item['id']]];
						}
						if (is_numeric($item['value'])) {
							$item['value'] = floatval($item['value']);
						}
						$summ[$item['id']][] = $item['value'];
					}
					return $summ;
				}, []);
			}
			unset($item);
			$elements = array_merge($elements, $responce['data']['list']);
			$page++;
		} while (count($responce['data']['list']) !== 0);
		return $elements;
	}

	static public function cropImage($images) {
		$images = explode(',',$images);
		foreach($images as &$image) {
			$image = $_SERVER['DOCUMENT_ROOT'].$image;
			$fileInfo = \CFile::GetImageSize($image);
			$koef = $fileInfo[0]/$fileInfo[1];
			$calcWidth = $koef*600;
			$dest = str_replace('/upload/realty_img_intrum','/upload/realty_img_intrum/resize',$image);
			if (!file_exists($dest)) {
				\CFile::ResizeImageFile($image, $dest, ['width'=>$calcWidth, 'height'=>600],'BX_RESIZE_IMAGE_PROPORTIONAL');
			}
			$image = str_replace($_SERVER['DOCUMENT_ROOT'],'',$dest);
		}
		$images = implode(',',$images);
		return $images;
	}
	public function checkStatus($arElement = [], $departmentID = 0)
	{
		$active = 0;
		if (!$departmentID)
			return $active;

		//сейчас св-ва не созданы для всех поэтому такой костыль
		switch ($departmentID) {
			case '1':
				$sitePropID = 1639;
				$statusPropID = 1196;
				break;
			case '2':
				$sitePropID = 0;
				$statusPropID = 1493;
				break;
			case '3':
				$sitePropID = 1645;
				$statusPropID = 1494;
				break;
			case '5':
				$sitePropID = 0;
				$statusPropID = 0;
				break;
			default:
				$sitePropID = 0;
				$statusPropID = 0;
				break;
		}

		if ($sitePropID && $statusPropID) {
			if (!is_array($arElement['fields'][$sitePropID]))
				$arElement['fields'][$sitePropID] = [$arElement['fields'][$sitePropID]];
			if ((int) $arElement['publish'] && in_array('saffariestate.ru', $arElement['fields'][$sitePropID])  && $arElement['fields'][$statusPropID] == 'В работе')
				$active = 1;
		} elseif (!$sitePropID && $statusPropID) {
			if ((int) $arElement['publish'] && $arElement['fields'][$statusPropID] == 'В работе')
				$active = 1;
		} elseif ((int) $arElement['publish'])
			$active = 1;

		return $active;
	}


	public function getDataJsonFormat($arElement = [], $departmentID = 0, $arDepartments = [])
	{
		if (empty($arElement) || !$departmentID)
			return json_encode([]);
		$arSearch = [];
		$arSearchFields = ['address', 'city', 'zhk_name', 'cian_zhk_name', 'country'];
		$rootDir = dirname(__FILE__) . "/../../../../..";
		$jsonFilePath = "/local/modules/idem.realty/lib/core/objects/admininterface/object_admin_template.json";
		$arTemp = file_get_contents($rootDir . $jsonFilePath);
		$arDataByTabs = json_decode($arTemp, 1);
		$arJsonData = [];
		$currency = new Currency();
		$valute = 'rub';
		$valutePropID = $arDataByTabs['PRICE']['valute']['intrum_property_id'][$departmentID];
		if ($valutePropID) {
			$valuteData = $arElement['fields'][$valutePropID];
			$valute = $currency::getValuteCode($valuteData);
		}
		$areaPropID = $arDataByTabs['AREA']['area']['intrum_property_id'][$departmentID];
		$basePricePropID = $arDataByTabs['PRICE']['base_price']['intrum_property_id'][$departmentID];
		$baseSquarePricePropID = $arDataByTabs['PRICE']['base_square_price']['intrum_property_id'][$departmentID];
		foreach ($arDataByTabs as $key => $arTabData) {
			foreach ($arTabData as $fieldID => $arField) {
				if ($fieldID == "department") {
					$arJsonData['department'] = $arDepartments[$departmentID]['NAME'];
				} elseif ($fieldID == "lot_name") {
					$arJsonData['lot_name'] = $arElement['name'];
				} elseif ($fieldID == "department_id") {
					$arJsonData['department_id'] = $departmentID;
				} elseif ($fieldID == "number") {
					if (!strrpos($arElement['fields']['number'], ',') && !is_null($arElement['fields']['number']))
						$arJsonData['number'] = floatval($arElement['fields']['number']);
					else
						$arJsonData['number'] = "";
				} elseif (isset($arField['intrum_property_id'][$departmentID])) {
					$intrumPropID = $arField['intrum_property_id'][$departmentID];
					if (in_array($fieldID, $arSearchFields)) {
						$arSearch[] = $arElement['fields'][$intrumPropID];
					}
					if ($arField['datatype'] == "point") {
						if (!empty($arElement['fields'][$intrumPropID]) && !empty($arElement['fields'][$intrumPropID]['x']) && !is_null($arElement['fields'][$intrumPropID]['x']) && $arElement['fields'][$intrumPropID]['x'] != "null")
							$arElement['fields'][$intrumPropID] = $arElement['fields'][$intrumPropID]['x'] . ',' . $arElement['fields'][$intrumPropID]['y'];
						else
							$arElement['fields'][$intrumPropID] = "";
					}
					if ($fieldID == "tags") {
						$tagsFieldId = $intrumPropID;
						if ($departmentID == 1) {
							if (strpos($arElement['fields']['776'], 'новостройка') !== false) {
								$tagsFieldId = 1598;
							} else {
								$tagsFieldId = 1678;
							}
						} elseif ($departmentID == 3) {
							if ($arElement['fields']['1646'] == 'Дом') {
								$tagsFieldId = 1679;
							} elseif ($arElement['fields']['1646'] == 'Участок') {
								$tagsFieldId = 1694;
							} elseif ($arElement['fields']['1646'] == '') {
								$tagsFieldId = 1602;
							}
						}
						if (!empty($arElement['fields'][$tagsFieldId]) && is_array($arElement['fields'][$tagsFieldId])) {
							$arElement['fields'][$intrumPropID] = implode(',', $arElement['fields'][$tagsFieldId]);
						}
					}
					if ($fieldID == "highway") {
						if (!empty($arElement['fields'][$intrumPropID])) {
							$arElement['fields'][$intrumPropID] = trim(str_replace(['шоссе', 'ё'], ['', 'е'], $arElement['fields'][$intrumPropID]));
						}
					}
					if ($fieldID == "infrastructure") {
						if (!empty($arElement['fields'][$intrumPropID]) && is_array($arElement['fields'][$intrumPropID]))
							$arElement['fields'][$intrumPropID] = implode(',', $arElement['fields'][$intrumPropID]);
					}
					if ($fieldID == "recom") {
						if ((is_array($arElement['fields'][$intrumPropID]) && in_array("Рекомендуем", $arElement['fields'][$intrumPropID])) || stristr($arElement['fields'][$intrumPropID], "Рекомендуем"))
							$arElement['fields'][$intrumPropID] = 1;
						else
							$arElement['fields'][$intrumPropID] = 0;
					}
					if ($fieldID == "top9" || $fieldID == "top9jk") {
						if ($arElement['fields'][$intrumPropID]=='')
							$arElement['fields'][$intrumPropID] = 99;

					}
					if ($arField['datatype'] == "file") {
						if (!empty($arElement['fields'][$intrumPropID])) {
							$arTempImg = $arElement['fields'][$intrumPropID];
							if (!is_array($arTempImg))
								$arTempImg = [$arTempImg];
							$arImg = [];
							foreach ($arTempImg as $img) {
								$arImg[] = "/upload/realty_img_intrum/" . $img;
								if ($fieldID == "park_img" || $fieldID == "safety_img" || $fieldID == "parking_img" || $fieldID == "place_img" || $fieldID == "kons_img" || $fieldID == "spa_img" || $fieldID == "educ_img" || $fieldID == "park_river_img" || $fieldID == "cafe_img") {
									$arJsonData['all_images_no_votermark'][] = $img;
								}else{
									$arJsonData['all_images'][] = $img;
								}
							}
							$arElement['fields'][$intrumPropID] = implode(',', $arImg);
						}
					}

					if (!empty($arElement['fields'][$intrumPropID])) {
						if (is_numeric($arElement['fields'][$intrumPropID]))
							$arElement['fields'][$intrumPropID] = floatval($arElement['fields'][$intrumPropID]);
						$arJsonData[$fieldID] = $arElement['fields'][$intrumPropID];
					}
				}

				if (!isset($arJsonData[$fieldID])) {
					$arJsonData[$fieldID] = "";
				}
			}
		}
		$arJsonData['active'] = $this->checkStatus($arElement, $departmentID);

		if (isset($arElement['copy']) && $arElement['copy'] > 0 && $arElement['group_id'] != 0) {
			$arJsonData['parent_id'] = floatval($arElement['copy']);
		} else {
			$arJsonData['parent_id'] = 0;
		}
		$basePrice = 0;
		if ($basePricePropID && !empty($arElement['fields'][$basePricePropID])) {
			$basePrice = $arElement['fields'][$basePricePropID];
			$arJsonData['price_rub'] = round($currency->getPriceByCurrency($basePrice, $valute, 'rub'));
			$arJsonData['price_dol'] = round($currency->getPriceByCurrency($basePrice, $valute, 'usd'), 2);
			$arJsonData['price_eur'] = round($currency->getPriceByCurrency($basePrice, $valute, 'eur'), 2);
			$arJsonData['price_pound'] = round($currency->getPriceByCurrency($basePrice, $valute, 'funt'), 2);
			$arJsonData['price_rub'] = floatval($arJsonData['price_rub']);
			$arJsonData['price_dol'] = floatval($arJsonData['price_dol']);
			$arJsonData['price_eur'] = floatval($arJsonData['price_eur']);
			$arJsonData['price_pound'] = floatval($arJsonData['price_pound']);
		}

		if ($baseSquarePricePropID) {
			$squareBasePrice = $arElement['fields'][$baseSquarePricePropID];
			$area = $arElement['fields'][$areaPropID];
			if (empty($squareBasePrice)) {
				if (!is_null($area) && $area > 0 && $basePrice)
					$squareBasePrice = round($basePrice / $area, 2);
			}

			if (!empty($squareBasePrice)) {
				$arJsonData['square_price_rub'] = round($currency->getPriceByCurrency($squareBasePrice, $valute, 'rub'));
				$arJsonData['square_price_dol'] = round($currency->getPriceByCurrency($squareBasePrice, $valute, 'usd'), 2);
				$arJsonData['square_price_eur'] = round($currency->getPriceByCurrency($squareBasePrice, $valute, 'eur'), 2);
				$arJsonData['square_price_pound'] = round($currency->getPriceByCurrency($squareBasePrice, $valute, 'funt'), 2);
				$arJsonData['square_price_rub'] = floatval($arJsonData['square_price_rub']);
				$arJsonData['square_price_dol'] = floatval($arJsonData['square_price_dol']);
				$arJsonData['square_price_eur'] = floatval($arJsonData['square_price_eur']);
				$arJsonData['square_price_pound'] = floatval($arJsonData['square_price_pound']);
			}
		}
		if ($arElement['author']) {
			$arJsonData['manager_id'] = floatval($arElement['author']);
		}
		$arJsonData['date_create'] = date('d.m.Y H:i:s', MakeTimeStamp($arElement['date_add'], 'YYYY-MM-DD HH:MI:SS'));
		$arJsonData['date_update'] = date('d.m.Y H:i:s', MakeTimeStamp($arElement['last_modify'], 'YYYY-MM-DD HH:MI:SS'));
		$arJsonData['sort_date_update'] = MakeTimeStamp($arElement['last_modify'], 'YYYY-MM-DD HH:MI:SS');
		$arJsonData['deal_type'] = self::getDealType($arElement['parent']);

		return $arJsonData;
	}


	public static function getDealType($parent)
	{
		$dealTypeID = $parent;
		switch ($dealTypeID) {
			case 3:
				$dealType = "sale";
				break;
			case 19:
				$dealType = "sale";
				break;
			case 8:
				$dealType = "sale";
				break;
			case 13:
				$dealType = "sale";
				break;
			case 15:
				$dealType = "sale";
				break;
			case 6:
				$dealType = "arenda";
				break;
			case 25:
				$dealType = "arenda";
				break;
			case 10:
				$dealType = "arenda";
				break;
			case 14:
				$dealType = "arenda";
				break;
			case 16:
				$dealType = "arenda";
				break;
			default:
				$dealType = "sale";
				break;
		}

		return $dealType;
	}


	public function saveIntrumImgs($images = [], $departmentID = 1, $no_voter=false)
	{
		if (empty($images))
			return [];

		$arLogData = [];
		$arLogData[] = "Начало копирования картинок интрума " . date('d.m.Y H:i:s');
		$rootDir = dirname(__FILE__) . "/../../../../..";
		$new_images = array_values(array_unique($images));
		$allImages = count($new_images);
		$arLogData[] = "Загрузка изображений для департамента - {$departmentID}: общее число " . $allImages;

		$icloudImgOff = false;
		foreach ($new_images as $key => $image) {
			$num = $key + 1;
			$arLogData[] = "загружено: {$num} из " . $allImages;
			self::arrayLog('copy_images', $arLogData);
			if (file_exists($rootDir . '/upload/realty_img_intrum/' . $image)) {
				continue;
			} else {
				$arLogData[] = "не загружено: {$image}";
			}
			$path = explode(DIRECTORY_SEPARATOR, $image);
			$dir = $rootDir . '/upload/realty_img_intrum';
			if (!is_dir($dir)) {
				mkdir($dir);
			}
			$pathSeparateCnt = count($path) - 1;
			foreach ($path as $key => $folder) {
				if ($key != $pathSeparateCnt)
					$dir .= '/' . $folder;
				mkdir($dir);
			}

			if (!$icloudImgOff) {
				if($no_voter){
					$content = json_decode(file_get_contents("http://saffariestate.intrumnet.com/files/crm/product/{$image}&desktop=1920&tablet=1024&mobile=768"), true);
				}else{
					$content = json_decode(file_get_contents("http://saffariestate.intrumnet.com/files/crm/product/resized800x600/{$image}&desktop=1920&tablet=1024&mobile=768"), true);
				}
				if ($content['desktop']['img']) {
					file_put_contents($rootDir . '/upload/realty_img_intrum/' . $image, file_get_contents($content['desktop']['img']));
					$arLogData[] = "загружено: {$content['desktop']['img']}";
				} else {
					$arLogData[] = "ошибка- не загружено через сервис - image.idemcloud.ru : {$image}";
					$icloudImgOff = true;
				}
			}
			if ($icloudImgOff) {
				if($no_voter){
					if (copy("http://saffariestate.intrumnet.com/files/crm/product/{$image}", $rootDir . '/upload/realty_img_intrum/' . $image)) {
						$arLogData[] = "загружено обычным копированием: /upload/realty_img_intrum/" . $image;
					} else
						$arLogData[] = "ошибка- не загружено, нет доступа на запись: {$image}";
				}else{
					if (copy("http://saffariestate.intrumnet.com/files/crm/product/resized800x600/{$image}", $rootDir . '/upload/realty_img_intrum/' . $image)) {
						$arLogData[] = "загружено обычным копированием: /upload/realty_img_intrum/" . $image;
					} else
						$arLogData[] = "ошибка- не загружено, нет доступа на запись: {$image}";
				}

			}
		}
		self::arrayLog('copy_images', $arLogData);
	}


	public function objectsIndex($time = false)
	{
		\Bitrix\Main\Loader::includeModule('idem.realty');
		$arLogData = [];
		$arLogData[] = "Начало индексации объектов для elastic " . date('d.m.Y H:i:s');
		$filter = ['!INFO' => false];
		if ($time) {
			$filter['>LAST_MODIFY'] = \Bitrix\Main\Type\DateTime::createFromTimestamp($time);
		}
		$elements = \Idem\Realty\Core\Objects\ObjectsTable::getList(['filter' => $filter])->fetchCollection();
		$indexParams = ['index' => ELASTIC_INDEX];
		$dictsParams = ['index' => 'realty_dictionary'];

		$client = \Elasticsearch\ClientBuilder::create()->setHosts(['elastic'])->build();
		if (!$time) {
			if ($client->indices()->exists($indexParams)) {
				$client->indices()->delete($indexParams);
			}
			if ($client->indices()->exists($dictsParams)) {
				$client->indices()->delete($dictsParams);
			}

			$params = [
				'index' => ELASTIC_INDEX,
				'body' => [
					'settings' => [
						'analysis' => [
							'analyzer' => [
								'autocomplete' => [
									'tokenizer' => 'autocomplete',
									'filter' => [
										'lowercase'
									]
								],
								'autocomplete_search' => [
									'tokenizer' => 'lowercase'
								]
							],
							'tokenizer' => [
								'autocomplete' => [
									'type' => 'edge_ngram',
									'min_gram' => '1',
									'max_gram' => '10',
									'token_chars' => [
										'letter', 'digit'
									]
								]
							]
						]
					],
					'mappings' => [
						'properties' => [
							"search" => [
								"type" => "text",
								"analyzer" => "autocomplete",
								"search_analyzer" => 'autocomplete', // "autocomplete_search"
							],
							'address' => [
								'type' => 'keyword'
							],
							"suggest_name" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_name_el" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_address" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_highway" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_city" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_country" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							"suggest_tags" => [
								"type" => "completion",
								"contexts" => [
									[
										"name" => "departament",
										"type" => "category",
										"path" => "cat"
									],
								]
							],
							'city' => [
								'type' => 'keyword'
							],
							'type_real' => [
								'type' => 'keyword'
							],
							'country' => [
								'type' => 'keyword'
							],
							'tags' => [
								'type' => 'keyword'
							],
							'top9' => [
								'type'=> 'keyword',
							],
							'top9jk' => [
								'type'=> 'keyword',
							],
							'metro' => [
								'type' => 'keyword'
							],
							'highway' => [
								'type' => 'keyword'
							],
							'locality' => [
								'type' => 'keyword'
							],
							'district' => [
								'type' => 'keyword'
							],
							'translit_metro' => [
								'type' => 'keyword'
							],
							'translit_finish_type' => [
								'type' => 'keyword'
							],
							'translit_type_real' => [
								'type' => 'keyword'
							],
							'translit_highway' => [
								'type' => 'keyword'
							],
							'translit_locality' => [
								'type' => 'keyword'
							],
							'translit_transport_ring' => [
								'type' => 'keyword'
							],
							'translit_district' => [
								'type' => 'keyword'
							],
							'translit_realty_class' => [
								'type' => 'keyword'
							],
							'house' => [
								'type' => 'keyword'
							],
							'realty_type' => [
								'type' => 'keyword'
							],
							'deal_type' => [
								'type' => 'keyword'
							],
							'department_id' => [
								'type' => 'keyword'
							],
							'parent_id' => [
								'type' => 'keyword',
							],
							'floor' => [
								'type' => 'float',
							],
							'area' => [
								'type' => 'float',
							],
							'realty_class' => [
								'type' => 'keyword',
							],
							'area_building' => [
								'type' => 'float'
							],
							'area_weaving' => [
								'type' => 'float'
							],
							'object_type' => [
								'type' => 'keyword',
							],
							'isNewBuilding' => [
								'type' => 'keyword',
							],
							'translit_object_type' => [
								'type' => 'keyword',
							],
							'translit_tags' => [
								'type' => 'keyword',
							],
							'commerc_type' => [
								'type' => 'keyword',
							],
							'country_type' => [
								'type' => 'keyword',
							],
							'foreign_type' => [
								'type' => 'keyword',
							],
							'transport_ring' => [
								'type' => 'keyword',
							],
							'finish_type' => [
								'type' => 'keyword',
							],
							'built_status' => [
								'type' => 'keyword',
							],
							'parking' => [
								'type' => 'keyword',
							],
							'translit_country' => [
								'type' => 'keyword',
							],
							'translit_city' => [
								'type' => 'keyword',
							],
							'translit_parking' => [
								'type' => 'keyword',
							],
							'built_type' => [
								'type' => 'keyword',
							],
							'forest' => [
								'type' => 'keyword',
							],
							'water' => [
								'type' => 'keyword',
							],
							'date_update' => [
								'type' => 'keyword',
							],
							'finish' => [
								'type' => 'keyword',
							],
							'translit_finish' => [
								'type' => 'keyword'
							],
							'views' => [
								'type' => 'keyword',
							],
							'translit_views' => [
								'type' => 'keyword'
							]
						]
					]
				]
			];

			$client->indices()->create($params);
		}
		$arTranslitFields = ['tags', 'object_type', 'finish_type', 'built_status', 'highway', 'locality', 'metro', 'country', 'parking', 'country_type', 'realty_type', 'forest', 'water', 'commerc_type', 'built_type', 'district', 'locality', 'transport_ring', 'foreign_type', 'finish', 'views','city','realty_class','type_real'];
		$dictsTranslite = [];
		foreach ($elements as $elementObj) {
			$element = $elementObj->collectValues();
			$info = $element['INFO'];
			$info['tags'] = explode(',', $info['tags']);
			if (strpos($info['realty_type'], 'новостройка') !== false) {
				$info['tags'][] = 'Новостройка';
				$info['isNewBuilding'] = 'Новостройка';
			} else {
				if ($element['DEPARTAMENT_ID'] == LIVE_DEPARTAMENT) {
					$info['tags'][] = 'Вторичка';
					$info['isNewBuilding'] = 'Вторичка';
				}
			}
			if ($element['DEPARTAMENT_ID'] == COUNTRY_DEPARTAMENT && $info['isJk'] === 1) {
				$info['object_type'] = 'Поселок';
			}
			if ($info['exclusive'] == 1) {
				$info['tags'][] = 'Эксклюзив';
			}
			$info['sort_date_update'] = (int) $info['sort_date_update'];
			foreach ($arTranslitFields as $translitField) {
				if (is_array($info[$translitField])) {
					foreach ($info[$translitField] as $value) {
						$transValue = \Cutil::translit($value, "ru", self::TRANSLIT);
						$dictsTranslite[$value] = $transValue;
						$info['translit_' . $translitField][] = $transValue;
					}
				} else {
					$transValue = \Cutil::translit($info[$translitField], "ru", self::TRANSLIT);
					$dictsTranslite[$info[$translitField]] = $transValue;
					$info['translit_' . $translitField] = [$transValue];
				}
			}
			foreach ($info as &$value) {
				if (is_array($value)) {
					foreach ($value as $index => $item) {
						if ($item == '') {
							array_splice($value, $index, 1);
						}
					}
				}
			}
			$info = Convert::toElasticInfo($info);
			if ($info['isJk']) {
				$info['suggest_name'] = [
					'input' => preg_split("/[\, .]/", $info['lot_name']),
					"contexts" => [
						"departament" => $element['DEPARTAMENT_ID'],
					]
				];
			}
			if ($element['DEPARTAMENT_ID'] == FOREIGN_DEPARTAMENT) {
				$info['suggest_name_el'] = [
					'input' => preg_split("/[\, .]/", $info['lot_name']),
					"contexts" => [
						"departament" => $element['DEPARTAMENT_ID'],
					]
				];
			}
			if ($info['address']) {
				$info['suggest_address'] = [
					'input' => preg_split("/[\, .]/", $info['address']),
					"contexts" => [
						"departament" => $element['DEPARTAMENT_ID'],
					]
				];
			}
			if ($info['highway']) {
				$info['suggest_highway'] = [
					'input' => preg_split("/[\, .]/", $info['highway']),
					"contexts" => [
						"departament" => $element['DEPARTAMENT_ID'],
					]
				];
			}
			if ($element['DEPARTAMENT_ID'] == FOREIGN_DEPARTAMENT) {
				if ($info['city']) {
					$info['suggest_city'] = [
						'input' => preg_split("/[\, .]/", $info['city']),
						"contexts" => [
							"departament" => $element['DEPARTAMENT_ID'],
						]
					];
				}
				if ($info['country']) {
					$info['suggest_country'] = [
						'input' => preg_split("/[\, .]/", $info['country'][0]),
						"contexts" => [
							"departament" => $element['DEPARTAMENT_ID'],
						]
					];
				}
				if ($info['tags']) {
					$info['suggest_tags'] = [
						'input' => $info['tags'],
						"contexts" => [
							"departament" => $element['DEPARTAMENT_ID'],
						]
					];
				}
			}
			$id = $element['ID'];

			if ($element['DEPARTAMENT_ID'] == LIVE_DEPARTAMENT) {
				$addressConfig = ['address', 'house'];
				$info['search'] = [
					$info['lot_name'],
					$info['cian_zhk_name'],
					Util::generatedFields($addressConfig, $info),
					$id,
				];
			} else if ($element['DEPARTAMENT_ID'] == COUNTRY_DEPARTAMENT) {
				$addressConfig = ['district_area', 'highway|postfix:шоссе', 'distance_mkad|postfix:км'];
				$info['search'] = [
					$info['lot_name'],
					$info['highway'],
					$info['cian_zhk_name'],
					Util::generatedFields($addressConfig, $info),
					$id,
				];
			}else if ($element['DEPARTAMENT_ID'] == FOREIGN_DEPARTAMENT) {
				$addressConfig = ['country', 'city'];
				$info['search'] = [
					$info['lot_name'],
					$info['country'],
					$info['city'],
					$info['tags'],
					Util::generatedFields($addressConfig, $info),
					$id,
				];
			}else if ($element['DEPARTAMENT_ID'] == COMMERC_DEPARTAMENT) {
				$addressConfig = ['address', 'house'];
				$info['search'] = [
					$info['lot_name'],
					$info['address'],
					Util::generatedFields($addressConfig, $info),
					$id,
				];
			}
			foreach( ['area','finish_type','rooms','parking','area_building','area_weaving','distance_mkad','country_type','bedrooms','price_eur','price_rub','price_dol','price_pound', 'finish', 'views', 'country','city','realty_class','square_price_eur','square_price_rub','square_price_dol','type_real'] as $field) {
				if (is_array($info[$field])) {
					foreach ($info[$field] as &$value) {
						if ($value == '') {
							$value = null;
						}
					}
					unset($value);
				}
			}
			$arLogData[] = "Индексирован элемент {$id}";
			if ($info['main_img'] != '') {
				$info['main_img'] = self::cropImage($info['main_img']);
			}
			if ($info['zhk_main_img'] != '') {
				$info['zhk_main_img'] = self::cropImage($info['zhk_main_img']);
			}
			$params = [
				'index' => ELASTIC_INDEX,
				'type' => '_doc',
				'id' => $id,
				'body' => $info,
			];
			if ($time) {
				$params['body'] = ['doc'=>$info, 'doc_as_upsert'=>true];
				$response = $client->update($params);
			} elseif ($info['active']) {
				$response = $client->index($params);
			}
		}
		foreach ($dictsTranslite as $name => $value) {
			if ($value != '') {
				$params = array_merge([
					'type' => '_doc',
					'id' => $value,
					'body' => [
						'doc' => [
							"WORD" => $name,
							"CODE" => $value
						],
						'doc_as_upsert'=>true
					]
				], $dictsParams);
				$client->update($params);
			}
		}
		$arLogData[] = "Индексация закончена " . date('d.m.Y H:i:s');
		self::arrayLog('objects_index', $arLogData);
	}
}
