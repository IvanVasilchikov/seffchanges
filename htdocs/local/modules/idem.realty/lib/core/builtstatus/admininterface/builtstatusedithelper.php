<?php

namespace Idem\Realty\Core\Builtstatus\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class BuiltstatusEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Builtstatus\BuiltstatusTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}