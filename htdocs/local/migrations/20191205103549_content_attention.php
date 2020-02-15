<?php

if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php";
use Idem\Realty\Utilities\Migration;
use Phinx\Migration\AbstractMigration;

class ContentAttention extends AbstractMigration
{

    public function up()
    {
        $this->addContent();
    }

    public function down()
    {
        $this->removeContent();
    }
    private function addContent()
    {
        Migration::createContentStatic('{"text": "Мы используем куки для наилучшего представления нашего сайта. Продолжая сессию, вы соглашаетесь с политиками по обработке","url":"/privacy-policy/","link": "персональных данных","button": "Принять"}', "site_ru");
    }
    private function removeContent()
    {
        
    }
}