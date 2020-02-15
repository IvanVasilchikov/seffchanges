<?php
ini_set('memory_limit','2048M');

if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include_once __DIR__.'/../modules/idem.realty/lib/utilities/migration.php';

use Bitrix\Main\Loader;
use Idem\Realty\Core\Objects\ObjectsTable;
use Idem\Realty\Realty\Data;
use Phinx\Migration\AbstractMigration;
use Idem\Realty\Utilities\Migration;
use Idem\Realty\Import\Intrum;

Loader::includeModule("idem.realty");
Loader::includeModule("iblock");
/*заполнение выборок для карты сайта*/
$arBlocks = [
    LIVE_DEPARTAMENT=>'group_zhk_sitemap',
    COUNTRY_DEPARTAMENT=>'group_country_sitemap',
    COMMERC_DEPARTAMENT=>'group_commerc_sitemap',
    FOREIGN_DEPARTAMENT=>'group_foreign_sitemap',
];

foreach ($arBlocks as $block){
    Migration::removeAllInIBlock($block);
    Migration::removeAllSectInIBlock($block);
}

$typesNed=[LIVE_DEPARTAMENT, COMMERC_DEPARTAMENT, COUNTRY_DEPARTAMENT, FOREIGN_DEPARTAMENT];
foreach($typesNed as $typeNed){
    $el = new CIBlockElement;
    $types = Data::getGroupByField($typeNed, 'object_type', false);
    $tags = Data::getGroupByField($typeNed, 'tags', false);
    $id=Migration::getIBlockIdByFilter(['CODE' => $arBlocks[$typeNed]]);
    $urlMain = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale'],[]);
    Migration::createSection([
        "IBLOCK_ID" => $id,
        "NAME" => "Продажа",
        "CODE" => "sale"
    ]);   
    if($typeNed == LIVE_DEPARTAMENT || $typeNed == COMMERC_DEPARTAMENT){  
        $districts = Data::getGroupByField($typeNed, 'district', false);
        $localities = Data::getGroupByField($typeNed, 'locality', false);
        $metros = Data::getGroupByField($typeNed, 'metro', false);
        if($typeNed == LIVE_DEPARTAMENT){            
            $name="Продажа Городской недвижимости";
        }else{
            $name="Продажа Коммерческой недвижимости";
        }  
        foreach($districts as $district){
            $urlDistr = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "district"=> [$district["value"]]],[]);
            $name=$district["text"];            
            $arUrl=explode("/", $urlDistr);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);
        }
        foreach($localities as $locality){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "locality"=> [$locality["value"]]],[]);
            $name=$locality["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                "NAME" => $name,
                "CODE" => $arUrl[4]
            ]);
        }
        foreach($metros as $metro){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale',"metro"=> [$metro["value"]]],[]);
            $name=$metro["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                "NAME" => $name,
                "CODE" => $arUrl[4]
            ]);
        }
        foreach($tags as $tag){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "tags"=> [$tag["value"]]],[]);
            $name=$tag["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "NAME" => $name,
                "CODE" => $arUrl[2]
            ]);            
        }
        //тип
        foreach($types as $type){
            $urlSec = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"]],[]);
            $name=$type["text"];
            $arUrlType=explode("/", $urlSec);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrlType[3]
            ]);
            foreach($districts as $district){
                $urlDistr = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"district"=> [$district["value"]]],[]);
                $name=$district["text"];
                $arUrl=explode("/", $urlDistr);
                Migration::createSection([
                    "IBLOCK_ID" => $id,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrlType[3]]),
                    "NAME" => $name,
                    "CODE" => $arUrl[4]
                ]);        
            }
            foreach($localities as $locality){
                $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"locality"=> [$locality["value"]]],[]);
                $name=$locality["text"];
                $arUrl=explode("/", $url); 
                $SectParent=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrlType[3]]);            
                Migration::createElement([
                    "IBLOCK_ID" => $id,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "SECTION_ID"=>$SectParent,"CODE"=>$arUrl[4]]),
                    "NAME" => $name,
                    "CODE" => $arUrl[5]
                ]);        
            }
            foreach($metros as $metro){
                $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"metro"=> [$metro["value"]]],[]);
                $name=$metro["text"];
                $arUrl=explode("/", $url); 
                $SectParent=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrlType[3]]);    
                Migration::createElement([
                    "IBLOCK_ID" => $id,
                    "NAME" => $name,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "SECTION_ID"=>$SectParent,"CODE"=>$arUrl[4],"DEPTH_LEVEL"=>3]),
                    "CODE" => $arUrl[5]
                ]);                         
            }            
        }
    }elseif($typeNed == COUNTRY_DEPARTAMENT){
        $highways = Data::getGroupByField($typeNed, 'highway', false);
        $name="Продажа загородной недвижимости";
        foreach($highways as $highway){
            $urlHigh = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "highway"=> [$highway["value"]]],[]);
            $name=$highway["text"];
            $arUrl=explode("/", $urlHigh);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);
        }        
        foreach($tags as $tag){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "tags"=> [$tag["value"]]],[]);
            $name=$tag["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "NAME" => $name,
                "CODE" => $arUrl[2]
            ]);
        }
        //тип
        foreach($types as $type){
            $urlSec = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"]],[]);
            $name=$type["text"];
            $arUrl=explode("/", $urlSec);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);
            foreach($highways as $highway){
                $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"highway"=> [$highway["value"]]],[]);
                $name=$highway["text"];
                $arUrl=explode("/", $url);
                Migration::createElement([
                    "IBLOCK_ID" => $id,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                    "NAME" => $name,
                    "CODE" => $arUrl[4]
                ]);
            }    
        }
    }elseif($typeNed == FOREIGN_DEPARTAMENT){
        $name="Продажа зарубежной недвижимости";
        $cities = Data::getGroupByField($typeNed, 'city', false);
        $countries = Data::getGroupByField($typeNed, 'country', false);               
        foreach($countries as $country){
            $urlCountr = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "country"=> [$country["value"]]],[]);
            $name=$country["text"];
            $arUrl=explode("/", $urlCountr);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);
        }
        foreach($cities as $city){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "city"=> [$city["value"]]],[]);
            $name=$city["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                "NAME" => $name,
                "CODE" => $arUrl[4]
            ]);
        }
        foreach($tags as $tag){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "tags"=> [$tag["value"]]],[]);
            $name=$tag["text"];
            $arUrl=explode("/", $url);
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "NAME" => $name,
                "CODE" => $arUrl[2]
            ]);
        }
        //тип
        foreach($types as $type){
            $urlSec = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"]],[]);
            $name=$type["text"];
            $arUrl=explode("/", $urlSec);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE" => "sale"]),
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);          
            foreach($countries as $country){
                $urlCountr = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"country"=> [$country["value"]]],[]);
                $name=$country["text"];
                $arUrl=explode("/", $urlCountr);
                Migration::createSection([
                    "IBLOCK_ID" => $id,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                    "NAME" => $name,
                    "CODE" => $arUrl[4]
                ]);        
            }
            foreach($cities as $city){
                $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "object_type"=>$type["value"],"city"=> [$city["value"]]],[]);
                $name=$city["text"];
                $arUrl=explode("/", $url);
                $SectParent=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]); 
                Migration::createElement([
                    "IBLOCK_ID" => $id,
                    "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "SECTION_ID"=>$SectParent,"CODE"=>$arUrl[4]]),
                    "NAME" => $name,
                    "CODE" => $arUrl[5]
                ]);       
            }            
        }

    }
}
/*заполнение элементов для карты сайта*/
$arBlocksForElement = [
    LIVE_DEPARTAMENT=>'zhk_sitemap',
    COUNTRY_DEPARTAMENT=>'country_sitemap',
    COMMERC_DEPARTAMENT=>'commerc_sitemap',
    FOREIGN_DEPARTAMENT=>'foreign_sitemap',
];
$intrum = new Intrum();
foreach ($arBlocksForElement as $block){
    Migration::removeAllInIBlock($block);
    Migration::removeAllSectInIBlock($block);
}
foreach($typesNed as $typeNed){
    $el = new CIBlockElement;
    $id=Migration::getIBlockIdByFilter(['CODE' => $arBlocksForElement[$typeNed]]);
    $elements = $intrum->getElements($typeNed, '');    
    if($typeNed == LIVE_DEPARTAMENT){
        foreach($elements as $element){
            $code='ID'.$element["id"];  
            $active='N';          
            if($element["copy"]=="0" && $element["name"] !=""){
                $code=\Cutil::translit($element["name"], "ru", Intrum::TRANSLIT).'-ID'.$element["id"];
            }elseif(Data::nameParent(intval($element["copy"])) != ""){
                $code=\Cutil::translit(Data::nameParent(intval($element["copy"])), "ru", Intrum::TRANSLIT).'-ID'.$element["id"];               
            }
            if ($intrum->checkStatus($element, $typeNed)) {
                $active='Y';
            }
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "NAME" => $element["id"],
                "CODE" => $code,
                "ACTIVE" => $active
            ]);
        }
    }
    if($typeNed == COUNTRY_DEPARTAMENT){        
        $highways = Data::getGroupByField($typeNed, 'highway', false);               
        Migration::createSection([
            "IBLOCK_ID" => $id,
            "NAME" => "Продажа",
            "CODE" => "sale"
        ]);  
        Migration::createSection([
            "IBLOCK_ID" => $id,
            "NAME" => "Поселок",
            "CODE" => "poselok"
        ]);
        $SectParentSale=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>"sale"]); 
        $SectParentPoselok=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>"poselok"]); 
        foreach($highways as $highway){
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>$SectParentSale,
                "NAME" => $highway["text"],
                "CODE" => $highway["value"].'-shosse'
            ]); 
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>$SectParentPoselok,
                "NAME" => $highway["text"],
                "CODE" => $highway["value"].'-shosse'
            ]); 
        }
        foreach($elements as $element){   
            $code='ID'.$element["id"]; 
            $SectParent=$SectParentSale;
            $active='N'; 
            if($element["copy"]=="0" && $element["fields"][525]==false){
                $code=\Cutil::translit($element["name"], "ru", Intrum::TRANSLIT).'-ID'.$element["id"];
                $SectParent=$SectParentPoselok;
            }elseif(Data::nameParent(intval($element["copy"])) != ""){
                $code=\Cutil::translit(Data::nameParent(intval($element["copy"])), "ru", Intrum::TRANSLIT).'-ID'.$element["id"];                              
            }   
            if ($intrum->checkStatus($element, $typeNed)) {
                $active='Y';
            }
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "SECTION_ID"=>$SectParent,"NAME"=>str_replace(" шоссе", "", $element["fields"][822])]),
                "NAME" => $element["id"],
                "CODE" => $code,
                "ACTIVE" => $active
            ]);       
        }        
    }
    if($typeNed == FOREIGN_DEPARTAMENT){
        $cities = Data::getGroupByField($typeNed, 'city', false);
        $countries = Data::getGroupByField($typeNed, 'country', false);
        foreach($countries as $country){
            $urlCountr = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "country"=> [$country["value"]]],[]);
            $name=$country["text"];
            $arUrl=explode("/", $urlCountr);
            Migration::createSection([
                "IBLOCK_ID" => $id,                
                "NAME" => $name,
                "CODE" => $arUrl[3]
            ]);
        }
        foreach($cities as $city){
            $url = Data::createUrl(['department_id'=> $typeNed, 'deal_type'=> 'sale', "city"=> [$city["value"]]],[]);
            $name=$city["text"];
            $arUrl=explode("/", $url);
            Migration::createSection([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "CODE"=>$arUrl[3]]),
                "NAME" => $name,
                "CODE" => $arUrl[4]
            ]);
        }
        foreach($elements as $element){ 
            $active='N'; 
            if($element["fields"][803]){
                $idSectPar=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "NAME"=>$element["fields"][802]]);
                $idSect=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "SECTION_ID"=>$idSectPar,"NAME"=>$element["fields"][803]]);
            }else{
                $idSect=Migration::getSectionIdByFilter(["IBLOCK_ID"=>$id, "NAME"=>$element["fields"][802]]);
            }
            if ($intrum->checkStatus($element, $typeNed)) {
                $active='Y';
            }
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "IBLOCK_SECTION_ID"=>$idSect,
                "NAME" => $element["id"],
                "CODE" => 'ID'.$element["id"],
                "ACTIVE" => $active
            ]);        
        } 
    }
    if($typeNed == COMMERC_DEPARTAMENT){
        foreach($elements as $element){
            $active='N'; 
            if ($intrum->checkStatus($element, $typeNed)) {
                $active='Y';
            }
            Migration::createElement([
                "IBLOCK_ID" => $id,
                "NAME" => $element["id"],
                "CODE" => 'ID'.$element["id"],
                "ACTIVE" => $active
            ]);
        }

    }
}
