<?php
namespace Idem\Realty\Utilities;


class Currency
{
    const url = 'http://cbrates.rbc.ru/tsv/';
    const file = '.tsv';
    private $date = 0;
    public function __construct($date = null){
        if ($date == null){
            $date = time();
        }
        $this -> date = $date;
    }
    public function curs($currency_code){
        $url = self::url;
        $curs = 0;
        try{
            if (!is_numeric($currency_code)){
                throw new \Exception('Передан неверный код валюты');
            }
            $url .= $currency_code . '/';
            if ($this -> date <= 0){
                throw new \Exception('Передана неверная дата');
            }
            $url .= date('Y/m/d', $this -> date);
            $url .= self::file;

            $page = file_get_contents($url);
            $curs = $this -> parse($page);
        }
        catch (\Exception $e) {
            echo 'Не удалось получить курс валюты. ',  $e -> getMessage();
        }
        return $curs;
    }
    private function parse($file){
        if (empty($file)){
            throw new \Exception('Возможно указан неверный код валюты, также возможно на указанную дату еще не установлен курс валюты, либо сервер "cbrates.rbc.ru" недоступен.');
        }
        $curs = explode("\t", $file);
        if (!empty($curs[1])){
            return $curs[1];
        }
        else{
            throw new \Exception('Сервер не выдал результатов по данной валюте на указнную дату');
        }
    }
    
    
    public function getCurrency($valute){
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $arCache = ['valute'=> $valute,'date'=>date('d m Y')];
        $currency = 1;
        $cache_id = md5(serialize($arCache));
        if ($cache->initCache(3600*24, $cache_id, 'currency'))
        {
            $currency = $cache->getVars();
        }
        elseif ($cache->startDataCache())
        {
            switch ($valute){
                case 'usd':
                    $currency = $this->curs(840); //840-dollar
                    break;
                case 'eur':
                    $currency = $this->curs(978); //978-euro
                    break;
                case 'funt':
                    $currency = $this->curs(826); //826-funt
                    break;
                case 'btc':
                    $url = 'https://blockchain.info/ticker';
                    $res = file_get_contents($url);
                    $arCurrency = json_decode($res, 1);
                    $currency = $arCurrency['RUB']['last'];
                    break;
                default:
                    $currency = 1;
                    break;
            }
            $cache->endDataCache($currency);
        }
        return $currency;
    }
    
    public function getPriceByCurrency($price, $currentValute, $newValute){
        if($currentValute != 'rub')
            $price = $this->getRublePriceByCurrency($price, $currentValute);
        $currency = $this->getCurrency($newValute);
        $price = $price/$currency;
        
        return $price;
    }
    
    public function getRublePriceByCurrency($price, $valute){
        $currency = $this->getCurrency($valute);
        $price = $price*$currency;
        
        return $price;
    }
    
    public static function getValuteCode($name){
        switch ($name){
            case '$':
                $valute = 'usd';
            break;
            case 'доллар':
                $valute = 'usd';
            break;
            case '€':
                $valute = 'eur';
            break;
            case 'евро':
                $valute = 'eur';
            break;
            case 'фунт':
                $valute = 'funt';
            break;
            default:
                $valute = 'rub';
            break;
        }
        
        return $valute;
    }
}