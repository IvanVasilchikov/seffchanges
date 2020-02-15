<?php

namespace app\Util;

use Elasticsearch\ClientBuilder;
use morphos\Russian\NounDeclension;
use morphos\Russian\NounPluralization;


class RuleSeoList
{

  /*
    *   $num = 1,2,10
    */
  public static function getTargetByDepartament($target = "", $num = 1, $doTranslit = true)
  {
    $res = self::getValueByTranslit($target);
    if ($res) {
      $res = trim(str_replace($num, '', \morphos\Russian\pluralize($num, $res)));
    }
    return $res;
  }
  public static function getValueByTranslit($code)
  {
    if ($code) {
      $client = ClientBuilder::create()->setHosts(['elastic'])->setRetries(0)->build();
      $params = [
        'index' => 'realty_dictionary',
        'type' => '_doc',
        'id'	=> $code,
      ];
      try {
        $result = $client->get($params);
      } catch (\Exception $t) {
        $result = ['_source' => ['WORD' => '']];
      }
    }
    return $result['_source']['WORD'];
  }
  public static function getSeoData($arJsonData = [], $departmentID = 1, $doTranslit = true,$count="")
  {
    $arSeoData = [];
    $arTitle = [];
    $res = \Idem\CIdemStatic::getInstance();
    $title = $arJsonData['object_type'] ? $arJsonData['object_type'] : $arJsonData['tags'][0];
    $target1 = self::getTargetByDepartament($title, 1, $doTranslit);
    $targetRod = mb_strtolower(morpher_inflect($target1, 'rod'));
    $targetVin = mb_strtolower(morpher_inflect($target1, 'vin'));
    $targetsRod = mb_strtolower(morpher_inflect($target1, 'rod mn'));
    if($targetsRod=="#error: parameter 1 'text' is plural."){
      $targetsRod=$targetRod;
    }
    /** Тип **/
    if ($arJsonData["department_id"] == LIVE_DEPARTAMENT) {

      if($arJsonData["deal_type"]== "arenda"){
        $arTitle[]="Аренда";
        $arTitlePage[]="Аренда";
        $arKeywords1[]="Аренда";
        $arKeywords2[]="снять";
      }elseif(($arJsonData["deal_type"]== "sale" || !$arJsonData["deal_type"]) &&  ($arJsonData["object_type"]== "apartamenty" || !$arJsonData["object_type"])){
        $arTitle[]="Продажа";
        $arTitlePage[]="Продажа";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
      }else{
        $arTitle[]="Купить";
        $arTitlePage[]="Купить";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
      }
      /** Тип объекта **/
      if($arJsonData["object_type"] == "apartamenty"){
        $arTitle[]=$targetsRod;
        $arTitlePage[]=$targetsRod;
        $arKeywords1[]=$targetsRod;
        $arKeywords2[]=mb_strtolower ($target1);
      }elseif($arJsonData["object_type"]){
        if($arJsonData["object_type"]=="kvartira"){
          if($arJsonData["deal_type"]== "arenda"){
            $arTitle[]='элитных '.$targetsRod;
          }else{
            $arTitle[]='элитную '.$targetVin;
          }
          $arTitlePage[]='элитную '.$targetVin;
          $arKeywords1[]='элитных '.$targetsRod;
          $arKeywords2[]='элитную '.$targetVin;
        }else{
          if($arJsonData["deal_type"]== "arenda"){
            $arTitle[]=$targetRod;
          }else{
            $arTitle[]=mb_strtolower ($targetVin);
          }
          $arTitlePage[]=$targetVin;
          $arKeywords1[]=$targetsRod;
          $arKeywords2[]=mb_strtolower ($target1);
        }
      }elseif(!$arJsonData["deal_type"] && !$arJsonData["object_type"]&& $arJsonData["tags"][0]=='novostroyka'&& count($arJsonData["tags"])==1){
        $arTitle=[];
        $arTitlePage=[];
        $arKeywords1=[];
        $arTitle[]="Все элитные новостройки";
        $arTitlePage[]="Элитные новостройки";
        $arKeywords1[]="Элитные новостройки";

      }elseif(!$arJsonData["deal_type"] && !$arJsonData["object_type"]){
        $arTitle=[];
        $arTitlePage=[];
        $arKeywords1=[];
        $arTitle[]="Вся элитная недвижимость";
        $arTitlePage[]="Элитная недвижимость";
        $arKeywords1[]="Элитная недвижимость";
      }else{
        $arTitle[]="элитной недвижимости";
        $arTitlePage[]="элитной недвижимости";
        $arKeywords1[]="элитной недвижимости";
      }
      /** Расположение **/
      if($arJsonData["metro"] && count($arJsonData["metro"]) == 1){
        $arTitle[]='возле метро ' . self::getValueByTranslit($arJsonData["metro"][0]);
        $arTitlePage[]='возле метро ' . self::getValueByTranslit($arJsonData["metro"][0]);
        $arKeywords[]='возле метро ' . self::getValueByTranslit($arJsonData["metro"][0]);
      }elseif($arJsonData["locality"] && count($arJsonData["locality"]) == 1){
        $arTitle[]='в районе ' . self::getValueByTranslit($arJsonData["locality"][0]);
        $arTitlePage[]='в районе ' . self::getValueByTranslit($arJsonData["locality"][0]);
        $arKeywords[]='в районе ' . self::getValueByTranslit($arJsonData["locality"][0]);
      }elseif($arJsonData["district"] && count($arJsonData["district"]) == 1){
        $arTitle[]='в округе ' .self::getValueByTranslit($arJsonData["district"][0]);
        $arTitlePage[]='в округе ' .self::getValueByTranslit($arJsonData["district"][0]);
        $arKeywords[]='в округе ' .self::getValueByTranslit($arJsonData["district"][0]);
      }elseif(($arJsonData["deal_type"]== "sale" && !$arJsonData["object_type"]) || ( $arJsonData["tags"][0]=='novostroyka'&& count($arJsonData["tags"])==1) || (!$arJsonData["deal_type"]&&!$arJsonData["object_type"])){
        $arTitle[]="Москвы";
        $arTitlePage[]="Москвы";
        $arKeywords[]="Москвы";
      }else{
        $arTitle[]="в Москве";
        $arTitlePage[]="в Москве";
        $arKeywords[]="в Москве";
      }
    }
    if ($arJsonData["department_id"] == COUNTRY_DEPARTAMENT) {

      if($arJsonData["deal_type"]== "arenda"){
        $arTitle[]="Арендовать";
        $arKeywords1[]="Арендовать";
        $arKeywords2[]="снять";
        $arDescription[] = "Аренда";
      }elseif($arJsonData["deal_type"]== "arenda" && ($arJsonData["object_type"] == "taunkhaus")){
        $arTitle[]="Аренда";
        $arKeywords1[]="Арендовать";
        $arKeywords2[]="снять";
        $arDescription[] = "Аренда";
      }elseif(!$arJsonData["object_type"]){
        $arTitle[]="Продажа";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
        $arDescription[] = "Продажа";
      }else{
        $arTitle[]="Купить";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
        $arDescription[] = "Продажа";
      }
      /** Тип объекта **/
      if($arJsonData["object_type"]=='uchastok'){
        if($arTitle[0]=="Аренда"){
          $arTitle[]='земельного '.$targetsRod;
        }else{
          $arTitle[]='земельный '.mb_strtolower ($target1);
        }
        $arKeywords1[]='земельный '.mb_strtolower ($target1);
        $arKeywords2[]='земельный '.mb_strtolower ($target1);
        $arDescription[] = 'земельного '.$targetsRod;
      }elseif($arJsonData["object_type"]=='dom'){
        $arTitle[]='элитный  '.mb_strtolower ($target1)." или  коттедж";
        $arKeywords1[]='элитный  '.mb_strtolower ($target1);
        $arKeywords2[]='элитный  '.mb_strtolower ($target1);
        $arDescription[] = 'элитного '.$targetsRod;
      }elseif($arJsonData["object_type"]=='poselok'){
        $arTitle=[];
        $arKeywords1=[];
        $arTitle[]="Все элитные посёлки";
        $arKeywords1[]="Элитные посёлки";
        $arDescription[] = "Элитные посёлки";
      }elseif($arJsonData["object_type"]){
        if($arTitle[0]=="Аренда"){
          $arTitle[]=$targetsRod;
        }else{
          $arTitle[]=mb_strtolower ($target1);
        }
        $arKeywords1[]=mb_strtolower ($target1);
        $arKeywords2[]=mb_strtolower ($target1);
        $arDescription[] = $targetsRod;
      }elseif(!$arJsonData["deal_type"] && !$arJsonData["object_type"]){
        $arTitle=[];
        $arKeywords1=[];
        $arTitle[]="Вся элитная загородная недвижимость";
        $arTitlePage[]="Элитная загородная недвижимость";
        $arKeywords1[]="Элитная загородная недвижимость";
        $arDescription[] = "Элитная загородная недвижимость";
      }else{
        $arTitle[]="элитной загородной недвижимости";
        $arKeywords1[]="элитной загородной недвижимости";
        $arDescription[] = "элитной загородной недвижимости";
      }
      /** Расположение **/
      if($arJsonData["highway"] && count($arJsonData["highway"]) == 1){
        $arTitle[]='на ' . morpher_inflect(self::getValueByTranslit($arJsonData["highway"][0]), 'predl')." шоссе";
        $arKeywords[]='на ' . morpher_inflect(self::getValueByTranslit($arJsonData["highway"][0]), 'predl')." шоссе";
        $arDescription[]='на ' . morpher_inflect(self::getValueByTranslit($arJsonData["highway"][0]), 'predl')." шоссе";
      }elseif($arJsonData["district_area"] && count($arJsonData["district_area"]) == 1) {
        $arTitle[] = 'в районе ' . self::getValueByTranslit($arJsonData["district_area"][0]);
        $arKeywords[] = 'в районе ' . self::getValueByTranslit($arJsonData["district_area"][0]);
        $arDescription[]='в районе ' . self::getValueByTranslit($arJsonData["district_area"][0]);
      }elseif(!$arJsonData["object_type"]) {
        $arTitle[] = '';
        $arKeywords[] = '';
        $arDescription[]='';
      }else{
        $arTitle[]="в Подмосковье";
        $arKeywords[]="в Подмосковье";
        $arDescription[]="в Подмосковье";
      }
      if(!$arJsonData["object_type"] && !$arJsonData["deal_type"]){
        $arTitlePage=[];
        $arTitlePage[]='Элитная загородная недвижимость';
      }
    }

    if ($arJsonData["department_id"] == FOREIGN_DEPARTAMENT) {

      if($arJsonData["deal_type"]== "arenda"){
        $arTitle[]="Аренда";
        $arTitlePage[]="Аренда";
        $arKeywords1[]="Аренда";
        $arKeywords2[]="снять";
      }else{
        $arTitle[]="Продажа";
        $arTitlePage[]="Продажа";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
        $arDescription[] = "Продажа";
      }
      /** Тип объекта **/
      if($arJsonData["object_type"]){   
        $arTitle[]=$targetsRod;             
        $arTitlePage[]=$targetsRod;
        $arKeywords1[]=$targetVin;
        $arKeywords2[]=$targetsRod;
      }elseif(!$arJsonData["deal_type"] && !$arJsonData["object_type"]){
        $arTitle=[];
        $arTitlePage=[];
        $arKeywords1=[];
        $arTitle[]="Вся элитная зарубежная недвижимость";
        $arTitlePage[]="Элитная зарубежная недвижимость";
        $arKeywords1[]="Элитная зарубежная недвижимость";
        $arDescription[] = "Элитная зарубежная недвижимость";
      }else{
        $arTitle[]="элитной недвижимости";
        $arTitlePage[]="элитной недвижимости";
        $arKeywords1[]="элитной недвижимости";
        $arKeywords2[]="элитную недвижимость";
      }      
      /** Расположение **/
      if(count($arJsonData["city"]) == 1 && self::getValueByTranslit($arJsonData["city"][0]) != ''){
        $arTitle[]=morpher_inflect(self::getValueByTranslit($arJsonData["city"][0]), 'М');
        $arTitlePage[]=morpher_inflect(self::getValueByTranslit($arJsonData["city"][0]), 'М');
        $arKeywords[]=morpher_inflect(self::getValueByTranslit($arJsonData["city"][0]), 'М');
      }elseif(count($arJsonData["country"]) == 1){
        $arTitle[]=morpher_inflect(self::getValueByTranslit($arJsonData["country"][0]), 'М');
        $arTitlePage[]=morpher_inflect(self::getValueByTranslit($arJsonData["country"][0]), 'М');
        $arKeywords[]=morpher_inflect(self::getValueByTranslit($arJsonData["country"][0]), 'М');
      }elseif($arJsonData["deal_type"] || $arJsonData["object_type"]){
        $arTitle[]="зарубежом";
        $arTitlePage[]="зарубежом";
        $arKeywords[]="зарубежом";
      }
    }
    if ($arJsonData["department_id"] == COMMERC_DEPARTAMENT) {
      if($arJsonData["deal_type"]== "arenda"){
        $arTitle[]="Аренда";
        $arTitlePage[]="Аренда";
        $arKeywords1[]="Аренда";
        $arKeywords2[]="снять";
      }else{
        $arTitle[]="Продажа";
        $arTitlePage[]="Продажа";
        $arKeywords1[]="Продажа";
        $arKeywords2[]="купить";
        $arDescription[] = "Продажа";
      }
      /** Тип объекта **/
      if($arJsonData["object_type"]){   
        $arTitle[]=$targetsRod;             
        $arTitlePage[]=$targetsRod;
        $arKeywords1[]=$targetVin;
        $arKeywords2[]=$targetsRod;
      }elseif(!$arJsonData["deal_type"] && !$arJsonData["object_type"]){
        $arTitle=[];
        $arTitlePage=[];
        $arKeywords1=[];
        $arTitle[]="Вся элитная офисная недвижимость";
        $arTitlePage[]="Элитная офисная недвижимость";
        $arKeywords1[]="Элитная офисная недвижимость";
        $arDescription[] = "Элитная офисная недвижимость";
      }else{
        $arTitle[]="офисной недвижимости";
        $arTitlePage[]="офисной недвижимости";
        $arKeywords1[]="офисной недвижимости";
        $arKeywords2[]="офисную недвижимость";
      }   
    }

    $arSeoData['seo_title'] = implode(' ', $arTitle).' ('.$count.')';
    $arSeoData['seo_keywords'] = implode(' ', $arKeywords1).' '.implode(' ', $arKeywords);
    if($arJsonData["deal_type"]){
      $arSeoData['seo_keywords'] = $arSeoData['seo_keywords'].', '.implode(' ', $arKeywords2).' '.implode(' ', $arKeywords);
    }
    $arSeoData['seo_page'] = implode(' ', $arTitle);
    if($arDescription){
      $arSeoData['seo_description'] =  implode(' ', $arDescription).'. Лучшие предложения от экспертов рынка. Оставьте онлайн-заявку или свяжитесь '.$res->get('contacts_' . LANGUAGE_ID . '.phone_text');
    }
    if($arTitlePage){
      $arSeoData['seo_page'] = implode(' ', $arTitlePage);
      $arSeoData['seo_description'] =  implode(' ', $arTitlePage).'. Лучшие предложения от экспертов рынка. Оставьте онлайн-заявку или свяжитесь '.$res->get('contacts_' . LANGUAGE_ID . '.phone_text');
    }else{
      $arSeoData['seo_description'] =  implode(' ', $arTitle).'. Лучшие предложения от экспертов рынка. Оставьте онлайн-заявку или свяжитесь '.$res->get('contacts_' . LANGUAGE_ID . '.phone_text');
    }
    return $arSeoData;
  }

}
