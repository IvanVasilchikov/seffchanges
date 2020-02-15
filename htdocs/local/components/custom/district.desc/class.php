<?

use app\Util\Util;
use Bitrix\Main\Loader;
use Idem\Realty\Core\Objects\Objects;
use Idem\Realty\Import\Intrum;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

Loader::includeModule('idem.realty');
Loader::includeModule('iblock');

class DistrictsDesc extends CBitrixComponent
{
    public function counElSimular($value)
    {
        $parts = parse_url($value);
        parse_str($parts['query'], $query);
        $res = Objects::getFilterObjects($query);
        return $res;
    }
    public static function generateJsonFilter()
    {
        global $APPLICATION;
        $json = [];
        $categories = [LIVE_DEPARTAMENT => 'Городская', COMMERC_DEPARTAMENT => 'Коммерческая'];
        foreach ($categories as $type => $text) {
            $tmp = $APPLICATION->IncludeComponent(
                "custom:object.filter",
                "",
                array(
                    'DEPARTAMEN_ID' => $type,
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
            $tmp['json']['active'] = ($type === LIVE_DEPARTAMENT);
            array_splice($tmp['json']['fields'], 0, 0, [[
                "type" => "select",
                "name" => "realty_type",
                "values" => $realtyType,
            ]]);
            unset($tmp['json']["popupButtons"]);
            $json[] = $tmp['json'];

        }
        return $json;
    }

    public function generateDataDistricts($code)
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $cacheTime = '3600';
        $cacheId = "arDistrictsData" . $code;
        $cacheDir = 'arDistrictsData';
        if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
            $arDistr = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT"];
            $arFilter = array("IBLOCK_CODE" => $this->arParams['IBLOCK_CODE'], "CODE" => $code, "ACTIVE" => "Y");
            $res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arDistr = $ob->GetFields();
            }
            $cache->endDataCache($arDistr);
        }
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $cacheTime = '3600';
        $cacheId = "arDistrictsProp" . $code;
        $cacheDir = 'arDistrictsProp';
        if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
            $arProps = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $res = \CIBlockElement::GetProperty($arDistr["IBLOCK_ID"], $arDistr["ID"], "sort", "asc", []);
            while ($prop = $res->GetNext()) {
                $propValue["VALUE"] = htmlspecialcharsBack($prop["VALUE"]);
                $propValue["DESCRIPTION"] = htmlspecialcharsBack($prop["DESCRIPTION"]);
                if ($prop["MULTIPLE"] == "N") {
                    $arProps[$prop["CODE"]] = $propValue;
                } else {
                    $arProps[$prop["CODE"]][] = $propValue;
                }
            }
            $cache->endDataCache($arProps);
        }
        $resJson = [];
        $resJson["nav"] = [
            "links" => [
                [
                    "text" => "О проекте",
                    "anchor" => "#about",
                ],
                [
                    "text" => "Инфраструктура",
                    "anchor" => "#infrastructure",
                ],
                [
                    "text" => "Расположение",
                    "anchor" => "#map",
                ],
                [
                    "text" => "Предложения в районе",
                    "anchor" => "#offers",
                ],
            ],
        ];
        $resJson["main"] = [
            "breadcrumbs" => [
                [
                    "href" => "/",
                    "title" => "Главная",
                ],
                [
                    "href" => "/gorod/",
                    "title" => "Городская в Москве",
                ],
                [
                    "title" => "Район " . $arDistr["NAME"],
                ],
            ],
            "title" => $arDistr["NAME"],
            "subtitle" => $arProps["SUB_TITLE"]["VALUE"],
            "image" => [
                "sources" => [
                    "mobile" => [
                        (Util::cropImg($arDistr["PREVIEW_PICTURE"], 320, 600)) ? Util::cropImg($arDistr["PREVIEW_PICTURE"], 320, 600) : $this->__path . 'zaglushka_347х337.jpg',
                    ],
                    "tablet" => [
                        (Util::cropImg($arDistr["PREVIEW_PICTURE"], 800, 600)) ? Util::cropImg($arDistr["PREVIEW_PICTURE"], 800, 600) : $this->__path . 'zaglushka_813х665.jpg',
                    ],
                    "desktop" => [
                        (Util::cropImg($arDistr["PREVIEW_PICTURE"], 2000, 500) != '') ? Util::cropImg($arDistr["PREVIEW_PICTURE"], 2000, 500) : $this->__path . 'zaglushka_1440х600.jpg',
                    ],
                ],
                "alt" => $arDistr["NAME"],
                "title" => $arDistr["NAME"],
            ],
        ];
        foreach ($arProps["ICO_HEADER"] as $ico) {
            $resJson["main"]["info"][] = ["icon" => \CFile::GetPath($ico["VALUE"]), "text" => $ico["DESCRIPTION"]];
        }
        $resJson["about"] = [
            "title" => "О районе",
            "text" => [htmlspecialcharsBack($arDistr["DETAIL_TEXT"])],
        ];
        foreach ($arProps["BLOCK_NUMBER"] as $blocs) {
            $resJson["about"]["info"][] = ["title" => $blocs["VALUE"], "text" => $blocs["DESCRIPTION"]];
        }
        $resJson["infrastructure"]["title"] = "Инфраструктура";

        $infras = ["Экология" => "ECOLOGY_SLIDER", "Безопасность" => "SECURITY_SLIDER", "Транспорт" => "TRANSPORT_SLIDER", "Расположение" => "PLACE_SLIDER"];
        foreach ($infras as $k => $infra) {
            if ($arProps[$infra]["VALUE"] != '') {
                $resJson["infrastructure"]["tabs"][] = [
                    "button" => [
                        "text" => $k,
                        "value" => $infra,
                    ],
                    "image" => [
                        "sources" => [
                            "mobile" => [
                                Util::cropImg($arProps[$infra]["VALUE"], 320, 410),
                            ],
                            "tablet" => [
                                Util::cropImg($arProps[$infra]["VALUE"], 800, 500),
                            ],
                            "desktop" => [
                                Util::cropImg($arProps[$infra]["VALUE"], 1200, 500),
                            ],
                        ],
                        "alt" => "",
                        "title" => $k,
                    ],
                    "text" => $arProps[$infra]["DESCRIPTION"],
                ];
            }
        }
        $resJson["request"] = [
            "picture" => [
                "sources" => [
                    "mobile" => [
                        "/assets/images/how-back.jpg",
                        "/assets/images/album.webp",
                    ],
                    "tablet" => [
                        "/assets/images/album.jpg",
                        "/assets/images/album.webp",
                    ],
                    "desktop" => [
                        "/assets/images/album.jpg",
                        "/assets/images/album.webp",
                    ],
                ],
                "alt" => "album",
                "title" => "album",
            ],
            "title" => "Узнать о лучших предложениях <br>недвижимости в районе " . $arDistr["NAME"],
            "form" => [
                "url" => "/ajax/districts.php",
                "hidden" => [
                    "districts_name" => $arDistr["NAME"],
                ],
                "inputs" => [
                    [
                        "placeholder" => "Имя*",
                        "value" => "",
                        "name" => "name",
                        "type" => "text",
                        "className" => "",
                        "checked" => [
                            "value" => "waiting",
                            "required" => true,
                            "lengthString" => [
                                "min" => 1,
                                "max" => 50,
                            ],
                        ],
                    ],
                    [
                        "type" => "input",
                        "name" => "phone",
                        "placeholder" => "+7 (___) ___-__-__*",
                        "value" => "",
                        "maskInfo" => [
                            "options" => [
                                "mask" => "+{7}(000) 000-00-00",
                            ],
                            "complete" => false,
                        ],
                        "checked" => [
                            "value" => "waiting",
                            "required" => true,
                            "lengthString" => [
                                "min" => 17,
                                "max" => 17,
                            ],
                        ],
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
                                "max" => 250,
                            ],
                        ],
                    ],
                ],
                "btn" => "Отправить заявку",
                "checkbox" => [
                    "text" => "Согласен на обработку <a href=\"/privacy-policy/\" target=\"_blank\">персональных данных</a>",
                    "name" => "checkbox",
                    "value" => "y",
                    "checked" => false,
                ],
            ],
        ];
        $resJson["desc"] = [
            "title" => $arProps["FOOTER_TITLE"]["VALUE"],
            "describe" => $arProps["FOOTER_TEXT"]["VALUE"]["TEXT"],
        ];
        $resJson["map"] = [
            "title" => "на карте",
            "map" => [
                "center" => "-28.024, 140.887",
            ],
        ];
        $name = \Cutil::translit($arDistr['NAME'], "ru", Intrum::TRANSLIT);
        $items = $this->counElSimular("/api/objects.php?parent_id=0&locality={$name}&department_id=1&currency=rub");
        $itemsOffers = $this->counElSimular("/api/objects.php?parent_id=0&locality={$name}&department_id=1&currency=rub&size=6");
        foreach ($items['cards'] as $item) {
            $resJson["map"]["map"]["markers"][] = [
                "coords" => $item["map_coords"],
                "icon" => "/assets/svg/map-pin.svg",
                "iconActive" => "/assets/svg/map-pin-active.svg",
                "type" => "default",
                "tooltip" => [
                    "type" => "table",
                    "deal_type" => $item["deal_type"],
                    "id" => $item["id"],
                    "labels" => $item["labels"],
                    "images" => $item["images"],
                    "title" => $item["title"],
                    //"name" => "Многофункциональный комплекс",
                    "address" => $item["address"],
                    "table" => $item["table"],
                    "specs" => $item["specs"],
                    "info" => $item["info"],
                    "price" => $item["price"],
                    "phone" => $item["phone"],
                    "link" => $item["link"],
                    "isFav" => $item["isFav"],
                ],
                "id" => $item["id"],
            ];
        }
        $resJson["offers"] = [
            "title" => "Предложения в районе",
            "filter" => [
                "action" => "/api/objects.php?size=6&locality={$name}",
                "tabs" => self::generateJsonFilter(),
            ],
            "cards" => $itemsOffers['cards'],
            "bannerSend" => [
                "title" => "устали искать? подберем для вас то, что нужно в 2 счета",
            ],
            "pagination" => $itemsOffers["pagination"],
            "error" => "Нет предложений по вашему запросу",
            "requiesData" => $itemsOffers["requiesData"],
        ];
        $this->getMeta($arDistr["NAME"], $arDistr["PREVIEW_TEXT"]);
        return $resJson;
    }

    public function executeComponent()
    {
        $result = $this->generateDataDistricts($this->arParams['CODE']);
        $this->arResult['json'] = $result;
        setJsonInit('detailDistrict', $this->arResult['json']);
        $this->includeComponentTemplate();
    }

    public function getMeta($name, $description)
    {
        global $APPLICATION;
        $APPLICATION->SetTitle($name);
        $APPLICATION->SetPageProperty("description", $description);
    }
}
