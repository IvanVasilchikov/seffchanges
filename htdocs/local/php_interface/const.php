<?
define('LIVE_REALTY_URL', 'gorod');
define('NEW_REALTY_URL', 'novostroyka');
define('COMMERC_REALTY_URL', 'commerce');
define('COUNTRY_REALTY_URL', 'zagorod');
define('FOREIGN_REALTY_URL', 'foreign-real-estate');
define('NOVOSTROIKA_CODE', 'novostroyka');
define('EXCLUSIVE', 'eksklyuziv');
define('LOCALITY_SUB_DIR', 'rayony');
define('FLAT_CODE', 'kvartira');

define('LIVE_DEPARTAMENT', 1);
define('COMMERC_DEPARTAMENT', 2);
define('COUNTRY_DEPARTAMENT', 3);
define('FOREIGN_DEPARTAMENT', 5);

define('COMMERC_OFFICE', 'ofis');
define('COMMERC_SKLAD', 'sklad');
define('COMMERC_TORG', 'torgovaya');

define('CURRENCY_CATALOG', 'rub');
define('ORDER_CATALOG_JK', 'top9jk|asc,sort_date_update|desc');
define('ORDER_CATALOG', 'top9|asc,sort_date_update|desc');
define('PAGE_CATALOG', '1');
define('RANGE_CATALOG', 'general');



if (!defined('ELASTIC_INDEX')) {
    define('ELASTIC_INDEX', 'realty_objects');
}
