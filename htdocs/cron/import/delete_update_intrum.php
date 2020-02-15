<?php
ini_set('memory_limit','2048M');

if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Idem\Realty\Import\Intrum;
use Bitrix\Main\Loader;
use Idem\Realty\Core\Departament\DepartamentTable;
use Idem\Realty\Core\Objects\Objects;
use Idem\Realty\Core\Objects\ObjectsCollection;
use Idem\Realty\Core\Manager\Manager;
use Idem\Realty\Core\Manager\ManagerCollection;
use app\Util\Util;

Loader::includeModule("idem.realty");
/**
 * Полное очищение таблицы с объектами и изображения
 */

$connection = \Bitrix\Main\Application::getConnection();
$connection->queryExecute("SET SESSION group_concat_max_len = 1000000;");
$result = $connection->queryExecute("TRUNCATE i_objects");

$file_img=$_SERVER["DOCUMENT_ROOT"].'/upload/realty_img_intrum/';
$file_img_cache=$_SERVER["DOCUMENT_ROOT"].'/upload/resize_cache/realty_img_intrum/';

RDir($file_img);
RDir($file_img_cache);
mkdir($_SERVER["DOCUMENT_ROOT"].'/upload/resize_cache/realty_img_intrum/', 0777);
/**
 * Функционал импорта данных из интрум. И внесения их в бд сайта
 */

$intrum = new Intrum();
$util = new Util();
$arLogData = [];
$arLogData[] = "Начало импорта ".date('d.m.Y H:i:s');

$departamentsCollections = DepartamentTable::getList()->fetchCollection();
$arDepartments = [];
foreach ($departamentsCollections as $arDepartment)
    $arDepartments[$arDepartment->getId()] = $arDepartment->collectValues();

$arData = $intrum::getManagers();
if(!empty($arData))
{
    if (!empty($arData)) {
        $baseManagersCollections = new ManagerCollection();
        foreach ($arData as $data) {
            if($data['type'] != 'generalmanager' || empty($data['mobilephone'][0]['phone']))
                continue;
            $manager = new Manager();
            $manager->set('ID', $data['id']);
            $manager->set('NAME', $data['name'].' '.$data['surname']);
            $manager->set('CODE', \Cutil::translit($data['name'].' '.$data['surname'], "ru", $intrum::TRANSLIT));
            $manager->set('PHONE', $data['mobilephone'][0]['phone']);
            $baseManagersCollections[] = $manager;
        }
        $baseManagersCollections->saveGroup(true);
    }
}

$total = 0;
$images = [];
$images_no_vot = [];
$arMapItems = [];
foreach ($arDepartments as $departmentID => $arDepartment) {
    $baseElementsCollections = new ObjectsCollection();
    $elements = $intrum->getElements($departmentID);
    foreach ($elements as $element) {
        $object = new Objects();
        $object->set('ID', $element['id']);
        $object->set('DEPARTAMENT_ID', $departmentID);
        if ($intrum->checkStatus($element, $departmentID)) {
            $object->set('ACTIVE', 1);
        } else {
            $object->set('ACTIVE', 0);
        }
        $object->set('LAST_MODIFY', date('d.m.Y H:i:s', MakeTimeStamp($element['last_modify'], 'YYYY-MM-DD HH:MI:SS')));
        $objectJson = $intrum->getDataJsonFormat($element, $departmentID, $arDepartments);
        
        if(empty($images) && !empty($objectJson['all_images']))
            $images = $objectJson['all_images'];
        elseif(!empty($images) && !empty($objectJson['all_images'])){
            $images = array_merge($images, $objectJson['all_images']);
        }
        if(empty($images_no_vot) && !empty($objectJson['all_images_no_votermark']))
            $images_no_vot = $objectJson['all_images_no_votermark'];
        elseif(!empty($images_no_vot) && !empty($objectJson['all_images_no_votermark'])){
            $images_no_vot = array_merge($images_no_vot, $objectJson['all_images_no_votermark']);
        }
        unset($objectJson['all_images']);
        unset($objectJson['all_images_no_votermark']);
        $object->set('INFO', json_encode($objectJson));
        $baseElementsCollections[] = $object;
    }
    
    if(empty($elements))
        continue;
    $arTempMapItems = array_map(function($item) {
        return ['name'=>$item['id'],'code'=>$item['id'],'publish'=>(int)$item['publish']];
    }, $elements);
    
    $arMapItems[$departmentID] = $arTempMapItems;
    
    $start = microtime(true);
    $connection = Bitrix\Main\Application::getConnection();
    $tracker = $connection->startTracker(true);
    $arLogData[] = "Начало загрузки данных базовых элементов для департамента {$departmentID}";

    $arSaveLog = $baseElementsCollections->saveGroup(true);
    foreach ($arSaveLog as $logText)
        $arLogData[] = $logText;
    $connection->stopTracker();
    $arLogData[] = "Время выполнения запросов для департамента - {$departmentID}: " . round(microtime(true) - $start, 4) . ' сек.';

    foreach ($tracker->getQueries() as $query) {
        $total += $query->getTime(); // Время выполнения запроса в секундах
    }
    $intrum::arrayLog('import', $arLogData);
}
global $CACHE_MANAGER;
$CACHE_MANAGER->ClearByTag("iblock_id_exist_variables");
$arLogData[] = 'Время выполнения скрипта: ' . $total . ' сек.' ;
$arLogData[] = 'Импорт объектов закончен: ' . date('d.m.Y H:i:s');
$arLogData[] = 'Далее копирование картинок и переиндексация объектов';
$intrum::arrayLog('import', $arLogData);

/*переиндексация объектов*/
$intrum->objectsIndex();
/*заполнение кастомных иб для формирования site map недвижки*/
/* теперь заполнение происходит в файле /cron/sitemap_content.php*/
/*if(!empty($arMapItems)){
    $arLogData = [];
    $arLogData[] = 'Начало записи элементов иб для sitemap: ' . date('d.m.Y H:i:s');
    foreach ($arMapItems as $departmentID => $mapItems) {
        $arLogData[] = 'Запись эл-в департамента - '.$departmentID;
        $util->updateSitemapIblock($departmentID, $mapItems);
    }
    $arLogData[] = 'Запись эл-в закончена: ' . date('d.m.Y H:i:s');
    $intrum::arrayLog('site_map', $arLogData);
}*/

/*сохранение картинок интрума на нашем серваке с вотермарками*/
$intrum->saveIntrumImgs($images);
/*сохранение картинок интрума на нашем серваке без вотермарок*/
$intrum->saveIntrumImgs($images_no_vot,1,true);
