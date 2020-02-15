<?php
use mikehaertl\wkhtmlto\Pdf;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// You can pass a filename, a HTML string, an URL or an options array to the constructor
if ($_REQUEST['html'] == 'Y') {
    $APPLICATION->SetPageProperty('front_page','pdf');
    $APPLICATION->SetPageProperty('noJs',true);

    $APPLICATION->IncludeComponent(
        "custom:detail.pdf",
        "",
        array(
            'ID'=>$arResult["VARIABLES"]["CODE"],
            'TYPE'=>$arResult["VARIABLES"]["TYPE"]
        )
    );
} else {
    global $APPLICATION;
    $APPLICATION->RestartBuffer();
    $pdf = new Pdf('https://admin:idem@'.SITE_SERVER_NAME.$APPLICATION->GetCurPageParam('html=Y'));
    if (!$pdf->send()) {
        $error = $pdf->getError();
        dump($error);
    }
    die();
}
?>
