<?php
namespace Idem\Realty\Core\Builttype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class BuilttypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Builttype\BuilttypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}