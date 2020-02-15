<?php

namespace Idem\Realty\Core\Dealtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class DealtypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Dealtype\DealtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}