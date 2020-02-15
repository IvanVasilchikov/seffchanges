<?php

namespace Idem;

class CIdemStatic
{
    private static $_instance = null;
    public $data;

    private function __construct($cache,$lang) {
        $this->getData($cache,$lang);
    }
    protected function __clone() {}

    static public function getInstance($cache = true,$lang = "ru") {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self($cache,$lang);
        }
        return self::$_instance;
    }

    private function getData($isCache,$lang)
    {
        if($isCache){
            $сache = \Bitrix\Main\Data\Cache::createInstance();

            if ($сache->initCache(7200, 'idem.static.content', '/idem/static_content/'))
            {
                $this->data = $сache->getVars();
            }
            elseif ($сache->startDataCache())
            {
                $this->data = $this->read($lang);
                $сache->endDataCache($this->data);
            }
        }else{
            $this->data = $this->read($lang);
        }
    }

    private function read($lang)
    {
        $fileContent = $_SERVER['DOCUMENT_ROOT'].'/upload/static_content/content.json';
        $fileLang = $_SERVER['DOCUMENT_ROOT'].'/upload/static_content/lang_'.$lang.'.json';

        $data['content'] = json_decode($this->readFile($fileContent),true);
        if(is_file($fileLang)){
            $data['lang'] = json_decode($this->readFile($fileLang),true);
        }else{
            $data['lang'] = [];
        }


        return $data;
    }

    private function readFile($file)
    {
        $data = file_get_contents($file);
        return $data;
    }

    public function get($path)
    {
        $data = $this->data['content'];
        foreach (explode('.', $path) as $segment) {
            if (isset($data[$segment])) {
                 if(is_array($data[$segment]))
                    unset($data[$segment][0]);
                $data = $data[$segment];
            }
        }

        return $data;
    }
}