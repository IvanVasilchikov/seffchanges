<?php
namespace Idem\Realty\Core\Commerctype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class CommerctypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Commerctype\CommerctypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}