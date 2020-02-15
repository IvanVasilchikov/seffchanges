<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

class CompanyPage extends CBitrixComponent
{
    public function breadCrumbsFormat($arBreadCrumbs)
    {
        $arData = [];
        foreach ($arBreadCrumbs as $arBreadCrumb) {
            $arData[] = [
                'title' => $arBreadCrumb['TITLE'],
                'href' => $arBreadCrumb['LINK'],
            ];
        }

        return $arData;
    }

    public function getFeatures()
    {
        $arResult = [];
        $util = new app\Util\Util();
        $arData = $util->getTypicalData($this->arParams['COMPANY_FEATURES_IBLOCK_CODE'], false, false, ['LINK'], true);
        foreach ($arData as $key => $data) {
            if (($key + 1) < 10) {
                $num = "0" . ($key + 1);
            } else {
                $num = $key + 1;
            }

            $arResult[] = [
                "number" => $num,
                "title" => $data['NAME'],
                "text" => $data['PREVIEW_TEXT'],
                "button" => [
                    "text" => $data['PROPERTY_LINK_DESCRIPTION'],
                    "popup" => "",
                ],
            ];
        }

        return $arResult;
    }

    public function getClients()
    {
        $arResult = [];
        $util = new app\Util\Util();
        $arData = $util->getTypicalData($this->arParams['CLIENTS_IBLOCK_CODE'], false, false, [], true, [], ['PREVIEW_PICTURE']);
        foreach ($arData as $key => $data) {
            $arResult[] = [
                "url" => "#",
                "img" => [
                    "src" => $data['PREVIEW_PICTURE'][0],
                    "alt" => $data['NAME'],
                ],
            ];
        }

        return $arResult;
    }

    public function getServises()
    {
        $res = \Idem\CIdemStatic::getInstance();
        $arResult = [
            "title" => $res->get('about_' . LANGUAGE_ID . '.services_title'),
            "subtitle" => $res->get('about_' . LANGUAGE_ID . '.services_sub_title'),
        ];
        $util = new app\Util\Util();

        $arBtns = [];
        $arTabs = [];
        $arData = $util->getTypicalData($this->arParams['SERVICES_IBLOCK_CODE'], false, true, ['FILE'], true, [], ['PROPERTY_FILE_VALUE']);
        foreach ($arData['SECTIONS'] as $key => $data) {
            $arBtns[] = [
                "text" => $data['NAME'],
                "value" => $data['CODE'],
            ];
            $arItems = [];
            foreach ($data['ITEMS'] as $arItem) {
                $arItems[] = [
                    // "link" => $arItem['DETAIL_PAGE_URL'],
                    "ico" => $arItem['PROPERTY_FILE_VALUE'][0],
                    "title" => $arItem['NAME'],
                    "text" => $arItem['~PREVIEW_TEXT'],
                ];
            }
            $arTabs[] = [
                "name" => $data['CODE'],
                "services" => $arItems,
            ];
        }
        $arResult['buttons'] = $arBtns;
        $arResult['tabs'] = $arTabs;

        return $arResult;
    }
    public function getLeadership()
    {
        $arResult = [];
        $util = new app\Util\Util();

        $arData = $util->getTypicalData($this->arParams['GUIDE_IBLOCK_CODE'], false, false, ['POST', 'EXPERIENCE'], true, [], ['PREVIEW_PICTURE']);
        foreach ($arData as $key => $data) {
            $arResult[] = [
                "quote" => $data['PREVIEW_TEXT'],
                "name" => $data['NAME'],
                "post" => $data['PROPERTY_POST_VALUE'],
                "description" => $data['PROPERTY_EXPERIENCE_VALUE'],
                "image" => [
                    "sources" => [
                        "desktop" => [$data['PREVIEW_PICTURE'][0], ""],
                    ],
                    "alt" => $data['NAME'],
                    "title" => $data['NAME'],
                ],
            ];
        }

        return $arResult;
    }

    public function getMapPoints()
    {
        $arResult = [];
        $arTypes = [];
        Loader::includeModule('iblock');
        $arSelect = array("ID", "NAME", "CODE", "PROPERTY_ICON");
        $arFilter = array("IBLOCK_ID" => IntVal(getIBlockIdByCode('type_point_' . LANGUAGE_ID)), "ACTIVE" => "Y");
        $res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNext()) {
            $arTypes[$ob['ID']] = [
                "code" => $ob['CODE'],
                "icon" => \CFile::GetPath($ob['PROPERTY_ICON_VALUE']),
            ];
        }

        $arSelect = array("ID", "NAME", "PROPERTY_TYPE", "PROPERTY_MAP");
        $arFilter = array("IBLOCK_ID" => IntVal(getIBlockIdByCode('about_map_points_' . LANGUAGE_ID)), "ACTIVE" => "Y");
        $res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNext()) {
            $arResult[] = [
                "coords" => $ob['PROPERTY_MAP_VALUE'],
                "icon" => $arTypes[$ob['PROPERTY_TYPE_VALUE']]['icon'],
                "type" => $arTypes[$ob['PROPERTY_TYPE_VALUE']]['code'],
                "infoWindow" => $ob['NAME'],
                "id" => $ob['ID'],
            ];
        }

        return $arResult;
    }

    public function getAwards()
    {
        $res = \Idem\CIdemStatic::getInstance();
        $arResult = [
            "title" => $res->get('about_' . LANGUAGE_ID . '.awards_title'),
            "subtitle" => $res->get('about_' . LANGUAGE_ID . '.awards_sub_title'),
        ];

        $util = new app\Util\Util();

        $arYears = [];
        $arTabs = [];
        $arData = $util->getTypicalData($this->arParams['AWARDS_IBLOCK_CODE'], false, true, [], true, [], ['PREVIEW_PICTURE']);
        foreach ($arData['SECTIONS'] as $key => $data) {
            $arYears[] = [
                "text" => $data['NAME'],
                "value" => $data['NAME'],
            ];
            $arItems = [];
            foreach ($data['ITEMS'] as $arItem) {
                $arItems[] = [
                    "title" => $arItem['NAME'],
                    "image" => [
                        "sources" => [
                            "desktop" => [$arItem['PREVIEW_PICTURE'][0], ""],
                        ],
                        "alt" => $arItem['NAME'],
                        "title" => $arItem['NAME'],
                    ],
                ];
            }
            $arTabs[] = [
                "year" => $data['NAME'],
                "list" => $arItems,
            ];
        }
        $arResult['years'] = $arYears;
        $arResult['sliders'] = $arTabs;
        if(empty($arResult['years']) && empty($arResult['sliders'])){
            $arResult=[];
        }

        return $arResult;
    }

    public function executeComponent()
    {
        global $APPLICATION;
        $this->arResult = [];
        $chain = $APPLICATION->GetNavChain(false, false, false, true);

        $res = \Idem\CIdemStatic::getInstance();
        $APPLICATION->SetPageProperty("og:title", '<meta property="og:title" content="' . $res->get('about_' . LANGUAGE_ID . '.og_title') . '"/>');
        $APPLICATION->SetPageProperty("og:description", '<meta property="og:description" content="' . $res->get('about_' . LANGUAGE_ID . '.og_description') . '"/>');
        $APPLICATION->SetPageProperty("og:image", '<meta property="og:image" content="' . $res->get('site_' . LANGUAGE_ID . '.og_logo_file') . '"/>');

        $this->arResult['about']['top']['breadcrumbs'] = $this->breadCrumbsFormat($chain);
        $this->arResult['about']['top']['image'] = [
            "sources" => [
                "mobile" => [$res->get('about_' . LANGUAGE_ID . '.about_top_mobile_file'), ""],
                "tablet" => [$res->get('about_' . LANGUAGE_ID . '.about_top_tablet_file'), ""],
                "desktop" => [$res->get('about_' . LANGUAGE_ID . '.about_top_desktop_file'), ""],
            ],
            "alt" => "about bg",
            "title" => "",
        ];
        $this->arResult['about']['top']['preTitle'] = $res->get('about_' . LANGUAGE_ID . '.about_title');
        $this->arResult['about']['top']['title'] = $res->get('about_' . LANGUAGE_ID . '.about_sub_title');
        $this->arResult['about']['top']['text'] = $res->get('about_' . LANGUAGE_ID . '.about_description');
        $this->arResult['about']['top']['info'] = $res->get('about_' . LANGUAGE_ID . '.about_advantages');
        $this->arResult['about']['features']['title'] = $res->get('about_' . LANGUAGE_ID . '.features_title');
        $this->arResult['about']['features']['subtitle'] = $res->get('about_' . LANGUAGE_ID . '.features_sub_title');
        $this->arResult['about']['features']['list'] = $this->getFeatures();

        $this->arResult['about']['location']['image'] = [
            "sources" => [
                "desktop" => [$res->get('about_' . LANGUAGE_ID . '.location_img_file'), ""],
            ],
            "alt" => "Монако",
            "title" => "",
        ];
        $this->arResult['about']['location']['preTitle'] = $res->get('about_' . LANGUAGE_ID . '.location_title');
        $this->arResult['about']['location']['title'] = $res->get('about_' . LANGUAGE_ID . '.location_sub_title');
        $this->arResult['about']['location']['link'] = [
            "url" => $res->get('about_' . LANGUAGE_ID . '.location_more_link'),
            "text" => $res->get('about_' . LANGUAGE_ID . '.location_more_btn'),
        ];
        $this->arResult['about']['location']['map'] = [
            "center" => $res->get('about_' . LANGUAGE_ID . '.location_map_center'),
            "markers" => $this->getMapPoints(),
        ];
        $this->arResult['about']['services'] = $this->getServises();
        if(!empty($this->getLeadership())){
            $this->arResult['about']['leadership'] = [
                "title" => $res->get('about_' . LANGUAGE_ID . '.leadership_title'),
                "slides" => $this->getLeadership(),
            ];
        }
        

        $this->arResult['about']['awards'] = $this->getAwards();

        $this->arResult['about']['clients'] = [
            "title" => $res->get('about_' . LANGUAGE_ID . '.clients_title'),
            "items" => $this->getClients(),
            // "moreClients" => "/ajax/json/clients.json",
        ];
        $GLOBALS["JsonInit"]['about'] = $this->arResult['about'];
        $this->includeComponentTemplate();

        return $this->arResult;
    }

}
