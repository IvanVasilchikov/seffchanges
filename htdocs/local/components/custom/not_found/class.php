<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;

class NotFound extends CBitrixComponent
{
    public function executeComponent()
    {
        $res = \Idem\CIdemStatic::getInstance();
        
        $this->arResult = [];
        $this->arResult['errorPage'] =  [
            "unfound" => $res->get('404_'.LANGUAGE_ID.'.404_title'),
            "desc" => $res->get('404_'.LANGUAGE_ID.'.404_text'),
            "linkText" => $res->get('404_'.LANGUAGE_ID.'.404_link_text'),
            "sources" => [
                "mobile" => [
                    $res->get('404_'.LANGUAGE_ID.'.404_mobile_file'),
                    ""
                ],
                "tablet" => [
                    $res->get('404_'.LANGUAGE_ID.'.404_tablet_file'),
                    ""
                ],
                "desktop" => [
                    $res->get('404_'.LANGUAGE_ID.'.404_desktop_file'),
                    ""
                ]
            ],
            "alt" => "houses",
            "title" => "houses"
        ];
        
        $this->includeComponentTemplate();
    }

}?>