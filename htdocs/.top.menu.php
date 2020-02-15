<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<?
$aMenuLinks = array(
    array(
        "Городская",
        "/" . LIVE_REALTY_URL . "/",
        array(),
        array('type' => LIVE_REALTY_URL),
        "",
    ),
    array(
        "Загородная",
        "/" . COUNTRY_REALTY_URL . "/",
        array(),
        array('type' => COUNTRY_REALTY_URL),
        "",
    ),
    array(
        "Коммерческая",
        //"/".COMMERC_REALTY_URL."/",
        "javascript::void(0)",
        array(),
        [],//Array('type'=>COMMERC_REALTY_URL),
        ""
    ),
    array(
        "Зарубежная",
        "/".FOREIGN_REALTY_URL."/",   
        array(),
        array('type'=>FOREIGN_REALTY_URL),
        ""
    ),
    array(
        "О компании",
        "about/",
        array(),
        array(),
        "",
    ),
    array(
        "Контакты",
        "contacts/",
        array(),
        array(),
        "",
    ),
);
