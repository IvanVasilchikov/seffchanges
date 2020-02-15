<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Elasticsearch\ClientBuilder;
use Idem\Realty\Import\Intrum;
use Idem\Realty\Realty\Data;
use app\Util\Util;

trait FilterFieldsTrait
{
	public function generate_input($data)
	{
		$json = [
			"input" => [
				"placeholder" => $data['placeholder'] ? $data['placeholder'] : $this->res->get('main_' . LANGUAGE_ID . '.filter_' . $data['code']),
				"value" => $data['value'],
			],
			"name" => $data['code'],
			"departament_id" => $this->departmentID,
			"type" => "input"
		];
		if ($data['condition']) {
			$json['condition'] = $data['condition'];
		}
		return $json;
	}
	public function generate_radio($data)
	{
		$values = [];
		foreach ($data['values'] as $key => $value) {
			$values[] = [
				"id" => $data['code'] . $key,
				"value" => $value['value'],
				"text" => ($value['text'] != $value['value']) ? $value['text'] : $this->res->get('main_' . LANGUAGE_ID . '.filter_' . $value['value']),
				"checked" => ($data['value'] != '') ? ($data['value'] == $value['value']) : ($key == 0)
			];
		}
		$json = [
			"type" => "radio",
			"name" => $data['code'],
			"values" => $values
		];
		if ($data['condition']) {
			$json['condition'] = $data['condition'];
		}
		return $json;
	}
	public function generate_select($data)
	{
		$values = [];
		if ($data['empty'] != 'false') {
			array_splice($data['values'], 0, 0, [[
				"text" => $this->res->get('site_' . LANGUAGE_ID . '.no_select'),
				"value" => "",
			]]);
		}
		$selected = false;
		foreach ($data['values'] as $key => $value) {
			$active = ($data['value'] != '') ? ($data['value'] == $value['value']) : ($key == 0);
			if ($active) {
				$selected = true;
			}
			$values[] = [
				"value" => $value['value'],
				"text" => $value['text'] ? $value['text'] : $this->res->get('main_' . LANGUAGE_ID . '.filter_' . $value['value']),
				"selected" => $active
			];
		}
		if (!$selected) {
			$values[0]['selected'] = true;
		}
		$json = [
			"type" => "select",
			"name" => $data['code'],
			"values" => $values,
			"title" => $data['title'] ? $data['title'] : $this->res->get('main_' . LANGUAGE_ID . '.filter_' . $data['code']),
			"style" => $data['style']
		];
		if ($data['condition']) {
			$json['condition'] = $data['condition'];
		}
		return $json;
	}
	public function generate_hidden($data)
	{
		$json = [
			"type" => "hidden",
			"name" => $data['code'],
			"value" => $data['value'],
		];
		if ($data['condition']) {
			$json['condition'] = $data['condition'];
		}
		return $json;
	}
	public function generate_range($data)
	{
		$json = [
			"type" => "range",
			"name" => $data['code'],
			"range" => [
				"inputs" => [
					"title" => $data['title'] ? $data['title'] : $this->res->get('main_' . LANGUAGE_ID . '.filter_' . $data['code']),
					"min" => [
						"name" => "{$data['code']}[from]",
						"placeholder" => $this->res->get('main_' . LANGUAGE_ID . '.filter_range_from'),
						"value" => $data['value'][0]
					],
					"max" => [
						"name" => "{$data['code']}[to]",
						"placeholder" => $this->res->get('main_' . LANGUAGE_ID . '.filter_range_to'),
						"value" => $data['value'][1]
					]
				]
			]
		];
		if ($data['condition']) {
			$json['condition'] = $data['condition'];
		}
		return $json;
	}

	public function generate_price($data)
	{
		$res = $this->generate_range($data);
		$priceRange = [
			"currency" => [
				"name" => "currency",
				"values" => [
					[
						"text" => "₽",
						"value" => "rub",
						"selected" => true
					],
					[
						"text" => "$",
						"value" => "dol"
					],
					[
						"text" => "€",
						"value" => "eur"
					]
				]
			],
		];
		if ($this->departmentID  == FOREIGN_DEPARTAMENT) {
			$priceRange["currency"]["values"][3] = ["text" => "£","value" => "pound"];
		}
		if ($data['range']) {
			$priceRange['range'] = [
				"name" => "range",
				"values" => [
						[
							"text" => $this->res->get('main_' . LANGUAGE_ID . '.filter_price_total'),
							"value" => "general",
							"selected" => true
						],
						[
							"text" => $this->res->get('main_' . LANGUAGE_ID . '.filter_price_square'),
							"value" => "meters"
						]
					],
			];
		}
		$res['range'] = array_merge($res['range'], $priceRange);

		$res['range']["inputs"]["dropdown"]=[
			"dealType"=> "sale",
			"sale"=> [
				"rub"=> [
					"title"=> "Цена, млн.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 30000000,
							"text"=> "30"
						],
						[
							"value"=> 50000000,
							"text"=> "50"
						],
						[
							"value"=> 75000000,
							"text"=> "75"
						],
						[
							"value"=> 100000000,
							"text"=> "100"
						],
						[
							"value"=> 200000000,
							"text"=> "200"
						],
						[
							"value"=> 500000000,
							"text"=> "500"
						]
					],
					"max"=> [
						[
							"value"=> 30000000,
							"text"=> "30"
						],
						[
							"value"=> 50000000,
							"text"=> "50"
						],
						[
							"value"=> 75000000,
							"text"=> "75"
						],
						[
							"value"=> 100000000,
							"text"=> "100"
						],
						[
							"value"=> 200000000,
							"text"=> "200"
						],
						[
							"value"=> 500000000,
							"text"=> "500"
						],
						[
							"text"=> "1 000+"
						]
					]
				],
				"dol"=> [
					"title"=> "Цена, млн.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 500000,
							"text"=> "0.5"
						],
						[
							"value"=> 1000000,
							"text"=> "1"
						],
						[
							"value"=> 1500000,
							"text"=> "1.5"
						],
						[
							"value"=> 3000000,
							"text"=> "3"
						],
						[
							"value"=> 8000000,
							"text"=> "8"
						],
						[
							"value"=> 10000000,
							"text"=> "10"
						]
					],
					"max"=> [
						[
							"value"=> 500000,
							"text"=> "0.5"
						],
						[
							"value"=> 1000000,
							"text"=> "1"
						],
						[
							"value"=> 1500000,
							"text"=> "1.5"
						],
						[
							"value"=> 3000000,
							"text"=> "3"
						],
						[
							"value"=> 8000000,
							"text"=> "8"
						],
						[
							"value"=> 10000000,
							"text"=> "10"
						],
						[
							"text"=> "10+"
						]
					]
				],
				"eur"=> [
					"title"=> "Цена, млн.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 500000,
							"text"=> "0.5"
						],
						[
							"value"=> 1000000,
							"text"=> "1"
						],
						[
							"value"=> 1500000,
							"text"=> "1.5"
						],
						[
							"value"=> 3000000,
							"text"=> "3"
						],
						[
							"value"=> 8000000,
							"text"=> "8"
						],
						[
							"value"=> 10000000,
							"text"=> "10"
						]
					],
					"max"=> [
						[
							"value"=> 500000,
							"text"=> "0.5"
						],
						[
							"value"=> 1000000,
							"text"=> "1"
						],
						[
							"value"=> 1500000,
							"text"=> "1.5"
						],
						[
							"value"=> 3000000,
							"text"=> "3"
						],
						[
							"value"=> 8000000,
							"text"=> "8"
						],
						[
							"value"=> 10000000,
							"text"=> "10"
						],
						[
							"text"=> "10+"
						]
					]
				]
			],
			"arenda"=> [
				"rub"=> [
					"title"=> "Цена, тыс.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 200000,
							"text"=> "200"
						],
						[
							"value"=> 300000,
							"text"=> "300"
						],
						[
							"value"=> 500000,
							"text"=> "500"
						],
						[
							"value"=> 750000,
							"text"=> "750"
						]
					],
					"max"=> [
						[
							"value"=> 200000,
							"text"=> "200"
						],
						[
							"value"=> 300000,
							"text"=> "300"
						],
						[
							"value"=> 500000,
							"text"=> "500"
						],
						[
							"value"=> 750000,
							"text"=> "750"
						],
						[
							"text"=> "1000+"
						]
					]
				],
				"dol"=> [
					"title"=> "Цена, тыс.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 3000,
							"text"=> "3"
						],
						[
							"value"=> 5000,
							"text"=> "5"
						],
						[
							"value"=> 7000,
							"text"=> "7"
						],
						[
							"value"=> 10000,
							"text"=> "10"
						],
						[
							"value"=> 15000,
							"text"=> "15"
						]
					],
					"max"=> [
						[
							"value"=> 3000,
							"text"=> "3"
						],
						[
							"value"=> 5000,
							"text"=> "5"
						],
						[
							"value"=> 7000,
							"text"=> "7"
						],
						[
							"value"=> 10000,
							"text"=> "10"
						],
						[
							"value"=> 15000,
							"text"=> "15"
						],
						[
							"text"=> "15+"
						]
					]
				],
				"eur"=> [
					"title"=> "Цена, тыс.",
					"min"=> [
						[
							"value"=> 0,
							"text"=> "0"
						],
						[
							"value"=> 3000,
							"text"=> "3"
						],
						[
							"value"=> 5000,
							"text"=> "5"
						],
						[
							"value"=> 7000,
							"text"=> "7"
						],
						[
							"value"=> 10000,
							"text"=> "10"
						],
						[
							"value"=> 15000,
							"text"=> "15"
						]
					],
					"max"=> [
						[
							"value"=> 3000,
							"text"=> "3"
						],
						[
							"value"=> 5000,
							"text"=> "5"
						],
						[
							"value"=> 7000,
							"text"=> "7"
						],
						[
							"value"=> 10000,
							"text"=> "10"
						],
						[
							"value"=> 15000,
							"text"=> "15"
						],
						[
							"text"=> "15+"
						]
					]
				]
			]
		];
		if ($this->departmentID  == FOREIGN_DEPARTAMENT) {
			$res['range']["inputs"]["dropdown"]["sale"]["pound"] =
			[
				"title"=> "Цена, млн.",
				"min"=> [
					[
						"value"=> 0,
						"text"=> "0"
					],
					[
						"value"=> 500000,
						"text"=> "0.5"
					],
					[
						"value"=> 1000000,
						"text"=> "1"
					],
					[
						"value"=> 1500000,
						"text"=> "1.5"
					],
					[
						"value"=> 3000000,
						"text"=> "3"
					],
					[
						"value"=> 8000000,
						"text"=> "8"
					],
					[
						"value"=> 10000000,
						"text"=> "10"
					]
				],
				"max"=> [
					[
						"value"=> 500000,
						"text"=> "0.5"
					],
					[
						"value"=> 1000000,
						"text"=> "1"
					],
					[
						"value"=> 1500000,
						"text"=> "1.5"
					],
					[
						"value"=> 3000000,
						"text"=> "3"
					],
					[
						"value"=> 8000000,
						"text"=> "8"
					],
					[
						"value"=> 10000000,
						"text"=> "10"
					],
					[
						"text"=> "10+"
					]
				]
			];
			$res['range']["inputs"]["dropdown"]["arenda"]["pound"] =
			[
				"title"=> "Цена, тыс.",
				"min"=> [
					[
						"value"=> 0,
						"text"=> "0"
					],
					[
						"value"=> 3000,
						"text"=> "3"
					],
					[
						"value"=> 5000,
						"text"=> "5"
					],
					[
						"value"=> 7000,
						"text"=> "7"
					],
					[
						"value"=> 10000,
						"text"=> "10"
					],
					[
						"value"=> 15000,
						"text"=> "15"
					]
				],
				"max"=> [
					[
						"value"=> 3000,
						"text"=> "3"
					],
					[
						"value"=> 5000,
						"text"=> "5"
					],
					[
						"value"=> 7000,
						"text"=> "7"
					],
					[
						"value"=> 10000,
						"text"=> "10"
					],
					[
						"value"=> 15000,
						"text"=> "15"
					],
					[
						"text"=> "15+"
					]
				]
			];
		}
		if ($this->departmentID  == COMMERC_DEPARTAMENT || $this->departmentID  == COMMERC_OFFICE || $this->departmentID  == COMMERC_SKLAD || $this->departmentID  == COMMERC_TORG) {
			$res['range']["inputs"]["dropdown"]=[
				"dealType"=> "sale",
				"rangeDependency"=> true,
				"sale_general"=> [
					"rub"=> [
						"title"=> "Цена, млн.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 50000000,
							"text"=> "50"
							],
							[
							"value"=> 100000000,
							"text"=> "100"
							],
							[
							"value"=> 200000000,
							"text"=> "200"
							],
							[
							"value"=> 300000000,
							"text"=> "300"
							]
						],
						"max"=> [
							[
							"value"=> 50000000,
							"text"=> "50"
							],
							[
							"value"=> 100000000,
							"text"=> "100"
							],
							[
							"value"=> 200000000,
							"text"=> "200"
							],
							[
							"value"=> 300000000,
							"text"=> "300"
							],
							[
							"value"=> "",
							"text"=> "300+"
							]
						]
					],
					"dol"=> [
						"title"=> "Цена, млн.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 1,
							"text"=> "1"
							],
							[
							"value"=> 2,
							"text"=> "2"
							],
							[
							"value"=> 3,
							"text"=> "3"
							]
						],
						"max"=> [
							[
							"value"=> 1,
							"text"=> "1"
							],
							[
							"value"=> 2,
							"text"=> "2"
							],
							[
							"value"=> 3,
							"text"=> "3"
							],
							[
							"value"=> "",
							"text"=> "4+"
							]
						]
					],
					"eur"=> [
						"title"=> "Цена, млн.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 1,
							"text"=> "1"
							],
							[
							"value"=> 2,
							"text"=> "2"
							],
							[
							"value"=> 3,
							"text"=> "3"
							]
						],
						"max"=> [
							[
							"value"=> 1,
							"text"=> "1"
							],
							[
							"value"=> 2,
							"text"=> "2"
							],
							[
							"value"=> 3,
							"text"=> "3"
							],
							[
							"value"=> "",
							"text"=> "4+"
							]
						]
					]
				],
				"sale_meters"=> [
					"rub"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 200000,
							"text"=> "200"
							],
							[
							"value"=> 300000,
							"text"=> "300"
							],
							[
							"value"=> 500000,
							"text"=> "500"
							],
							[
							"value"=> 750000,
							"text"=> "750"
							]
						],
						"max"=> [
							[
							"value"=> 200000,
							"text"=> "200"
							],
							[
							"value"=> 300000,
							"text"=> "300"
							],
							[
							"value"=> 500000,
							"text"=> "500"
							],
							[
							"value"=> 750000,
							"text"=> "750"
							],
							[
							"value"=> "",
							"text"=> "750+"
							]
						]
					],
					"dol"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 2000,
							"text"=> "2"
							],
							[
							"value"=> 4000,
							"text"=> "4"
							],
							[
							"value"=> 5000,
							"text"=> "5"
							]
						],
						"max"=> [
							[
							"value"=> 2000,
							"text"=> "2"
							],
							[
							"value"=> 4000,
							"text"=> "4"
							],
							[
							"value"=> 5000,
							"text"=> "5"
							],
							[
							"value"=> "",
							"text"=> "5+"
							]
						]
					],
					"eur"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 2000,
							"text"=> "2"
							],
							[
							"value"=> 4000,
							"text"=> "4"
							],
							[
							"value"=> 5000,
							"text"=> "5"
							]
						],
						"max"=> [
							[
							"value"=> 2000,
							"text"=> "2"
							],
							[
							"value"=> 4000,
							"text"=> "4"
							],
							[
							"value"=> 5000,
							"text"=> "5"
							],
							[
							"value"=> "",
							"text"=> "5+"
							]
						]
					]
				],
				"rent_meters_per_year"=> [
					"rub"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 10000,
							"text"=> "10"
							],
							[
							"value"=> 20000,
							"text"=> "20"
							],
							[
							"value"=> 30000,
							"text"=> "30"
							],
							[
							"value"=> 40000,
							"text"=> "40"
							]
						],
						"max"=> [
							[
							"value"=> 10000,
							"text"=> "10"
							],
							[
							"value"=> 20000,
							"text"=> "20"
							],
							[
							"value"=> 30000,
							"text"=> "30"
							],
							[
							"value"=> 40000,
							"text"=> "40"
							],
							[
							"value"=> "",
							"text"=> "40+"
							]
						]
					],
					"dol"=> [
						"title"=> "Цена",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 200,
							"text"=> "200"
							],
							[
							"value"=> 400,
							"text"=> "400"
							],
							[
							"value"=> 600,
							"text"=> "600"
							],
							[
							"value"=> 800,
							"text"=> "800"
							]
						],
						"max"=> [
							[
							"value"=> 200,
							"text"=> "200"
							],
							[
							"value"=> 400,
							"text"=> "400"
							],
							[
							"value"=> 600,
							"text"=> "600"
							],
							[
							"value"=> 800,
							"text"=> "800"
							],
							[
							"value"=> "",
							"text"=> "800+"
							]
						]
					],
					"eur"=> [
						"title"=> "Цена",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 200,
							"text"=> "200"
							],
							[
							"value"=> 400,
							"text"=> "400"
							],
							[
							"value"=> 600,
							"text"=> "600"
							],
							[
							"value"=> 800,
							"text"=> "800"
							]
						],
						"max"=> [
							[
							"value"=> 200,
							"text"=> "200"
							],
							[
							"value"=> 400,
							"text"=> "400"
							],
							[
							"value"=> 600,
							"text"=> "600"
							],
							[
							"value"=> 800,
							"text"=> "800"
							],
							[
							"value"=> "",
							"text"=> "800+"
							]
						]
					]
				],
				"rent_general_month"=> [
					"rub"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 300000,
							"text"=> "300"
							],
							[
							"value"=> 600000,
							"text"=> "600"
							]
						],
						"max"=> [
							[
							"value"=> 300000,
							"text"=> "300"
							],
							[
							"value"=> 600000,
							"text"=> "600"
							],
							[
							"value"=> "",
							"text"=> "600+"
							]
						]
					],
					"dol"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 5,
							"text"=> "5"
							],
							[
							"value"=> 10,
							"text"=> "10"
							],
							[
							"value"=> 30,
							"text"=> "30"
							]
						],
						"max"=> [
							[
							"value"=> 5,
							"text"=> "5"
							],
							[
							"value"=> 10,
							"text"=> "10"
							],
							[
							"value"=> 30,
							"text"=> "30"
							],
							[
							"value"=> "",
							"text"=> "30+"
							]
						]
					],
					"eur"=> [
						"title"=> "Цена, тыс.",
						"min"=> [
							[
							"value"=> 0,
							"text"=> "0"
							],
							[
							"value"=> 5,
							"text"=> "5"
							],
							[
							"value"=> 10,
							"text"=> "10"
							],
							[
							"value"=> 30,
							"text"=> "30"
							]
						],
						"max"=> [
							[
							"value"=> 5,
							"text"=> "5"
							],
							[
							"value"=> 10,
							"text"=> "10"
							],
							[
							"value"=> 30,
							"text"=> "30"
							],
							[
							"value"=> "",
							"text"=> "30+"
							]
						]
					]
				]
			];
			$res['range']["range"]=[
				"name"=> "range",
                "values"=> [
					[
						"text"=> "Общая",
						"value"=> "general",
						"selected"=> true
					],
					[
						"text"=> "За м²",
						"value"=> "meters"
					]
                ],
                "additional"=> [
					"sale"=> [
						[
						"text"=> "Общая",
						"value"=> "general",
						"selected"=> true
						],
						[
						"text"=> "За м²",
						"value"=> "meters"
						]
					],
					"rent"=> [
						[
						"text"=> "м²/год",
						"value"=> "meters_per_year",
						"selected"=> true
						],
						[
						"text"=> "Помещение/мес.",
						"value"=> "general_month"
						]
					]
                ]
			];
		}
		if ($data['condition']) {
			$res['condition'] = $data['condition'];
		}
		return $res;
	}
}
class ObjectFilter extends CBitrixComponent
{
	use FilterFieldsTrait;

	const TRANSLIT = array("replace_space" => "-", "replace_other" => "-");
	const SPECIAL_TAGS = ['Новостройка','Вторичка'];
	const SPECIAL_TAGS_TRANSLIT = ['novostroyka','vtorichka'];
	/**
	 * Генерация фильтра для elastic
	 *
	 * @param   array  $fields  Конфигурация полей которые учавствуют в построение фильтра
	 *
	 * @return  array           Elastic фильтр
	 */
	public function getFilter($fields)
	{
		$filter = [['term' => ['active' => 1]]];
		$mustNot = [];
		$should = [];
		foreach ($fields as $field) {
			$field = explode('|', $field);
			$translite = false;
			$search = false;
			$isArrayField = false;
			if (in_array('translit', $field)) {
				$translite = true;
			}
			if ($field == 'id') {
				$field = '_id';
			}
			$isOr = false;
			if ((array_search('or', $field)) !== false) {
				$isOr = true;
			}
			if (in_array('search', $field)) {
				$search = true;
			}
			$field = $field[0];
			$value = $this->request[$field];
			if ($translite) {
				$field = 'translit_' . $field;
			}

			if (empty($value) && is_null($value)) {
				continue;
			}
			$result = false;
			if ($search) {
				$result = [
					'query_string' => [
						"default_field" => $field,
						"query" => str_replace(['/'],' ',$value),
						"default_operator" => "and"
					]
				];
			} else {
				if ($field == 'price') {
					if ($this->request['range'] == 'meters'){
						$currency = $this->request['currency'] ? $this->request['currency'] : 'rub';
						$field = 'square_price_' . $currency;
					}else{
						$currency = $this->request['currency'] ? $this->request['currency'] : 'rub';
						$field = 'price_' . $currency;
					}
				}

				if ($field == 'not') {
					foreach ($value as $code => $item) {
						if ($item == intval($item)) {
							$item = intval($item);
						}
						if ($code == 'id') {
							$code = '_id';
						}
						$mustNot[]['term'][$code] = $item;
					}
				} else {
					if (is_array($value)) {
						if (array_key_exists('from', $value) || array_key_exists('to', $value)) {
							$range = [];
							if (array_key_exists('from', $value)) {
								$range['gte'] = $value['from'];
							}
							if (array_key_exists('to', $value)) {
								$range['lte'] = $value['to'];
							}
							$result = ['range' => [$field => $range]];
						} else if (count($value) > 1) {
							if ($field == 'translit_tags') {
								$result = [];
								$isArrayField = true;
								$speacial = [];
								$tag = [];
								foreach ($value as $itemValue) {
									if (in_array($itemValue, self::SPECIAL_TAGS_TRANSLIT)) {
										$speacial[] = $itemValue;
									} else {
										$tag[] = $itemValue;
									}
								}
								if (count($speacial) > 0) {
									$result[] = ['terms' => [$field => array_unique($speacial)]];
								}
								if (count($tag) > 0) {
									$result[] = ['terms' => [$field => array_unique($tag)]];
								}
							} else {
								$result = ['terms' => [$field => array_values(array_unique($value))]];
							}
						} else {
							$result = ['term' => [$field => $value[0]]];
						}
					} else {

						$result = ['term' => [$field => $value]];
					}
				}
			}
			if ($result) {
				if ($isOr) {
					if ($isArrayField) {
						$should = array_merge($should, $result);
					} else {
						$should[] = $result;
					}
				} else {
					if ($isArrayField) {
						$filter = array_merge($filter, $result);
					} else {
						$filter[] = $result;
					}
				}
			}
		}
		$tmp = $filter;
		$filter = ['filter' => $tmp];
		if (count($mustNot) > 0) {
			$filter['must_not'] = $mustNot;
		}
		if (count($should) > 0) {
			$filter['should']	= $should;
			$filter['minimum_should_match'] = 1;
		}
		return $filter;
	}

	/**
	 * Получение списка тегов сгруппированный по типам недвижимиости
	 *
	 * @return  array  возвращает массив массивов с вариантами тегов
	 */
	public function getTags()
	{
		if($this->departmentID == COMMERC_OFFICE || $this->departmentID == COMMERC_SKLAD || $this->departmentID == COMMERC_TORG){
			$departID=COMMERC_DEPARTAMENT;
		}else{
			$departID=$this->departmentID;
		}
		$client = ClientBuilder::create()->setHosts(['elastic'])->build();
		$indexParams = ['index' => ELASTIC_INDEX];
		$special = [];
		if (!$client->indices()->exists($indexParams))
			return [];
		$sorts = [
			'tags' => [
				'order' => 'desc'
			],
		];
		if ($departID) {
			$scoreFunctions = [];
			$filter = [
				'bool' => [
					'filter' => [
						[
							'term' => ["department_id" => $departID],
						],
						[
							'term' => ["active" => 1]
						]
					]
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
				'aggs' => [
					'group_type' => [
						'terms' => [
							'field' => $departID == 1 ? 'isNewBuilding' : 'object_type'
						],
						'aggs' => [
							'group_tags' => [
								'terms' => [
									'field' => 'tags'
								]
							]
						]
					]
				]
			]
		];
		$arTags = [];
		$arTagsAll=[];
		$results = $client->search($params);
		$arTempData = $results['aggregations']['group_type']['buckets'];
		foreach ($arTempData as $key => $tempData) {
			if (!empty($tempData['key'])) {
				$list = [];
				foreach ($tempData['group_tags']['buckets'] as $index => $item) {
					if (!empty($item['key'])) {
						$value = \CUtil::translit($item['key'], 'ru', Intrum::TRANSLIT);
						$tmp = [
							"id" => "tag" . $key . $index,
							"text" => $item['key'],
							'type' => \CUtil::translit($tempData['key'], 'ru', Intrum::TRANSLIT),
							"checked" => ($this->request['tags'] && array_search($value, $this->request['tags']) !== false),
							"value" => $value
						];
						if (array_search($item['key'], self::SPECIAL_TAGS) !== false) {
							$special[$tmp['value']] = $tmp;
						} else {
							$list[] = $tmp;
						}
					}
				}
				$arTagsAll=array_merge($list,$arTagsAll);
			}
		}
		foreach($arTagsAll as $tag){
			if($this->searchTextArray($tag["text"], $arTags)==false){
				$arTags[]=$tag;
			}
		}
		return ['tags' => $arTags, 'special' => array_values($special)];
	}
	public function searchTextArray($value, $array)
	{
		$res=false;
		foreach($array as $item){
			if($item["text"]==$value){
				$res=true;
			}
		}
		return $res;
	}

	public function executeComponent()
	{
		$this->res = \Idem\CIdemStatic::getInstance();
		if($_GET['price']['from']){
			$_GET['price']['from']=str_replace(' ', '', $_GET['price']['from']);
		}
		if($_GET['price']['to']){
			$_GET['price']['to']=str_replace(' ', '', $_GET['price']['to']);
		}
		$this->request = $_GET;
		if ($this->arParams['PARAMS']) {
			$this->request = array_merge_recursive((array) $this->request, (array) $this->arParams['PARAMS']);
		}
		Loader::includeModule('idem.realty');
		if ($this->arParams['DEPARTAMEN_ID']) {
			$this->departmentID = $this->arParams['DEPARTAMEN_ID'] . '';
		} else {
			$this->departmentID = $this->request['department_id'];
		}

		/** Конфиг фильтра настраивать для всех типов недвижимости */
		if ($this->departmentID == LIVE_DEPARTAMENT) {
			$config = [
				"fields" => [
					"deal_type" => 'radio|source:$dealType|val:request',
					"object_type|translit" => "select|source:db|val:request",
					"price" => "price",
					"area" => "range|title:Площадь",
					"search|search" => "input",
					"department_id" => "hidden|val:{$this->departmentID}",
					"parent_id" => 'hidden|val:$parentId',
				],
				"more" => [
					"rooms" => "range",
					"finish_type|translit" => "select|source:db|val:request",
					"parking|translit" => "select|source:db|val:request"
				],
				"available" => ['tags|translit', 'metro|translit', 'transport_ring|translit|or', 'district|translit|or', 'locality|translit|or', 'id', 'not']
			];
		} else if ($this->departmentID == COUNTRY_DEPARTAMENT) {
			$config = [
				"fields" => [
					"deal_type" => 'radio|source:$dealType|val:request',
					"object_type|translit" => "select|source:db|val:request|sort:{\"poselok\":100}",
					"price" => "price",
					"area_building" => "range|title:Площадь дома|condition:{\"!object_type\":\"uchastok\"}",
					"area_weaving" => "range|title:Площадь участка|condition:{\"object_type\":\"uchastok\"}",
					"search|search" => "input|placeholder:Название, шоссе, ID",
					"department_id" => "hidden|val:{$this->departmentID}",
					"parent_id" => 'hidden|val:$parentId'
				],
				"more" => [
					"area_weaving" => "range|title:Площадь участка|condition:{\"!object_type\":\"uchastok\"}",
					"bedrooms" => "range|title:Спальни|condition:{\"!object_type\":\"uchastok\"}",
					"finish_type|translit" => "select|source:db|val:request|condition:{\"!object_type\":\"uchastok\"}",
					"distance_mkad" => "range|title:от МКАД,км"
				],
				"available" => ['tags|translit', 'highway|translit', 'locality', 'id', 'not']
			];
		}else if ($this->departmentID == FOREIGN_DEPARTAMENT) {
			$config = [
				"fields" => [
					"deal_type" => 'radio|source:$dealType|val:request',
					"object_type|translit" => "select|source:db|val:request",
					"price" => "price",
					"area" => "range|title:Площадь",
					"search|search" => "input|placeholder:Страна, город, id, название, теги",
					"department_id" => "hidden|val:{$this->departmentID}",
					"parent_id" => 'hidden|val:$parentId'
				],
				"more" => [
					"bedrooms" => "range|title:Спальни",
					"finish|translit" => "select|source:db|val:request",
					"views|translit" => "select|source:db|val:request"
				],
				"available" => ['tags|translit', 'country|translit', 'city|translit', 'id', 'not']
			];
		}/*else if ($this->departmentID == COMMERC_DEPARTAMENT) {
			$config = [
				"fields" => [
					"deal_type" => 'radio|source:$dealType|val:request',
					"type_real|translit" => "select|source:db|val:request",
					"price" => "price",
					"realty_class|translit" => "select|source:db|val:request",
					"search|search" => "input|placeholder:Адрес или ЖК",
					"department_id" => "hidden|val:{$this->departmentID}",
					"parent_id" => 'hidden|val:$parentId'
				],
				"more" => [
					"area" => "range|title:Площадь",
					"finish_type|translit" => "select|source:db|val:request",
				],
				"available" => ['tags|translit', 'metro|translit', 'transport_ring|translit|or', 'district|translit|or', 'locality|translit|or', 'id', 'not']
			];
		}*/
		if($this->arParams['MAP']){
			//$config["fields"]["all_count"]='hidden|val:1';
			/*if ($this->departmentID == COMMERC_OFFICE) {
				$codeType=$this->departmentID;
				$departmentID=COMMERC_DEPARTAMENT;
				$config = [
					"fields" => [
						"deal_type" => 'radio|source:$dealType|val:request',
						"type_real|translit" => "select|source:db|val:request",
						"price" => "price",
						"realty_class|translit" => "select|source:db|val:request",
						"search|search" => "input|placeholder:Адрес или ЖК",
						"department_id" => "hidden|val:{$departmentID}",
						"parent_id" => 'hidden|val:$parentId',
						"object_type" => "hidden|val:{$this->departmentID}"
					],
					"more" => [
						"area" => "range|title:Площадь",
						"finish_type|translit" => "select|source:db|val:request",
					],
					"available" => ['tags|translit', 'metro|translit', 'transport_ring|translit|or', 'district|translit|or', 'locality|translit|or', 'id', 'not']
				];
			}elseif($this->departmentID == COMMERC_SKLAD){
				$codeType=$this->departmentID;
				$departmentID=COMMERC_DEPARTAMENT;
				$config = [
					"fields" => [
						"deal_type" => 'radio|source:$dealType|val:request',
						"type_real|translit" => "select|source:db|val:request",
						"price" => "price",
						"realty_class|translit" => "select|source:db|val:request",
						"search|search" => "input|placeholder:Адрес или ЖК",
						"department_id" => "hidden|val:{$departmentID}",
						"parent_id" => 'hidden|val:$parentId',
						"object_type" => "hidden|val:{$this->departmentID}"
					],
					"more" => [
						"area" => "range|title:Площадь",
						"finish_type|translit" => "select|source:db|val:request",
					],
					"available" => ['tags|translit', 'metro|translit', 'transport_ring|translit|or', 'district|translit|or', 'locality|translit|or', 'id', 'not']
				];
			}elseif($this->departmentID == COMMERC_TORG){
				$codeType=$this->departmentID;
				$departmentID=COMMERC_DEPARTAMENT;
				$config = [
					"fields" => [
						"deal_type" => 'radio|source:$dealType|val:request',
						"type_real|translit" => "select|source:db|val:request",
						"price" => "price",
						"realty_class|translit" => "select|source:db|val:request",
						"search|search" => "input|placeholder:Адрес или ЖК",
						"department_id" => "hidden|val:{$departmentID}",
						"parent_id" => 'hidden|val:$parentId',
						"object_type" => "hidden|val:{$this->departmentID}"
					],
					"more" => [
						"area" => "range|title:Площадь",
						"finish_type|translit" => "select|source:db|val:request",
					],
					"available" => ['tags|translit', 'metro|translit', 'transport_ring|translit|or', 'district|translit|or', 'locality|translit|or', 'id', 'not']
				];
			}*/
		}
		/** Фикс на тип продаж (могут быть не все - но выводить надо все)*/
		$this->arResult['dealType'] = [
			['value' => 'sale', 'text' => 'Купить'],
			['value' => 'arenda', 'text' => 'Снять']
		];
		$this->arResult['parentId'] = $this->request['parent_id'] ? $this->request['parent_id'] : 0;
		/** Генерация полей по конфигу */
		$json = $this->generateFilter($config);
		$fields = array_merge(array_keys($config['fields']), array_keys($config['more']), (array) $config['available']);
		$filter = $this->getFilter($fields);
		if ($this->arParams['DINAMIC'] == true) {
			$json = $this->generateFilter($config, $filter);
		}
		if ($this->arParams['PARAMS']) {
			$json['params'] = $this->arParams['PARAMS'];
		}
		return ['json' => $json, 'filter' => $filter];
	}

	/**
	 * функция генерации вида фильтра
	 *
	 * @param   array  $config  конфигурация для полей
	 * @param   array  $filter  построенный фильтр
	 *
	 * @return  array           возвращается json для рендера фильтра
	 */
	public function generateFilter($config = false, $filter = false)
	{
		global $APPLICATION;
		$tags = $this->getTags();
		$special = $tags['special'];
		$tags = $tags['tags'];
		$type = $this->request['object_type'];
		$departId=$this->departmentID;
		$selectedTagsSearch = array_filter($tags, function ($item) use ($type) {
			return $item['name'] = $type;
		});
		if ($selectedTagsSearch) {
			$selectedTags = $selectedTagsSearch[0]['list'];
		} else {
			$tmp = [];
			foreach ($tags as $group) {
				foreach ($group['list'] as $item) {
					if (!$tmp[$item['value']]) {
						$tmp[$item['value']] = $item;
						break;
					}
				}
			}
			$selectedTags = array_values($tmp);
		}
		$popupsBtn = [];
		$dinamicField = '';
		if ($this->departmentID == LIVE_DEPARTAMENT) {
			$dinamicField = 'tags';
			$popupsBtn = [
				["popup" => "popupAreaMetro", "text" => $this->res->get('site_' . LANGUAGE_ID . '.metro'), 'count'=>false],
				["popup" => "popupAreaDistrict", "text" => $this->res->get('site_' . LANGUAGE_ID . '.locality_and_districts'), "count"=>false],
			];
		}elseif ($this->departmentID == COUNTRY_DEPARTAMENT) {
			$dinamicField = 'object_type';
			$popupsBtn = [
				["popup" => "popupAreaDistrict", "text" => 'Выбрать шоссе', 'variable' => 'highway', 'dataset' => '/api/highway.php', "count"=>false],
			];
		}elseif ($this->departmentID == FOREIGN_DEPARTAMENT) {			
			$popupsBtn = [
				["popup" => "popupCountryCity", "text" => 'Страна и город', "className" => "popup-area--country", "title" => "выбрать страну и город", "count"=>false],
			];
		}elseif ($this->departmentID == COMMERC_DEPARTAMENT) {
			$type ="office";
			$popupsBtn = [
				["popup" => "popupAreaMetro", "text" => $this->res->get('site_' . LANGUAGE_ID . '.metro'), 'count'=>false],
				["popup" => "popupAreaDistrict", "text" => $this->res->get('site_' . LANGUAGE_ID . '.locality_and_districts'), "count"=>false],
			];
		}elseif ($this->departmentID == COMMERC_OFFICE) {
			$departId=COMMERC_DEPARTAMENT;
			$type ="office";
			$popupsBtn = [
				["popup" => "popupAreaMetro", "text" => $this->res->get('site_' . LANGUAGE_ID . '.metro'), 'count'=>false],
				["popup" => "popupAreaDistrict", "text" => $this->res->get('site_' . LANGUAGE_ID . '.locality_and_districts'), "count"=>false],
			];
		}elseif ($this->departmentID == COMMERC_SKLAD) {
			$departId=COMMERC_DEPARTAMENT;
			$type ="office";
			$popupsBtn = [
				["popup" => "popupAreaMetro", "text" => $this->res->get('site_' . LANGUAGE_ID . '.metro'), 'count'=>false],
				["popup" => "popupAreaDistrict", "text" => $this->res->get('site_' . LANGUAGE_ID . '.locality_and_districts'), "count"=>false],
			];
		}elseif ($this->departmentID == COMMERC_TORG) {
			$departId=COMMERC_DEPARTAMENT;
			$type ="office";
			$popupsBtn = [
				["popup" => "popupAreaMetro", "text" => $this->res->get('site_' . LANGUAGE_ID . '.metro'), 'count'=>false],
				["popup" => "popupAreaDistrict", "text" => $this->res->get('site_' . LANGUAGE_ID . '.locality_and_districts'), "count"=>false],
			];
		}
		$baseJson = [
			"action" => $APPLICATION->GetCurPage(),
			"type"=> $type,
			"realty_type" => $departId,
			"name" => $this->departmentID,
			"popupButtons" => $popupsBtn,
			"tags" => [
				"name" => "catalogTags",
				"selected" => $selectedTags,
				"list" => $tags,
				"isDynamic" => true,
				"field" => $dinamicField,
				"special" => $special
			]
		];
		foreach ($config as $group => $fields) {
			if ($group == 'available') {
				continue;
			}
			foreach ($fields as $code => $typeInput) {
				$code = explode('|', $code)[0];
				$params = explode('|', $typeInput);
				$type = array_shift($params);
				$params = array_reduce($params, function ($sum, $item) {
					$tmp = explode(':', $item);
					$tmpKey = array_shift($tmp);
					$sum[$tmpKey] = implode(':', $tmp);
					return $sum;
				}, []);
				$data = [
					'code' => $code
				];
				foreach ($params as $paramCode => $paramValue) {
					if ($paramCode == 'val') {
						if ($paramValue == 'request') {
							$data['value'] = $this->request[$code];
						} elseif ($paramValue[0] == '$') {
							$data['value'] = $this->arResult[substr($paramValue, 1)];
						} else {
							$data['value'] = $paramValue;
						}
					} elseif ($paramCode == 'source') {
						if ($paramValue[0] == '$') {
							$data['values'] = $this->arResult[substr($paramValue, 1)];
						} elseif ($paramValue == 'db') {
							$data['values'] = Data::getGroupByField($departId, $code, $filter);

						}
					}elseif($paramCode == 'sort'){
						$sortConfig = json_decode($paramValue, true);
						$data['values']=Util::sorterFields($sortConfig,$data['values']);
					} else {
						$data[$paramCode] = $paramValue;
					}
				}
				if ($type == 'hidden') {
					$this->request[$data['code']] = $data['value'];
				}
				$baseJson[$group][] = call_user_func(array($this, "generate_{$type}"), $data);
			}
		}
		return $baseJson;
	}
}
