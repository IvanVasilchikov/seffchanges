<?php
namespace Idem\Realty\Core\Parking\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ParkingListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Parking\ParkingTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}