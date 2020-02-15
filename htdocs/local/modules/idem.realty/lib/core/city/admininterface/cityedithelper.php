<?php

namespace Idem\Realty\Core\City\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class CityEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\City\CityTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}