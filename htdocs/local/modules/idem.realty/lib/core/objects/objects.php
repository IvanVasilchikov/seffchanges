<?php

namespace Idem\Realty\Core\Objects;

class Objects extends EO_Objects
{
    const departmentsIDs = [
        LIVE_REALTY_URL => 1,
        COMMERC_REALTY_URL => 2,
        COUNTRY_REALTY_URL => 3,
        FOREIGN_REALTY_URL => 5,
    ];

    public static function getFilterObjects($arParams = false,$list=false)
    {
        global $APPLICATION;
        $result = $APPLICATION->IncludeComponent(
            "custom:object.filter",
            "",
            [
                "PARAMS" => $arParams,
            ],
            false
        );
        if($list){
            $parComp=[
                "RETURN" => true,
                "FILTER" => [
                    'bool' => $result['filter'],
                ],
                "PARAMS" => $arParams,
                'json' => $result['json'],
                "CATALOG_LIST"=>true,
            ];
        }else{
            $parComp=[
                "RETURN" => true,
                "FILTER" => [
                    'bool' => $result['filter'],
                ],
                "PARAMS" => $arParams,
                'json' => $result['json'],
            ];
        }
        $res = $APPLICATION->IncludeComponent(
            "custom:catalog",
            "",
            $parComp,
            false
        );
        return $res;
    }

    public function getObjectsCnt()
    {
        $filter = self::getFilterObjects(false,true);    
        return ['count' => $filter['pagination']['total']];
    }
}
