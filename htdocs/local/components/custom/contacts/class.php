<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;


class ContactsPage extends CBitrixComponent
{
    public function breadCrumbsFormat($arBreadCrumbs)
    {
        $arData = [];
        foreach ($arBreadCrumbs as $arBreadCrumb) {
            $arData[] = [
                'title' => $arBreadCrumb['TITLE'],
                'href' => $arBreadCrumb['LINK']
            ];
        }

        return $arData;
    }

    public function getWorkers()
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $cacheTime = 3600 * 20;
        $cache_dir = '/custom_workers';
        $arCache = array_merge($this->arParams, ['func' => $cache_dir, 'cache_time' => $cacheTime]);
        $cache_id = md5(serialize($arCache));
        $arResult = [];

        if ($cache->initCache($cacheTime, $cache_id, $cache_dir)) {
            $arResult = $cache->getVars();
        } elseif ($cache->startDataCache() && Loader::includeModule('iblock')) {
            $iblockID = getIBlockIdByCode($this->arParams["WORKERS_IBLOCK_CODE"]);
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($cache_dir);
            $CACHE_MANAGER->RegisterTag('iblock_id_' . $iblockID);

            $arSelect = ["ID", "NAME", "CODE", "PROPERTY_POST", "PROPERTY_EMAIL", "PREVIEW_PICTURE", "DETAIL_PICTURE"];
            $arFilter = ["IBLOCK_ID" => $iblockID, "ACTIVE" => "Y"];

            $res = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
            while ($row = $res->GetNext()) {
                $arImgs = [];
                if (!empty($row['PREVIEW_PICTURE'])) {
                    $arFile = \CFile::ResizeImageGet($row['PREVIEW_PICTURE'], array('width' => 1440, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                    $arImgs['desktop'] = [
                        $arFile["src"],
                    ];
                    if ($row['DETAIL_PICTURE']) {
                        $arWebpFile = \CFile::ResizeImageGet($row['DETAIL_PICTURE'], array('width' => 1440, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                        $arImgs['desktop'][] = $arWebpFile["src"];
                    }

                    $arFile = \CFile::ResizeImageGet($row['PREVIEW_PICTURE'], array('width' => 768, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                    $arImgs['tablet'] = [
                        $arFile["src"],
                    ];
                    if ($row['DETAIL_PICTURE']) {
                        $arWebpFile = \CFile::ResizeImageGet($row['DETAIL_PICTURE'], array('width' => 768, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                        $arImgs['tablet'][] = $arWebpFile["src"];
                    }

                    $arFile = \CFile::ResizeImageGet($row['PREVIEW_PICTURE'], array('width' => 375, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                    $arImgs['mobile'] = [
                        $arFile["src"],
                    ];
                    if ($row['DETAIL_PICTURE']) {
                        $arWebpFile = \CFile::ResizeImageGet($row['DETAIL_PICTURE'], array('width' => 375, 'height' => 0), BX_RESIZE_IMAGE_EXACT, true);
                        $arImgs['mobile'][] = $arWebpFile["src"];
                    }
                }
                $arResult[] = [
                    "sources" => $arImgs,
                    "alt" => "avatar",
                    "title" => "avatar",
                    "name" => $row['NAME'],
                    "post" => $row['PROPERTY_POST_VALUE'],
                    "mail" => $row['PROPERTY_EMAIL_VALUE'],
                    "mailUrl" => $row['PROPERTY_EMAIL_VALUE']
                ];
            }

            $CACHE_MANAGER->EndTagCache();
            $cache->endDataCache($arResult);
        }

        return $arResult;
    }

    public function executeComponent()
    {
        global $APPLICATION;
        $this->arResult = [];
        $chain = $APPLICATION->GetNavChain(false, false, false, true);
        $util = new app\Util\Util();
        $arCompany = $util->getCompanyData();
        $this->arResult['contacts']['breadcrumbs'] = $this->breadCrumbsFormat($chain);
        $this->arResult['contacts']['map'] = [
            "center" => $arCompany['map']['no_format'],
            "markers" => [
                [
                    "coords" => $arCompany['map']['no_format'],
                    "type" => "main",
                    "icon" => "/assets/svg/map/main-pin.svg",
                    "content" => ""
                ]
            ]
        ];
        $res = \Idem\CIdemStatic::getInstance();
        $APPLICATION->SetPageProperty("og:title", '<meta property="og:title" content="' . $res->get('about_' . LANGUAGE_ID . '.og_title') . '"/>');
        $APPLICATION->SetPageProperty("og:description", '<meta property="og:description" content="' . $res->get('about_' . LANGUAGE_ID . '.og_description') . '"/>');
        $APPLICATION->SetPageProperty("og:image", '<meta property="og:image" content="' . $res->get('site_' . LANGUAGE_ID . '.og_logo_file') . '"/>');
        $arSocial = $res->get('contacts_' . LANGUAGE_ID . '.social');
        $arTempRequisites = $res->get('contacts_' . LANGUAGE_ID . '.requisites');
        foreach ($arTempRequisites as $arData)
            $arRequisites[] = $arData;
        $this->arResult['contacts']['socials'] = [
            "title" => $res->get('contacts_' . LANGUAGE_ID . '.social_title'),
            "links" => $arSocial
        ];
        $this->arResult['contacts']['contacts'] = [
            [
                "title" => $res->get('contacts_' . LANGUAGE_ID . '.address_title'),
                "url" => "#",
                "text" => $res->get('contacts_' . LANGUAGE_ID . '.address_text')
            ],
            [
                "title" => $res->get('contacts_' . LANGUAGE_ID . '.phone_title'),
                "text" => $res->get('contacts_' . LANGUAGE_ID . '.phone_text'),
                "url" => str_replace(['(', ')', ' ', '-'], '', $res->get('contacts_' . LANGUAGE_ID . '.phone_text'))
            ],
            [
                "title" => $res->get('contacts_' . LANGUAGE_ID . '.email_title'),
                "url" => $res->get('contacts_' . LANGUAGE_ID . '.email_text'),
                "text" => $res->get('contacts_' . LANGUAGE_ID . '.email_text')
            ]
        ];
        $this->arResult['contacts']['requisites'] = $arRequisites;
        if(!empty($this->getWorkers())){
            $this->arResult['contacts']['avatar']['items'] = $this->getWorkers();
        }
        $this->arResult['contacts']['question'] = [
            "title" => $res->get('contacts_' . LANGUAGE_ID . '.form_title'),
            "desc" => $res->get('contacts_' . LANGUAGE_ID . '.form_descr'),
            "numTitle" => $res->get('contacts_' . LANGUAGE_ID . '.form_phone_title'),
            "num" => $res->get('contacts_' . LANGUAGE_ID . '.form_phone'),
            "form" => [
                "action" => "/ajax/contacts.php",
                "hidden" => [
                    "page" => $APPLICATION->GetCurDir()
                ],
                "inputs" => [
                    [
                        "title" => GetMessage("name"),
                        "placeholder" => GetMessage("name") . "*",
                        "value" => "",
                        "name" => "SIMPLE_QUESTION_551",
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
                        "title" => GetMessage("phone"),
                        "placeholder" => "+7 (___) ___-__-__*",
                        "value" => "",
                        "name" => "SIMPLE_QUESTION_182",
                        "type" => "text",
                        "className" => "input--phone",
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
                    ]
                ],
                "textarea" => [
                    "placeholder" => GetMessage("yourQuest"),
                    "name" => "SIMPLE_QUESTION_327",
                    "value" => ""
                ],
                "btn" => GetMessage("send"),
                "checkbox" => [
                    "name" => "agreement",
                    "value" => "agree",
                    "checked" => false,
                    "text" => GetMessage("agreePersonal")
                ]
            ]
        ];
        $GLOBALS["JsonInit"]['contacts'] = $this->arResult['contacts'];

        setJsonInit('popups/form/writeUs', [

            "title" => GetMessage("writeUs"),
            "action" => "/ajax/write_us_contact.php",
            "hidden" => [
                "ids" => "#"
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
                    "name" => "email",
                    "placeholder" => "E-mail*",
                    "value" => "",
                    "checked" => [
                        "value" => "waiting",
                        "required" => true,
                        "email" => true
                    ]
                ], [
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
        $this->includeComponentTemplate();

        return $this->arResult;
    }

} ?>
