<?
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Idem\Realty\Core\Departament\AdminInterface\DepartamentEditHelper;
use Idem\Realty\Core\Departament\AdminInterface\DepartamentListHelper;
use Idem\Realty\Core\Objects\AdminInterface\ObjectsListHelper;
use Idem\Realty\Core\Objects\AdminInterface\ObjectsEditHelper;
use Idem\Realty\Core\Seo\AdminInterface\SeoListHelper;
use Idem\Realty\Core\Seo\AdminInterface\SeoEditHelper;
CModule::IncludeModule('idem.realty');
return array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 0,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => 'Объекты',
        'url' => ObjectsListHelper::getUrl(),
        'more_url' => array(
            ObjectsEditHelper::getUrl()
        )
    ),
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 1,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => 'Департаменты',
        'url' => DepartamentListHelper::getUrl(),
        'more_url' => array(
            DepartamentEditHelper::getUrl(),
        )
    ),
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 1,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => 'Сео для списков',
        'url' => SeoListHelper::getUrl(),
        'more_url' => array(
            SeoEditHelper::getUrl(),
        )
    ),
);
?>