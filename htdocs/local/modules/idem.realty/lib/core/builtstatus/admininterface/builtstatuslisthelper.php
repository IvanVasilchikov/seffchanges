<?php
namespace Idem\Realty\Core\Builtstatus\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class BuiltstatusListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Builtstatus\BuiltstatusTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}