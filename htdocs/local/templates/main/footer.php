<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $USER, $GLOBALS;
$res = \Idem\CIdemStatic::getInstance();
?>
		</div>
		
		<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
			"ROOT_MENU_TYPE" => "bottom",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(
			),
			"MAX_LEVEL" => "1",
			"CHILD_MENU_TYPE" => "left",
			"USE_EXT" => "Y",
			"ALLOW_MULTI_SELECT" => "N"
		),
			false,
			array(
				"ACTIVE_COMPONENT" => "Y"
			)
		);?>
		<?
		$APPLICATION->IncludeComponent("custom:form.result.new", "", Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CHAIN_ITEM_LINK" => "",
			"CHAIN_ITEM_TEXT" => "",
			"EDIT_URL" => "",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"LIST_URL" => "",
			"SEF_MODE" => "N",
			"SUCCESS_URL" => "",
			"USE_EXTENDED_ERRORS" => "N",
			"VARIABLE_ALIASES" => array(
				"RESULT_ID" => "RESULT_ID",
				"WEB_FORM_ID" => "WEB_FORM_ID",
			),
			"WEB_FORM_ID" => "1",
            "LIST" => true,
            "POPUP_FORM" => true,
		),
			false
		);
		?>
		<?
		$GLOBALS["JsonInit"]['popups']['response'] = [
            "error" => ["title" => $res->get('site_'.LANGUAGE_ID.'.error')],
            "success" => [
                "title" => $res->get('site_'.LANGUAGE_ID.'.thank'),
                "html" => "<p>".$res->get('site_'.LANGUAGE_ID.'.success')."</p>"
            ]
		];
		?>
        <?setJsonInit("popups/form/writeUs_common",json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].'/local/templates/main/include/write.json',FILE_USE_INCLUDE_PATH), true));?>
        <?//setJsonInit("popups/response",json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].'/local/templates/main/include/response.json',FILE_USE_INCLUDE_PATH), true));?>
        <?setJsonInit("popups/form/callback",json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].'/local/templates/main/include/callback.json',FILE_USE_INCLUDE_PATH), true));?>
		<?showJsonInit();?>
		<div class="popup"><!----></div>
		<div class="cookies">
			<div class="cookies__text"><?=$res->get('site_'.LANGUAGE_ID.'.text')?> <a class="cookies__link" target="_blanc" href="<?=$res->get('site_'.LANGUAGE_ID.'.url')?>"><?=$res->get('site_'.LANGUAGE_ID.'.link')?></a></div>
			<div class="cookies__wrap">
				<svg class="cookies__logo-icon">
					<use xlink:href="/assets/sprite.svg#logo"></use>
				</svg>
				<button class="btn btn--white cookies__button" @click="$emit('click')" :disabled="disabled"><span class="btn__text"><?=$res->get('site_'.LANGUAGE_ID.'.button')?></span></button>
			</div>
		</div>
	</body>
</html>
