SET SESSION group_concat_max_len = 1000000;
UPDATE i_objects as t1 INNER JOIN (
SELECT 
*
FROM (SELECT
 JSON_EXTRACT(INFO,'$.parent_id') as parent_id,
 SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.deal_type')) = 'sale', 1, 0)) as sale,
 SUM(IF (JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.deal_type')) != 'sale', 1, 0)) as rent,
 MAX(JSON_UNQUOTE(JSON_EXTRACT(INFO,'$.active'))) as active,

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
 FROM i_objects group by parent_id having parent_id <> 0) as t3
) as t2 ON t1.ID = t2.parent_id SET t1.ACTIVE=t2.active, INFO = JSON_SET(INFO, 
	'$.jk_sale_count', t2.sale, 
	'$.jk_rent_count', t2.rent, 
	'$.active', t2.active, 
	'$.isJk', 1, 

	'$.area', CAST(t2.area as JSON), 
	'$.finish_type', CAST(t2.finish_type as JSON), 
	'$.rooms', CAST(t2.rooms as JSON),
	'$.parking', CAST(t2.parking as JSON),
	'$.object_type', CAST(t2.object_type as JSON),

	'$.price_eur', CAST(t2.price_eur as JSON),	
	'$.price_dol', CAST(t2.price_dol as JSON),
	'$.price_rub', CAST(t2.price_rub as JSON),
	'$.price_pound', CAST(t2.price_pound as JSON),

	'$.area_building', CAST(t2.area_building as JSON), 
	'$.area_weaving', CAST(t2.area_weaving as JSON),
	'$.distance_mkad', CAST(t2.distance_mkad as JSON),
	'$.country_type', CAST(t2.country_type as JSON),
	'$.bedrooms', CAST(t2.bedrooms as JSON))

