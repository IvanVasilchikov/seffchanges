<?php

namespace Idem\Realty\Core\Realtyclass\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class RealtyclassEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Realtyclass\RealtyclassTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}