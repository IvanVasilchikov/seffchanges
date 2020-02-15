<?php

namespace Idem\Realty\Core\Water\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class WaterEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Water\WaterTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}