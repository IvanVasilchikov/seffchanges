<?php

namespace Idem\Realty\Core\Flattype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class FlattypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Flattype\FlattypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}