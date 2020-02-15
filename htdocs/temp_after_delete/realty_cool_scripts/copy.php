<?php
//die();
echo "Создание справочников<br>";
$arCopy = [
//    'country' => ['Страна','страну'],
//    'valute' => ['Валюта','валюту'],
//    'flattype' => ['Тип квартиры','тип квартиры'],
//    'departament' => ['Департамент','департамент'],
//    'builtstatus' => ['Готовность','готовность'],
//    'finishtype' => ['Отделка','отделку'],
//    'dealtype' => ['Тип сделки','тип сделки'],
//    'objecttype' => ['Тип объекта','тип объекта'],
//    'wallmaterial' => ['Материал стен','материал стен'],
//    'realtyclass' => ['Класс недвижимости','класс недвижимости'],
//    'transportring' => ['Транспортное кольцо','транспортное кольцо'],
//    'district' => ['Округ','округ'],
//    'locality' => ['Район','район'],
//    'metro' => ['Метро','метро'],
//    'highway' => ['Шоссе','шоссе'],
//    'tags' => ['Теги','тег'],
//    'bathroom' => ['Санузел','санузел'],
//    'view' => ['Вид из окна','вид из окна'],
//    'infrastructure' => ['Инфраструктура','инфраструктура'],
//    'builttype' => ['Тип здания','Тип здания'],
//    'useroom' => ['Назначение помещения','Назначение помещения'],
//    'commerctype' => ['Тип недвижимости коммерции','Тип недвижимости коммерции'],
//    'countrytype' => ['Тип загородной недвижимости','Тип загородной недвижимости'],
//    'parkingtype' => ['Тип парковки','Тип парковки'],
//    'parkingtype' => ['Тип парковки','Тип парковки'],
//    'parking' => ['С парковкой','С парковкой'],
//    'forest' => ['Лес рядом','Лес рядом'],
//    'water' => ['У водоема','У водоема'],
//    'foreigntype' => ['Типы зарубежки','Типы зарубежки'],
//    'zhkclass' => ['Класс ЖК','Класс ЖК'],
//    'finishyear' => ['Готовность дома','Готовность дома'],
//    'seo' => ['Сео','Сео'],
];

foreach ($arCopy as $name => $arRusNames){
    if(mkdir($_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name)) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/local/modules/idem.realty/lib/core/" . $name . "/admininterface");
        copy($_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/city/citytable.php", $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/".$name."table.php");
        copy($_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/city/admininterface/cityadmininterface.php", $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."admininterface.php");
        copy($_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/city/admininterface/cityedithelper.php", $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."edithelper.php");
        copy($_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/city/admininterface/citylisthelper.php", $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."listhelper.php");
        
        $arTempFilesPathes = [
            $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/".$name."table.php",
            $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."admininterface.php",
            $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."edithelper.php",
            $_SERVER['DOCUMENT_ROOT']."/local/modules/idem.realty/lib/core/".$name."/admininterface/".$name."listhelper.php"
        ];
        foreach ($arTempFilesPathes as $path) {
            $file_contents = file_get_contents($path);
            $file_contents = str_replace("city", $name, $file_contents);
            file_put_contents($path, $file_contents);
            
            $file_contents = file_get_contents($path);
            $file_contents = str_replace("City", ucfirst($name), $file_contents);
            file_put_contents($path, $file_contents);
            
            $file_contents = file_get_contents($path);
            $file_contents = str_replace("Города", $arRusNames[0], $file_contents);
            file_put_contents($path, $file_contents);
            
            $file_contents = file_get_contents($path);
            $file_contents = str_replace("город", $arRusNames[1], $file_contents);
            file_put_contents($path, $file_contents);
        }
        echo $name." cкопировали!<br>";
    }
    else{
        echo "Нет доступа на запись";
        die();
    }
}
$arInstall = [];
$arRequire = [];
foreach ($arCopy as $name => $arRusNames) {
    $ucFirct = ucfirst($name);
    $arInstall[] = $ucFirct;
    $arRequire[] = "require("."$"."_SERVER[\"DOCUMENT_ROOT\"]."."\""."/local/modules/idem.realty/lib/core/".$name."/".$name."table.php\");";
}
$installList = implode("','",$arInstall);
echo "Скопировать в /local/modules/idem.realty/install/index.php";
echo "$"."arInstall = ['".$installList."'];<br>";

foreach ($arRequire as $require){
    echo $require.PHP_EOL;
}