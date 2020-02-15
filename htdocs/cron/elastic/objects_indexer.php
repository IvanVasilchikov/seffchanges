<?php
use Bitrix\Main\Loader;
use Idem\Realty\Import\Intrum;

if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
Loader::includeModule('idem.realty');

$intrum = new Intrum();
if (file_exists(__DIR__ . '/time.sync')) {
    $time = file_get_contents(__DIR__ . '/time.sync');
} else {
    $time = false;
}
$intrum->objectsIndex($time);
file_put_contents(__DIR__ . '/time.sync', time());
