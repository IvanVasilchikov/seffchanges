<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use app\Util\Util;
use Idem\Realty\Realty\Data;
use Elasticsearch\ClientBuilder;

class MainPage extends CBitrixComponent
{
	public function getFeatures()
	{

		$arResult = [
			'title' => $this->res->get('main_' . LANGUAGE_ID . '.features_title'),
			'sTitle' => $this->res->get('main_' . LANGUAGE_ID . '.features_sub_title')
		];
		$util = new app\Util\Util();
		$arData = $util->getTypicalData($this->arParams['COMPANY_FEATURES_IBLOCK_CODE'], false, false, ['LINK'], true, [], [], [], false, true);
		foreach ($arData as $key => $data) {
			if (($key + 1) < 10)
				$num = "0" . ($key + 1);
			else
				$num = $key + 1;
			$arItem = [
				"number" => $num,
				"title" => $data['NAME'],
				"text" => $data['PREVIEW_TEXT'],
			];
			if ($data["PROPS_DATA"]["LINK"]["DESCRIPTION"] != 'Получить') {
				$arItem['link'] = [
					"text" => $data["PROPS_DATA"]["LINK"]["DESCRIPTION"],
					"url" => $data['PROPERTY_LINK_VALUE']
				];
			} else {
				$arItem['popup'] = [
					"text" => $data["PROPS_DATA"]["LINK"]["DESCRIPTION"],
					"type" => "form",
					"name" => 'compilation'
				];
			}
			$arResult['slider'][] = $arItem;
		}

		return $arResult;
	}

	public function getClients()
	{

		$arResult = [
			'title' => $this->res->get('main_' . LANGUAGE_ID . '.clients_title'),
		];
		$util = new app\Util\Util();
		$arData = $util->getTypicalData($this->arParams['CLIENTS_IBLOCK_CODE'], 5, false, [], true, [], ['PREVIEW_PICTURE']);
		foreach ($arData as $key => $data) {
			$arResult['items'][] = [
				"url" => $data['CODE'],
				"img" => [
					"src" => $data['PREVIEW_PICTURE'][0],
					"alt" => $data['NAME']
				]
			];
		}

		return $arResult;
	}

	public function getServises()
	{
		$arResult = [];
		$arResult['head'] = [
			"title" => $this->res->get('main_' . LANGUAGE_ID . '.main_services_title'),
			"subtitle" => $this->res->get('main_' . LANGUAGE_ID . '.main_services_text'),
		];
		$util = new app\Util\Util();

		$arSliders = [];
		$arTabs = [];
		$arData = $util->getTypicalData($this->arParams['SERVICES_IBLOCK_CODE'], false, true, ['FILE', 'ICON'], true, [], ['PROPERTY_FILE_VALUE', 'PROPERTY_ICON_VALUE']);

		foreach ($arData['SECTIONS'] as $key => $data) {
			$arTabs[] = [
				"text" => $data['NAME'],
				"value" => $data['CODE']
			];
			$arItems = [];
			foreach ($data['ITEMS'] as $arItem) {
				$arItems[] = [
					//"link" => $arItem['DETAIL_PAGE_URL'],
					"ico" => $arItem['PROPERTY_FILE_VALUE'][0],
					"title" => $arItem['NAME'],
					"text" => $arItem['~PREVIEW_TEXT'],
					// "popup" => [
					// 	"name" => "consultation",
					// 	"ico" => $arItem['PROPERTY_ICON_VALUE'][0],
					// 	"btnPhrase" => "Получить консультацию",
					// 	"html" => $arItem['~DETAIL_TEXT']
					// ]
				];
			}
			$arSliders[] = [
				"name" => $data['CODE'],
				"items" => $arItems
			];
		}
		$arResult['sliders'] = $arSliders;
		$arResult['tabs'] = $arTabs;

		return $arResult;
	}

	public function executeComponent()
	{
		global $APPLICATION;
		$this->res = \Idem\CIdemStatic::getInstance();
		$APPLICATION->SetPageProperty("og:title", '<meta property="og:title" content="' . $this->res->get('about_' . LANGUAGE_ID . '.og_title') . '"/>');
		$APPLICATION->SetPageProperty("og:description", '<meta property="og:description" content="' . $this->res->get('about_' . LANGUAGE_ID . '.og_description') . '"/>');
		$APPLICATION->SetPageProperty("og:image", '<meta property="og:image" content="https://' . SITE_SERVER_NAME . $this->res->get('site_' . LANGUAGE_ID . '.og_logo_file') . '"/>');
		$this->arResult = [];
		$this->arResult['indexPage']['banner'] = $this->getBanners();
		$this->arResult['indexPage']['filter'] = $this->getFilter();
		$this->arResult['indexPage']['types'] = $this->getTypes();
		$this->arResult['indexPage']['how'] = $this->getQuestionsTest();
		$this->arResult['indexPage']['experience'] = $this->getExperience();
		$this->arResult['indexPage']['services'] = $this->getServises();
		$this->arResult['indexPage']['agency'] = $this->getAgencySlider();
		$this->arResult['indexPage']['offers'] = $this->getOffers();
		if (count($this->arResult['indexPage']['offers']['tabs']) == 0) {
			unset($this->arResult['indexPage']['offers']);
		}
		$this->arResult['indexPage']['request'] = [
			"picture" => [
				"sources" => [
					"mobile" => [
						"/assets/images/home/banner/background.jpg"
					],
					"tablet" => [
						"/assets/images/home/banner/background_t.jpg"
					],
					"desktop" => [
						"/assets/images/home/banner/background.jpg"
					]
				],
				"alt" => "apartment",
				"title" => "apartment"
			],
			"title" => GetMessage("helpBest"),
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
				"btn" => GetMessage("send"),
				"checkbox" => [
					"text" => GetMessage("agreePersonal"),
					"name" => "checkbox",
					"value" => "y",
					"checked" => false
				]
			]
		];
		$this->arResult['indexPage']['features'] = $this->getFeatures();
		$this->arResult['indexPage']['clients'] = $this->getClients();
		$util = new Util();
		$this->arResult['indexPage']['presentation'] = $util->getPresentation();
		$data = new Data();
		$this->arResult['indexPage']['seoLinks'] = ['items'=>[]];
		foreach (['metro', 'locality', 'highway'] as $type) {
			$res = $data->getSeoLinks([$type],"kvartira");
			if($type == 'highway'){
				$res = $data->getSeoLinks([$type],'',3);
			}	
			
			if ($res['items'][0]['titleBtn']) {
				$res = $res['items'][0];
			}
			if (!$res['titleBtn']) {
				$res = array_merge($res, [
					"titleBtn"=> $type == 'highway' ? "Загородная недвижимость" : "Квартиры",
					"title"=> $type == 'metro' ? "у метро": ($type == 'locality' ? 'в районе' : ''),
					"btnOpen" => "Показать больше шоссе",
				]);
			}
			$res['items'] = array_values($res['items']);
			$this->arResult['indexPage']['seoLinks']['items'][] = $res;
		}
		$GLOBALS["JsonInit"]['indexPage'] = $this->arResult['indexPage'];
		$this->includeComponentTemplate();

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
				],
				[
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
		setJsonInit('popups/form/compilation', [
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
			"title" => GetMessage("gerPod"),
			"action" => "/ajax/compil.php",
			"hidden" => [
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
						"email" => true,
						"lengthString" => [
							"min" => 5,
							"max" => 250
						]
					]
				]
			],
			"btnPhrase" => GetMessage("gerPod"),
			"checkbox" => [
				"checked" => false,
				"name" => "checkbox",
				"text" => GetMessage("agreePersonal"),
				"value" => ""
			]
		]);
		setJsonInit('popups/form/compilation', [
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
			"title" => GetMessage("gerPod"),
			"action" => "/ajax/compil.php",
			"hidden" => [
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
						"email" => true,
						"lengthString" => [
							"min" => 5,
							"max" => 250
						]
					]
				]
			],
			"btnPhrase" => GetMessage("gerPod"),
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
		setJsonInit('popups/form/consultation', [
			"title" => "Получить консультацию",
			"action" => "/ajax/service.php",
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
				],
				[
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
				],
				[
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

		return $this->arResult;
	}

	public function getBanners()
	{
		$arResult = [];

		$arResult['background'] = [
			"sources" => [
				"mobile" => [$this->res->get('main_' . LANGUAGE_ID . '.banner_mobile_file')],
				"tablet" => [$this->res->get('main_' . LANGUAGE_ID . '.banner_tablet_file')],
				"desktop" => [$this->res->get('main_' . LANGUAGE_ID . '.banner_desktop_file')],
			],
			"alt" => "background bg",
			"title" => "background"
		];
		$arResult['title'] = $this->res->get('main_' . LANGUAGE_ID . '.banner_title');
		$arResult['text'] = $this->res->get('main_' . LANGUAGE_ID . '.banner_text');


		return $arResult;
	}

	public function getFilter()
	{
		$allowField = ['deal_type', 'object_type', 'price', 'area', 'area_weaving', 'area_building', 'search', 'department_id', 'parent_id', 'realty_class','type_real'];
		$class = CBitrixComponent::includeComponentClass("custom:map.search");
		$tmp = $class::generateJsonFilter();

		foreach ($tmp as &$tab) {
			foreach ($tab['fields'] as  $key => $field) {
				if (!in_array($field['name'], $allowField)) {
					unset($tab['fields'][$key]);
				}
			}
			$tab['fields'] = array_values($tab['fields']);
			unset($tab["tags"]);
		}
		unset($tab);
		$arTagsData = Util::getTypicalData('tagsFiltersRu', false,false, [], true, [], []);
		$arTags=[];
		foreach ($arTagsData as &$arTag) {
			$tagsInfo["id"]=$arTag["ID"];
			$tagsInfo["text"]=$arTag["NAME"];
			$tagsInfo["value"]=$arTag["CODE"];
			$arTags[]=$tagsInfo;
		}
		$arResult = [
			"mapBtn" => [
				"url" => "/map/",
				"img" => $this->res->get('main_' . LANGUAGE_ID . '.realty_map_img_file'),
				"text" => $this->res->get('main_' . LANGUAGE_ID . '.realty_map_search_title')
			],
			'tabs' => array_values($tmp),
			"mainFilter"=> true,
			"action"=> "/api/objects.php",
			"select"=> [
				"name"=> "tab",
				"values"=> [
					[
						"text"=> "Городская",
						"value"=> "1",
						"selected"=> true
					],
					[
						"text"=> "Загородная",
						"value"=> "3"
					],
					[
						"text"=> "Коммерческая",
						"value"=> '2',
						"disabled"=> true
					],
					/*[
						"text"=> "Офисная",
						"value"=> 'ofis'
					],
					[
						"text"=> "Складская",
						"value"=> 'sklad',
						"disabled"=> true
					],
					[
						"text"=> "Торговая",
						"value"=> 'torgovaya',
						"disabled"=> true
					],*/
					[
						"text"=> "Зарубежная",
						"value"=> "5"
					]
				]
			],
			"tags"=> [
				"name"=> "catalogTags",
				"list"=> $arTags
			],
			"broker"=> "Заказать подбор брокеру"
		];
		return $arResult;
	}

	public function getTypes()
	{
		/*если скажут делать динамическими список подтипов то его можно получить из ф-и getFilter*/
		$arResult = [];

		$arResult['items'] = [
			[
				"img" => $this->res->get('main_' . LANGUAGE_ID . '.realty_livetype_img_file'),
				"titleLink" => [
					"text" => $this->res->get('main_' . LANGUAGE_ID . '.realty_livetype_title'),
					"href" => $this->res->get('main_' . LANGUAGE_ID . '.realty_livetype_url')
				],
				"items" => $this->res->get('main_' . LANGUAGE_ID . '.realty_livetype_items')
			],
			[
				"img" => $this->res->get('main_' . LANGUAGE_ID . '.realty_countrytype_img_file'),
				"titleLink" => [
					"text" => $this->res->get('main_' . LANGUAGE_ID . '.realty_countrytype_title'),
					"href" => $this->res->get('main_' . LANGUAGE_ID . '.realty_countrytype_url')
				],
				"items" => $this->res->get('main_' . LANGUAGE_ID . '.realty_countrytype_items')
			],
			[
				"img" => $this->res->get('main_' . LANGUAGE_ID . '.realty_commerctype_img_file'),
				"titleLink" => [
					"text" => $this->res->get('main_' . LANGUAGE_ID . '.realty_commerctype_title'),
					"href" => $this->res->get('main_' . LANGUAGE_ID . '.realty_commerctype_url')
				],
				"items" => $this->res->get('main_' . LANGUAGE_ID . '.realty_commerctype_items')
			],
			[
				"img" => $this->res->get('main_' . LANGUAGE_ID . '.realty_foreigntype_img_file'),
				"titleLink" => [
					"text" => $this->res->get('main_' . LANGUAGE_ID . '.realty_foreigntype_title'),
					"href" => $this->res->get('main_' . LANGUAGE_ID . '.realty_foreigntype_url')
				],
				"items" => $this->res->get('main_' . LANGUAGE_ID . '.realty_foreigntype_items')
			]
		];
		$arResult['offer'] = [
			'title' => $this->res->get('main_' . LANGUAGE_ID . '.offer_title'),
			'text' => $this->res->get('main_' . LANGUAGE_ID . '.offer_text'),
			"popup" => "compilation"
		];


		return $arResult;
	}

	public function getQuestionsTest()
	{
		$arResult = [];

		$arResult['picture'] = [
			"sources" => [
				"mobile" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_search_mobile_file')],
				"tablet" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_search_tablet_file')],
				"desktop" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_search_desktop_file')],
			],
			"alt" => "background bg",
			"title" => "background"
		];
		$arResult['url'] = "/ajax/questions_test.php";
		$arResult['tabs'] = [];
		$arResult['success'] = [
			'title' => $this->res->get('main_' . LANGUAGE_ID . '.realty_success_title'),
			'text' => $this->res->get('main_' . LANGUAGE_ID . '.realty_success_text'),
		];

		$util = new app\Util\Util();
		$arData = $util->getTypicalData($this->arParams['QUESTION_IBLOCK_CODE'], false, false, ['ANSWERS', 'SUBTITLE'], true);

		foreach ($arData as $key => $data) {
			$arAnswers = [];

			foreach ($data['PROPERTY_ANSWERS_VALUE'] as $arAnswer) {
				$arAnswers[] = [
					"text" => $arAnswer,
					"value" => $arAnswer,
					"name" => "answers_" . $key
				];
			}
			$arResult['tabs'][] = [
				"title" => $data['NAME'],
				"text" => $data['PROPERTY_SUBTITLE_VALUE'],
				"answers" => $arAnswers
			];
		}

		return $arResult;
	}

	public function getExperience()
	{
		$arResult = [];

		$arResult['picture'] = [
			"sources" => [
				"mobile" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_search_mobile_file')],
				"tablet" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_selection_tablet_file')],
				"desktop" => [$this->res->get('main_' . LANGUAGE_ID . '.realty_selection_desktop_file')],
			],
			"alt" => "background bg",
			"title" => "background"
		];
		$arResult['title'] = $this->res->get('main_' . LANGUAGE_ID . '.realty_selection_title');
		$arResult['mainTitle'] = $this->res->get('main_' . LANGUAGE_ID . '.realty_selection_sub_title');
		$arResult['text'] = $this->res->get('main_' . LANGUAGE_ID . '.realty_selection_text');
		$arResult['btn'] = [
			'url' => $this->res->get('main_' . LANGUAGE_ID . '.realty_selection_btn_url'),
			'text' => $this->res->get('main_' . LANGUAGE_ID . '.realty_selection_btn_text'),
		];

		return $arResult;
	}

	public function getAgencySlider()
	{
		$arResult = [];


		$arResult['title'] = $this->res->get('main_' . LANGUAGE_ID . '.main_agency_slider_title');
		$arResult['text'] = $this->res->get('main_' . LANGUAGE_ID . '.main_agency_slider_text');
		$arResult['slider'] = [];
		$util = new app\Util\Util();
		$imgSizes = [
			"desktop" => ['width' => 1440, 'height' => 0],
			"tablet" => ['width' => 768, 'height' => 0],
			"mobile" => ['width' => 375, 'height' => 0],
		];
		$arData = $util->getTypicalData($this->arParams['MAIN_SLIDER_IBLOCK_CODE'], false, false, ['TITLE', 'PRICE','LINK'], true, [], ['PREVIEW_PICTURE'], $imgSizes);
		foreach ($arData as $key => $data) {

			$arResult['slider'][] = [
				"picture" => [
					"sources" => $data['PREVIEW_PICTURE'][0],
					"alt" => "apartment",
					"title" => "apartment"
				],
				"url" => $data['PROPERTY_LINK_VALUE'] ? $data['PROPERTY_LINK_VALUE'] : 'javascript::void(0);',
				"name" => $data['~PROPERTY_TITLE_VALUE'],
				"price" => $data['PROPERTY_PRICE_VALUE']
			];
		}
		return $arResult;
	}

	public function getOffers()
	{

		global $APPLICATION;
		$arObjectTypes = [
			LIVE_REALTY_URL => [
				'id' => 1,
				'name' => $this->res->get('main_' . LANGUAGE_ID . '.realty_livetype_title'),
				'items' => []
			],
			COUNTRY_REALTY_URL => [
				'id' => 3,
				'name' => $this->res->get('main_' . LANGUAGE_ID . '.realty_countrytype_title'),
				'items' => []
			],
			COMMERC_REALTY_URL => [
				'id' => 2,
				'name' => $this->res->get('main_' . LANGUAGE_ID . '.realty_commerctype_title'),
				'items' => []
			],
			FOREIGN_REALTY_URL => [
				'id' => 5,
				'name' => $this->res->get('main_' . LANGUAGE_ID . '.realty_foreigntype_title'),
				'items' => []
			]
		];
		$data = new Data();
		$arTempDepartments = $data->getEntityDataByFilter("Idem\Realty\Core\Departament\DepartamentTable", [], true);
		$arDepartments = [];
		foreach ($arTempDepartments as $key => $arTempDepartment) {
			$arDepartments[$arTempDepartment['ID']] = $arTempDepartment['NAME'];
		}

		$arResult = [
			"title" => $this->res->get('main_' . LANGUAGE_ID . '.main_exclusive_title'),
			"sTitle" => $this->res->get('main_' . LANGUAGE_ID . '.main_exclusive_text'),
			'tabs' => [],
			'itemsWrap' => []
		];

		foreach ($arObjectTypes as $type => $arType) {
			$arObjects = $APPLICATION->IncludeComponent(
				"custom:catalog",
				"",
				array(
					'DEPARTAMENT_ID' => $arType['id'],
					'LIMIT' => 6,
					"FILTER" => [
						'bool' => [
							'filter' => [
								['term' => ['department_id' => $arType['id']]],
								['term' => ['recom' => 1]],
								['term' => ['active' => 1]]
							],
						]
					],
					"SORT"=>["name"=> "date_update","order"=> "desc"],
					'RETURN' => true,
				),
				false
			);

			if (!empty($arObjects['cards'])) {
				$arResult['tabs'][] = [
					"text" => $arType['name'],
					"value" => $type
				];
				$arResult['itemsWrap'][] = [
					"name" => $type,
					"cards" => $arObjects['cards'],
				];
			}
		}

		return $arResult;
	}
}
