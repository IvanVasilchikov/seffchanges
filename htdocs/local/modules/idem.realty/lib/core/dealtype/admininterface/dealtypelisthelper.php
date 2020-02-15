<?php
namespace Idem\Realty\Core\Dealtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class DealtypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Dealtype\DealtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}