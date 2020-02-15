<?php

namespace Idem\Realty\Core\Builttype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class BuilttypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Builttype\BuilttypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}