<?php

namespace Idem\Realty\Core\Country\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class CountryEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Country\CountryTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}