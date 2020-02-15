<?php

namespace Idem\Realty\Core\District\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class DistrictEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\District\DistrictTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}