<?php

namespace app\Util;

class Convert
{
	const FIELDS = ['area', 'finish_type', 'rooms', 'parking', 'object_type', 'translit_object_type', 'price_eur', 'price_dol', 'price_rub', 'price_pound', 'area_building', 'area_weaving', 'distance_mkad', 'country_type', 'bedrooms', 'foreign_type', 'finish', 'views', 'country'];
	const ONLY_ONE = ['finish_type'];
	static function toElasticInfo($info)
	{
		foreach (self::FIELDS as $key) {
			if (!is_array($info[$key])) {
				$info[$key] = [$info[$key]];
			}
		}
		return $info;
	}

	static function fromElasticFields($info)
	{

		foreach (self::FIELDS as $key) {
			if (is_array($info[$key])) {
				if (count($info[$key]) == 1) {
					$info[$key] = $info[$key][0];
				} elseif (array_search($key, self::ONLY_ONE) !== false) {
					if ($key == 'finish_type') {
						$index = array_search('c отделкой', $info[$key]);
						$info[$key] = $info[$key][$index];
					} else {
						$info[$key] = $info[$key][0];
					}
				}
			}
		}
		return $info;
	}
}
