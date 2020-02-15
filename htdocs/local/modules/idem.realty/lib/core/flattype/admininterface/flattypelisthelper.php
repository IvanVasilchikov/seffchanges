<?php
namespace Idem\Realty\Core\Flattype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class FlattypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Flattype\FlattypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}