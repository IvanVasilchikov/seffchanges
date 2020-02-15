<?php
namespace Idem\Realty\Core\Foreigntype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ForeigntypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Foreigntype\ForeigntypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}