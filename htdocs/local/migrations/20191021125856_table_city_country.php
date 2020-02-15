<?php
use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;
class TableCityCountry extends AbstractMigration
{
    public function up()
    {
        $connection = \Bitrix\Main\Application::getConnection();
        $result = $connection->queryExecute("CREATE TABLE
        `i_city_country` (
            `city` TEXT,
            `country` TEXT
        )");        
    }

    public function down()
    {
        $connection = \Bitrix\Main\Application::getConnection();        
        $result = $connection->queryExecute("DROP TABLE `i_city_country`");          
    }
}
