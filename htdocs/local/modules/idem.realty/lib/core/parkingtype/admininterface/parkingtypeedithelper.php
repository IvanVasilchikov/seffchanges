<?php

namespace Idem\Realty\Core\Parkingtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ParkingtypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Parkingtype\ParkingtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}