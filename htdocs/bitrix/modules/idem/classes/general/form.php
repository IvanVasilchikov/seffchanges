<?php

namespace Idem;

class CIdemForm
{
    private static $lang;
    private static $tpls;

    public static function build($data)
    {
        self::$tpls = dirname(dirname(dirname(__FILE__))).'/tpls';
        self::$lang = $data['lang'];
        $html = self::getReadData($data['content']);
        return $html;
    }

    public static function loadLang($data)
    {
        self::$lang = $data;
    }

    public static function getReadData($array,$parent = null)
    {
        $html = '';

        foreach ($array as $key => $item){
            $name = $key;
            $title = self::translate($key);
            if(is_array($item) && !isset($item[0])){
                $p = ($parent) ? $parent."[$name]" : $name;
                $content = self::getReadData($item,$p);
                $title = self::translate($name);
                $html .= self::view('object',compact('name','title','content'));
            }elseif(is_array($item) && isset($item[0])){
                if(!is_array($item[0])){
                    $content = '';
                    $p = ($parent) ? $parent."[$key]": "{$key}";
                    $content .= self::getReadData($item,$p);
                    $html .= self::view('array',compact('name','title','content'));
                }else{
                    $content = '';
                    //$default = implode(',',array_keys($item[0]));
                    foreach ($item as $k => $f){
                        $p = ($parent) ? $parent."[$key][$k]": "{$key}[$k]";
                        $content .=  self::view('child-object-item',[
                            'data' => $f,
                            'position' => $k,
                            'html' => self::getReadData($f,$p)
                        ]);

                    }
                    $pname = ($parent) ? $parent."[$name]" : $name;
                    $html .= self::view('child-object',compact('name','title','content','default','pname'));
                }
            }else{
                $html .= self::getPrimitives($key,$item,$parent);
            }
        }

        return $html;
    }

    public static function getPrimitives($key,$value,$parent = null)
    {
        preg_match('#(html|file|str)#',$key,$matches);

        //$name = (isset($matches[0])) ? str_replace('_'.$matches[0],'',$key) : $key;
        $type = (isset($matches[0])) ? $matches[0] : '';

        $html = self::getField($key,$type,$value,$parent);

        return $html;
    }

    private static function getField($name,$type,$val,$parent)
    {

        $title = self::translate($name);
        $name = ($parent == null) ? $name : $parent.'['.$name.']';
        $value = $val;
        if($type == 'html'){
            $tpl = 'textarea';
        }elseif($type == 'file'){
            $tpl = 'file';
        }else{
            $tpl = 'input';
        }

        $view = self::view($tpl,compact('title','name','value'));
        return $view;
    }

    private static function translate($val)
    {
        return (isset(self::$lang[$val])) ? self::$lang[$val] : $val;
    }

    private static function view($file,$data)
    {
        if(self::$tpls == '') self::$tpls = dirname(dirname(dirname(__FILE__))).'/tpls';
        extract($data);
        ob_start();
        include self::$tpls.'/'.$file.'.php';
        $res = ob_get_contents();
        ob_end_clean();

        return $res;
    }
}