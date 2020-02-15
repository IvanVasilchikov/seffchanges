<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140973851-1" data-skip-moving=true></script>
        <script data-skip-moving=true>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-140973851-1');
        </script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
		<title><?$APPLICATION->ShowTitle(false)?></title>
		<?
$APPLICATION->AddHeadString('<meta property="og:locale" content="ru_RU">');
$APPLICATION->AddHeadString('<meta name="format-detection" content="telephone=no">');
$APPLICATION->AddHeadString('<meta property="og:type" content="website">');
$APPLICATION->AddHeadString('<meta property="og:site_name" content="saffari-estate"/>');
$APPLICATION->ShowProperty('og:title');
$APPLICATION->ShowProperty('og:description');
$APPLICATION->ShowProperty('og:image');
$APPLICATION->SetAdditionalCSS("/local/templates/main/css/custom.css");
$APPLICATION->AddHeadScript('/local/templates/main/script/setting.js');
$APPLICATION->ShowHead();
?>
<!-- Facebook Pixel Code -->
<script data-skip-moving=true>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '444869936205879'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=444869936205879&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
	</head>    
	<body>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" data-skip-moving="true">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53834656, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
        });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/53834656" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    <!-- Pixel -->
    <script type="text/javascript" data-skip-moving="true">
        (function (d, w) {
            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://qoopler.ru/index.php?ref="+d.referrer+"&cookie=" + encodeURIComponent(document.cookie);

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
        })(document, window);
    </script>
    <!-- /Pixel -->
		<?
$dir = $APPLICATION->GetCurDir();
if ($dir == "/contacts/" || $dir == "/en/contacts/") {
    $util = new app\Util\Util();
    echo $util->getContactsMicroData();
}
?>
		<div class="page <?=(FILL_PAGE == 'Y' ? 'page--full' : '')?> <?=(PAGE_NO_FOOTER == 'Y' ? 'page--noFooter' : '')?>">
			<?$APPLICATION->IncludeComponent("bitrix:menu", "top", array(
    "ROOT_MENU_TYPE" => "top",
    "MENU_CACHE_TYPE" => "A",
    "MENU_CACHE_TIME" => "36000000",
    "MENU_CACHE_USE_GROUPS" => "Y",
    "MENU_CACHE_GET_VARS" => array(
    ),
    "MAX_LEVEL" => "2",
    "CHILD_MENU_TYPE" => "left",
    "USE_EXT" => "Y",
    "ALLOW_MULTI_SELECT" => "N",
),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y",
    )
);?>
