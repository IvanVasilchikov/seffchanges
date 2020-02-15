<?php

use Bitrix\Main\Loader;

$GLOBALS["JsonInit"] = [];

function setJsonInit($index, $data)
{
	$keys = explode('/', $index);
	$elementsInit = &$GLOBALS["JsonInit"];
	foreach ($keys as $key) {
		if (!$elementsInit[$key]) {
			$elementsInit[$key] = [];
		}
		$elementsInit = &$elementsInit[$key];
	}
	$elementsInit = $data;
}

function getJsonInit()
{
	$jsonString = CUtil::PhpToJSObject($GLOBALS["JsonInit"], false, false, true);
	return $jsonString;
}

function showJsonInit()
{
	global $APPLICATION;
	if (isset($GLOBALS["JsonInit"])) {
		$APPLICATION->AddHeadString('<script>window.INIT = ' . getJsonInit() . ';</script>');
	}
}

function compareByName($v1, $v2)
{
	return strcmp($v1["NAME"], $v2["NAME"]);
}
if (!function_exists('dump')) {
	function dump($var, $vardump = false, $return = false)
	{
		static $dumpCnt;

		if (is_null($dumpCnt)) {
			$dumpCnt = 0;
		}
		ob_start();

		echo '<b>DUMP #' . $dumpCnt . ':</b> ';
		echo '<p>';
		echo '<pre>';
		if ($vardump) {
			var_dump($var);
		} else {
			print_r($var);
		}
		echo '</pre>';
		echo '</p>';

		$cnt = ob_get_contents();
		ob_end_clean();
		$dumpCnt++;
		if ($return) {
			return $cnt;
		} else {
			echo $cnt;
		}
	}
}
function getIBlockIdByCode($code)
{
	$id = 0;
	$cache_dir = "/get_iblock_code";
	$arParams = ['NAME' => $cache_dir, 'CACHE_TIME' => 36000000, 'code' => $code];
	$cache = Bitrix\Main\Data\Cache::createInstance();
	$cache_id = md5(serialize($arParams));
	if ($cache->InitCache($arParams['CACHE_TIME'], $cache_id, $cache_dir)) {
		$id = $cache->getVars();
	} elseif (CModule::IncludeModule("iblock") && $cache->startDataCache()) {
		$strSql = "select ID,CODE from b_iblock WHERE CODE LIKE '{$code}';";
		$connection = \Bitrix\Main\Application::getConnection();
		$res =  $connection->query($strSql)->fetch();
		if ($res['ID'])
			$id = $res['ID'];
		else
			$id = 0;
		$cache->endDataCache($id);
	}
	return $id;
}

function mb_ucfirst($string, $enc = 'UTF-8')
{
	return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
		mb_substr($string, 1, mb_strlen($string, $enc), $enc);
}

function show404()
{
	Loader::includeModule('iblock');
	\Bitrix\Iblock\Component\Tools::process404(
		"Такой страницы не существует",
		true,
		true,
		true,
		""
	);
}
/**
 * удалить директорию со всеми вложенными файлами
 * @param $path
 */

function RDir( $path ) {
	// если путь существует и это папка
	if ( file_exists( $path ) AND is_dir( $path ) ) {
		// открываем папку
		$dir = opendir($path);
		while ( false !== ( $element = readdir( $dir ) ) ) {
			// удаляем только содержимое папки
			if ( $element != '.' AND $element != '..' )  {
				$tmp = $path . '/' . $element;
				chmod( $tmp, 0777 );
				// если элемент является папкой, то
				// удаляем его используя нашу функцию RDir
				if ( is_dir( $tmp ) ) {
					RDir( $tmp );
					// если элемент является файлом, то удаляем файл
				} else {
					unlink( $tmp );
				}
			}
		}
		// закрываем папку
		closedir($dir);
		// удаляем саму папку
		if ( file_exists( $path ) ) {
			rmdir( $path );
		}
	}
}