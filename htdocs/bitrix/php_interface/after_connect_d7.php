<?
$connection = \Bitrix\Main\Application::getConnection();
$connection->queryExecute("SET NAMES 'utf8'");
$connection->queryExecute('SET collation_connection = "utf8_general_ci"');
$connection->queryExecute("SET sql_mode=''");
$connection = Bitrix\Main\Application::getConnection();
$connection->queryExecute("SET LOCAL time_zone='" . date('P') . "'");
