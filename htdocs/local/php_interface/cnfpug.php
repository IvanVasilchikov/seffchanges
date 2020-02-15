<?

use JsPhpize\JsPhpizePhug;

$_SERVER['PUG_SOURCE'] = $_SERVER['DOCUMENT_ROOT'] . '/../source';

global $arCustomTemplateEngines;
$arCustomTemplateEngines = array(
	"pug" => array(
		"templateExt" => array("pug"),
		"function" => "includePugTemplate",
		"sort" => 50
	),
);

mkdir($_SERVER['DOCUMENT_ROOT'] . '/bitrix/cache/pug');
Phug::addExtension(JsPhpizePhug::class);
Phug::setOptions([
	'basedir' => $_SERVER['PUG_SOURCE'],
	'cache_dir' =>$_SERVER['DOCUMENT_ROOT'].'/bitrix/cache/pug',
]);

function includePugTemplate($templateFile, $arResult)
{
	$arResult['loadAssets'] = function ($file, $isView = false) {
		if (strpos($file, '.svg') !== false) {
			if ($isView) {
				return '/assets/sprite.svg#view-' . basename($file, '.svg');
			} else {
				return '/assets/sprite.svg#' . basename($file, '.svg');
			}
		} else {
			return '/assets/images/' . basename($file);
		}
	};
	$arResult['util']['concat'] = function($ar, $ar1) {
		return array_merge($ar,$ar1);
	};
	$arResult['util']['pagination'] = function ($page, $pages) {
	$result = [];
	if ($pages < 5) {
		for ($i = 1; $i <= $pages; $i += 1) {
		$result[] = $i;
		}
	} else if ($page < 5) {
		for ($i = 1; $i <= 5; $i += 1) {
		$result[] = $i;
		}
		$result[] = '...';
		$result[] = $pages;
	} else if ($page > $pages - 4) {
		$result = [1, '...'];
		for ($i = $pages - 4; $i <= $pages; $i += 1) {
		$result[] = $i;
		}
	} else if ($page >= 5 && $page <= $pages - 4) {
		$result = [1, '...'];
		for ($i = $page - 1; $i <= $page + 1; $i += 1) {
		$result[] = $i;
		}
		$result[] = '...';
		$result[] = $pages;
	}
	return $result;
	};
	Phug::displayFile($_SERVER['DOCUMENT_ROOT'] . $templateFile, $arResult);
}
