<?php

namespace Idem\Realty\Core\Bathroom\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class BathroomEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Bathroom\BathroomTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}