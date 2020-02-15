<?php

namespace Idem\Realty\Core\Objecttype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ObjecttypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Objecttype\ObjecttypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}