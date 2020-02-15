<?php

namespace Idem\Realty\Core\Commerctype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class CommerctypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Commerctype\CommerctypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}