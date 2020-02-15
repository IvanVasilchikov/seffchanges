<?php require_once __DIR__.'/../vendor/autoload.php';
use GO\Scheduler;
ini_set('memory_limit','2048M');
// Create a new scheduler
$scheduler = new Scheduler();
$scheduler->php(__DIR__.'/import/delete_update_intrum.php')->daily(01,00);
$scheduler->php(__DIR__.'/import/intrum.php')->daily(01,20);
$scheduler->php(__DIR__.'/import/update_jk.php')->daily(01,30);
$scheduler->php(__DIR__.'/elastic/objects_indexer.php')->daily(01,40);
$scheduler->run();
