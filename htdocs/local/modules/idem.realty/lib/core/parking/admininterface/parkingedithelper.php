<?php

namespace Idem\Realty\Core\Parking\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ParkingEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Parking\ParkingTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}