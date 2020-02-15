<?php
namespace Idem\Realty\Core\Finishtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class FinishtypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Finishtype\FinishtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}