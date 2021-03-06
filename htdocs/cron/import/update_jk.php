<?php
if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

$connection = \Bitrix\Main\Application::getConnection();
$connection->queryExecute("SET SESSION group_concat_max_len = 1000000;");
$result = $connection->queryExecute("
UPDATE i_objects as t1 INNER JOIN (
SELECT
*
FROM (SELECT
  MAX(LAST_MODIFY) as LAST_MODIFY,
  JSON_EXTRACT(INFO,'$.parent_id') as parent_id,
  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.deal_type')) = 'sale', 1, 0)) as sale,
  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.deal_type')) != 'sale', 1, 0)) as rent,
  MAX(JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.active'))) as active,
  JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.realty_type')) as realty_type,

  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.object_type')) = 'офис', 1, 0)) as count_offise,
  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.object_type')) = 'Дом', 1, 0)) as count_house,
  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.object_type')) = 'Участок', 1, 0)) as count_weaving,
  SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.object_type')) = 'Таунхаус', 1, 0)) as count_taun,

  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.area')), ']') as area,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.finish_type')), ']') as finish_type,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.rooms')), ']') as rooms,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.parking')), ']') as parking,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.object_type')), ']') as object_type,

  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.price_eur')), ']') as price_eur,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.price_dol')), ']') as price_dol,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.price_rub')), ']') as price_rub,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.price_pound')), ']') as price_pound,

  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.area_building')), ']') as area_building,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.area_weaving')), ']') as area_weaving,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.distance_mkad')), ']') as distance_mkad,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.country_type')), ']') as country_type,
  CONCAT('[', GROUP_CONCAT(DISTINCT JSON_EXTRACT(INFO,'$.bedrooms')), ']') as bedrooms
  FROM i_objects WHERE active = 1 group by parent_id having parent_id <> 0) as t3
) as t2 ON t1.ID = t2.parent_id SET t1.ACTIVE=t2.active, t1.LAST_MODIFY = IF(t1.LAST_MODIFY < t2.LAST_MODIFY,t2.LAST_MODIFY,t1.LAST_MODIFY), INFO = JSON_SET(INFO,
	'$.jk_sale_count', t2.sale,
	'$.jk_rent_count', t2.rent,
    '$.date_update', t2.LAST_MODIFY,
	'$.active', t2.active,
	'$.isJk', 1,
    '$.realty_type', t2.realty_type,

    '$.jk_count_offise', t2.count_offise,
    '$.jk_count_house', t2.count_house,
	'$.jk_count_weaving', t2.count_weaving,
	'$.jk_count_taun', t2.count_taun,

	'$.area', JSON_QUERY(t2.area, '$'),
	'$.finish_type', JSON_QUERY(t2.finish_type, '$'),
	'$.rooms', JSON_QUERY(t2.rooms, '$'),
	'$.parking', JSON_QUERY(t2.parking, '$'),
	'$.object_type', JSON_QUERY(t2.object_type, '$'),

	'$.price_eur', JSON_QUERY(t2.price_eur, '$'),
	'$.price_dol', JSON_QUERY(t2.price_dol, '$'),
  '$.price_rub', JSON_QUERY(t2.price_rub, '$'),
  '$.price_pound', JSON_QUERY(t2.price_pound, '$'),

	'$.area_building', JSON_QUERY(t2.area_building, '$'),
	'$.area_weaving', JSON_QUERY(t2.area_weaving, '$'),
	'$.distance_mkad', JSON_QUERY(t2.distance_mkad, '$'),
	'$.country_type', JSON_QUERY(t2.country_type, '$'),
	'$.bedrooms', JSON_QUERY(t2.bedrooms, '$'))
");
$result = $connection->queryExecute("UPDATE i_objects as t4 INNER JOIN (
SELECT t1.ID, t1.PARENT_ID,  JSON_UNQUOTE(JSON_EXTRACT(t2.INFO,'$.lot_name')) as JK_NAME FROM (SELECT ID, JSON_UNQUOTE(JSON_EXTRACT(INFO, '$.parent_id')) as PARENT_ID FROM i_objects HAVING parent_id <> 0) as t1 LEFT JOIN i_objects as t2 on t1.PARENT_ID = t2.ID) as t5 ON t4.ID = t5.ID SET INFO = JSON_SET(INFO, '$.cian_zhk_name', t5.JK_NAME)");

//Update districts-metro-locality

$resultAllMetro = $connection->query("select
DISTINCT JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.metro')) as metro,
JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.district')) as district
from i_objects WHERE active=1")->fetchAll();
$arMetro = $connection->query("select * from i_metro_district")->fetchAll();
foreach ($resultAllMetro as $k => $item) {
    $item["metroEn"] = \Cutil::translit($item["metro"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $item["districtEn"] = \Cutil::translit($item["district"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $key = array_search($item["metroEn"], array_column($arMetro, 'metro'));
    if ($item["metroEn"] != '' && $key == false) {
        $results = $connection->queryExecute(" INSERT INTO i_metro_district SET metro='" . $item['metroEn'] . "', district='" . $item['districtEn'] . "'");
    }
}

$resultAllLocality = $connection->query("select
DISTINCT JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.locality')) as locality,
JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.district')) as district
from i_objects WHERE active=1")->fetchAll();
$arLocality = $connection->query("select * from i_locality_district")->fetchAll();
foreach ($resultAllLocality as $k => $item) {
    $item["localityEn"] = \Cutil::translit($item["locality"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $item["districtEn"] = \Cutil::translit($item["district"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $key = array_search($item["localityEn"], array_column($arLocality, 'locality'));
    if ($item["localityEn"] != '' && $key == false) {
        $results = $connection->queryExecute(" INSERT INTO i_locality_district SET locality='" . $item['localityEn'] . "', district='" . $item['districtEn'] . "'");
    }
}

$resultAllCity = $connection->query("select
DISTINCT JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.city')) as city,
JSON_UNQUOTE(JSON_EXTRACT(i_objects.INFO,'$.country')) as country
from i_objects WHERE active=1")->fetchAll();
$arCity = $connection->query("select * from i_city_country")->fetchAll();
foreach ($resultAllCity as $k => $item) {
    $item["cityEn"] = \Cutil::translit($item["city"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $item["countryEn"] = \Cutil::translit($item["country"], "ru", ["replace_space" => "-", "replace_other" => "-"]);
    $key = array_search($item["cityEn"], array_column($arCity, 'city'));
    if ($item["cityEn"] != '' && $key == false && $item["countryEn"] != '') {
        $results = $connection->queryExecute(" INSERT INTO i_city_country SET city='" . $item['cityEn'] . "', country='" . $item['countryEn'] . "'");
    }
}
