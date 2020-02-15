<?php
namespace Idem\Realty\Core\Objecttype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ObjecttypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Objecttype\ObjecttypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}