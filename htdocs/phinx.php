?php
define("NOT_CHECK_PERMISSIONS", true);
define("NO_AGENT_CHECK", true);
$GLOBALS["DBType"] = 'mysql';
$_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__);
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// manual saving of DB resource
global $DB,$USER;
$app = \Bitrix\Main\Application::getInstance();
$con = $app->getConnection();
$DB->db_Conn = $con->getResource();
// "authorizing" as admin
$_SESSION["SESS_AUTH"]["USER_ID"] = 1;
\Bitrix\Main\Loader::includeModule('iblock');

$config = include realpath(__DIR__ . '/bitrix/.settings.php');

$USER->Authorize(1);

return array(
    "paths" => array(
        "migrations" => realpath(__DIR__ . '/local/migrations/'),
        "seeds" => realpath(__DIR__ . '/local/seeds/'),
    ),
    "environments" => array(
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => array(
            "adapter" => "mysql",
            "host" => $config['connections']['value']['default']['host'],
            "name" => $config['connections']['value']['default']['database'],
            "user" => $config['connections']['value']['default']['login'],
            "pass" => $config['connections']['value']['default']['password']
        )
    )
);
