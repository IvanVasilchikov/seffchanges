<?php
namespace Idem\Realty\Core\Bathroom\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class BathroomListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Bathroom\BathroomTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}