<?php

namespace Idem\Realty\Core\Countrytype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class CountrytypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Countrytype\CountrytypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}