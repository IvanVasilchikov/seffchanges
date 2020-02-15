<?php

use Phinx\Migration\AbstractMigration;
if (!$_SERVER["DOCUMENT_ROOT"]){
    $_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__).'/../..';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/idem.realty/lib/utilities/migration.php");
use Idem\Realty\Utilities\Migration;


class TableLocalityMetro extends AbstractMigration
{
    public function up()
    {
        $connection = \Bitrix\Main\Application::getConnection();
        $result = $connection->queryExecute("CREATE TABLE
        `i_metro_district` (
            `metro` TEXT,
            `district` TEXT
        )");
        $result = $connection->queryExecute("CREATE TABLE
        `i_locality_district` (
            `locality` TEXT,
            `district` TEXT
        )");
    }

    public function down()
    {
        $connection = \Bitrix\Main\Application::getConnection();
        $result = $connection->queryExecute("DROP TABLE `i_metro_district`");  
        $result = $connection->queryExecute("DROP TABLE `i_locality_district`");          
    }
}
