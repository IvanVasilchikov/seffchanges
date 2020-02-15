<?
use Bitrix\Main\Loader;
use Idem\Realty\Core\Objects\ObjectsTable;
use Idem\Realty\Realty\Data;
use mikehaertl\wkhtmlto\Pdf;

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$router = new \Bramus\Router\Router();
$router->setBasePath('/');

function getDepartamentId($departamentUrl)
{
    $id = false;
    switch ($departamentUrl) {
        case LIVE_REALTY_URL:
            $id = LIVE_DEPARTAMENT;
            break;
        case COUNTRY_REALTY_URL:
            $id = COUNTRY_DEPARTAMENT;
            break;
        case FOREIGN_REALTY_URL:
            $id = FOREIGN_DEPARTAMENT;
            break;
        case COMMERC_REALTY_URL:
            $id = COMMERC_DEPARTAMENT;
            break;
    }
    return $id;
}

function markerTypeInField($param)
{
    $index = strpos($param, '-');
    $typeAddress = substr($param, 0, $index);
    $valueAddress = substr($param, $index + 1);
    $params = [];
    if ($typeAddress == 'metro') {
        $params['metro'] = [$valueAddress];
    }
    if ($typeAddress == 'ulitsa') {
        $params['address'] = $valueAddress;
    }
    if ($typeAddress == 'rayon') {
        $params['locality'] = [$valueAddress];
    }
    return $params;
}

$generateListPage = function ($urlParams) {

    global $APPLICATION;
    $departamentId = getDepartamentId($urlParams['departament']);
    $page404 = false;
    if ($urlParams['objectType']) {
        $types = Data::getGroupByField($departamentId, 'object_type', false);
        if ($departamentId == COUNTRY_DEPARTAMENT) {
            $typesLocal = Data::getGroupByField($departamentId, 'highway', false);
        } elseif ($departamentId == LIVE_DEPARTAMENT || $departamentId == COMMERC_DEPARTAMENT) {
            $typesLocal = Data::getGroupByField($departamentId, 'district', false);
        } elseif ($departamentId == FOREIGN_DEPARTAMENT) {
            $typesLocal = Data::getGroupByField($departamentId, 'country', false);
        }
        $types = array_merge($types, $typesLocal);
        $page404 = true;
        foreach ($types as $type) {
            if ($type["value"] == $urlParams['objectType'] || $type["value"] . '-shosse' == $urlParams['objectType']) {
                $page404 = false;
            }
        }
    }
    if ($urlParams['tag']) {
        $types = Data::getGroupByField($departamentId, 'object_type', false);
        $tags = Data::getGroupByField($departamentId, 'tags', false);
        $items = array_merge($types, $tags);
        $page404 = true;
        foreach ($items as $item) {
            if ($item["value"] == $urlParams['tag']) {
                $page404 = false;
            }
        }
    }
    if ($page404) {
        show404();
    }

    $params = ['parent_id' => 0];
    $params = ['department_id' => $departamentId];
    $objectType = array_map(function ($item) {
        return $item['value'];
    }, Data::getGroupByField($departamentId, 'object_type'));
    if ($urlParams['tag']) {
        $tag = $urlParams['tag'];
        // Проверим наличие тега в объектах
        if (in_array($tag, $objectType)) {
            $params['object_type'] = $urlParams['tag'];
        } else {
            if ($urlParams['tag'] == 'discount') {
                $urlParams['tag'] = 'luchshee-zhile';
            }
            $params['tags'] = [$urlParams['tag']];
        }
        if (in_array($urlParams['objectType'], $objectType)) {
            if ($urlParams['objectType']) {
                $params['object_type'] = $urlParams['objectType'];
            }
        }
    } else {        
        if ($urlParams['dealType']) {
            $params['deal_type'] = $urlParams['dealType'];
        }
        if (in_array($urlParams['objectType'], $objectType)) {
            if ($urlParams['objectType']) {
                $params['object_type'] = $urlParams['objectType'];
            }
            if ($urlParams['regionAddress']) {
                if ($params["department_id"] == COUNTRY_DEPARTAMENT) {
                    $params['highway'] = [str_replace("-shosse", "", $urlParams['regionAddress'])];
                } elseif ($params["department_id"] == FOREIGN_DEPARTAMENT) {
                    $params['country'] = [$urlParams['regionAddress']];
                } else {
                    $params['district'] = [$urlParams['regionAddress']];
                }
            }
            if ($urlParams['address']) {
                if ($params["department_id"] == FOREIGN_DEPARTAMENT) {
                    $params['city'] = [$urlParams['address']];
                } else {
                    $params = array_merge($params, markerTypeInField($urlParams['address']));
                }
            }
        } else {
            if ($urlParams['objectType']) {
                $tmpParams = markerTypeInField($urlParams['objectType']);
                if (!empty($tmpParams)) {
                    $params = array_merge($params, $tmpParams);
                } else {
                    if ($params["department_id"] == COUNTRY_DEPARTAMENT) {
                        $params['highway'] = [str_replace("-shosse", "", $urlParams['objectType'])];
                    } elseif ($params["department_id"] == FOREIGN_DEPARTAMENT) {
                        $params['country'] = [$urlParams['objectType']];
                        if($urlParams['regionAddress']){
                            $params['city'] = [$urlParams['regionAddress']];
                        }                        
                    } else {
                        $params['district'] = [$urlParams['objectType']];
                    }
                }
            }
            if ($urlParams['regionAddress']) {
                $params = array_merge($params, markerTypeInField($urlParams['regionAddress']));
            }
        }
    }
    if ($params['locality']) {
        unset($params['district']);
    }
    $APPLICATION->SetPageProperty('front_page', 'catalog');
    $result = $APPLICATION->IncludeComponent(
        "custom:object.filter",
        "",
        array(
            'DEPARTAMEN_ID' => $departamentId,
            'PARAMS' => $params,
        ),
        false
    );
    $APPLICATION->IncludeComponent(
        "custom:catalog",
        "",
        array(
            'DEPARTAMEN_ID' => $departamentId,
            'PARAMS' => $params,
            "FILTER" => [
                'bool' => $result['filter'],
            ],
            'json' => $result['json'],
            "CATALOG_LIST" => true,
        ),
        false
    );
};

$generateDetailPage = function ($urlParams) {
    global $APPLICATION;
    $Obj = ObjectsTable::wakeUpObject($urlParams['id']);
    $Obj->fill();
    $json = $Obj->getInfo();
    $url = $APPLICATION->GetCurDir();
    $json['id'] = $Obj->getId();
    $urlDetail = Data::createUrl([], $json);
    if ($json == null || $Obj->getActive() != 1) {
        show404();
    }
    if ($urlDetail != $url) {
        LocalRedirect($urlDetail, false, '301 Moved permanently');
    }
    global $APPLICATION;
    $APPLICATION->SetPageProperty('front_page', 'detail');
    $APPLICATION->IncludeComponent(
        "custom:object.detail",
        "",
        array(
            'ID' => $urlParams['id'],
            'DEPARTAMENT_ID' => getDepartamentId($urlParams['departament']),
        )
    );
};

$generateDetailPagePdf = function ($urlParams) {
    global $APPLICATION;
    if ($_REQUEST['html'] == 'Y') {
        $APPLICATION->SetPageProperty('front_page', 'pdf');
        $APPLICATION->SetPageProperty('noJs', true);
        $APPLICATION->IncludeComponent(
            "custom:object.detail",
            "",
            array(
                'ID' => $urlParams['id'],
                'DEPARTAMENT_ID' => getDepartamentId($urlParams['departament']),
                'PDF' => true,
            )
        );
    } else {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        $pdf = new Pdf('https://admin:idem@' . SITE_SERVER_NAME . $APPLICATION->GetCurPageParam('html=Y'));
        $globalOptions = [
            'margin-bottom' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-top' => 0,
            'page-width' => 1840,
            'dpi' => 300,
            'zoom' => 0.58,
            'page-size' => 'A4',
            'disable-smart-shrinking',
        ];
        $pdf->setOptions($globalOptions);
        //$pdf->saveAs('/upload/prez_tmp/'.$urlParams['id'].'.pdf');
        if (!$pdf->send()) {
            $error = $pdf->getError();
            dump($error);
        }
        die();
    }
};

$generateDetailDistricts = function ($urlParams) {
    global $APPLICATION;
    Loader::includeModule('iblock');
    $arFilter = array("IBLOCK_CODE" => 'areas_ru', "CODE" => $urlParams['code'], "ACTIVE" => "Y");
    $res = \CIBlockElement::GetList(array(), $arFilter);
    while ($ob = $res->GetNextElement()) {
        $arDistr = $ob->GetFields();
    }
    if (!$arDistr) {
        show404();
    }
    $APPLICATION->SetPageProperty('front_page', 'detail');
    $APPLICATION->IncludeComponent(
        "custom:district.desc",
        "",
        array(
            'CODE' => $urlParams['code'],
            'IBLOCK_CODE' => 'areas_ru',
        )
    );
};

$router->get('gorod/rayon-(\w+)/', function ($code) use ($generateDetailDistricts) {
    $params = get_defined_vars();
    unset($params['generateDetailDistricts']);
    call_user_func_array($generateDetailDistricts, [$params]);
});

$router->get('(gorod|commerce|foreign-real-estate)/(sale|arenda)/([^/]+)ID(\d+)/pdf/', function ($departament, $dealType, $name, $id) use ($generateDetailPagePdf) {
    $params = get_defined_vars();
    unset($params['generateDetailPagePdf']);
    $generateDetailPagePdf($params);
});

$router->get('(gorod|commerce|foreign-real-estate)/(sale|arenda)/ID(\d+)/pdf/', function ($departament, $dealType, $id) use ($generateDetailPagePdf) {
    $params = get_defined_vars();
    unset($params['generateDetailPagePdf']);
    $generateDetailPagePdf($params);
});

$router->get('(zagorod)/(sale|arenda|poselok)/([^/]+)/([^/]+)ID(\d+)/pdf/', function ($departament, $objectType, $highway, $name, $id) use ($generateDetailPagePdf) {
    $params = get_defined_vars();
    unset($params['generateDetailPagePdf']);
    $generateDetailPagePdf($params);
});

$router->get('(zagorod)/(sale|arenda|poselok)/([^/]+)/ID(\d+)/pdf/', function ($departament, $objectType, $highway, $id) use ($generateDetailPagePdf) {
    $params = get_defined_vars();
    unset($params['generateDetailPagePdf']);
    $generateDetailPagePdf($params);
});

$router->get('(gorod|commerce)/(sale|arenda)/([^/]+)ID(\d+)/', function ($departament, $dealType, $name, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(gorod|commerce|zagorod|foreign-real-estate)/(sale|arenda)/ID(\d+)/', function ($departament, $dealType, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(zagorod)/(sale|arenda|poselok)/([^/]+)/([^/]+)ID(\d+)/', function ($departament, $objectType, $highway, $name, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(zagorod)/(sale|arenda|poselok)/([^/]+)/ID(\d+)/', function ($departament, $objectType, $highway, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(foreign-real-estate)/(sale|arenda)/([^/]+)/([^/]+)/ID(\d+)/', function ($departament, $objectType, $country, $city, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(foreign-real-estate)/(sale|arenda)/([^/]+)/ID(\d+)/', function ($departament, $objectType, $country, $id) use ($generateDetailPage) {
    $params = get_defined_vars();
    unset($params['generateDetailPage']);
    $generateDetailPage($params);
});

$router->get('(gorod|zagorod|commerce|foreign-real-estate)/(sale|arenda)(/[^/]+)?(/[^/]+)?(/[^/]+)?', function ($departament, $dealType, $objectType = null, $regionAddress = null, $address) use ($generateListPage) {
    $params = get_defined_vars();
    unset($params['generateListPage']);
    $generateListPage($params);
});

$router->get('(gorod|zagorod|commerce|foreign-real-estate)(/[^/]+)?', function ($departament, $tag) use ($generateListPage) {
    $params = get_defined_vars();
    unset($params['generateListPage']);
    $generateListPage($params);
});

$router->get('(gorod|zagorod|commerce|foreign-real-estate)(/[^/]+)?(/[^/]+)?', function ($departament, $objectType, $tag) use ($generateListPage) {
    $params = get_defined_vars();
    unset($params['generateListPage']);
    $generateListPage($params);
});

$router->set404(function () {
    show404();
});
$router->run();
require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php";
