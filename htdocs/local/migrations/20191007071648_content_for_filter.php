<?php
if (!$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__) . '/../..';
}
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/modules/idem.realty/lib/utilities/migration.php";
use Idem\Realty\Utilities\Migration;
use Phinx\Migration\AbstractMigration;

class ContentForFilter extends AbstractMigration
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
        Migration::createContentStatic('{"filter_finish": "Готовность","filter_views": "Вид"}', "main_ru");
    }
    private function removeContent()
    {
        
    }
}
