<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="format-detection" content="telephone=no">
	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<title><?$APPLICATION->ShowTitle(false)?></title>
	<?
$APPLICATION->ShowHead();
?>
<script>
var pdfInfo = {};
      function getPdfInfo() {
        document.getElementById('content_height').style.height = (Math.ceil(document.getElementById('content_height').clientHeight / 1935)*1935)+'px';
      }
</script>
<style>
.detail-pdf-characteristics .detail-pdf-characteristics__info-col, .detail-pdf-characteristics__info-row {
	width: 620px!important;
}
.detail-pdf-characteristics__info-text {
	white-space:nowrap;
}
.detail-pdf-characteristics .detail-pdf-characteristics__info-title {
	width: 250px!important;
	white-space:nowrap;
}
</style>
</head>

<body style="position:relative;" onload="getPdfInfo()">
