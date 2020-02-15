<?php

namespace Idem\Realty\Core\Typereal\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class TyperealEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Typereal\TyperealTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}