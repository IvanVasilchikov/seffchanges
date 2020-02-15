<?php

namespace Idem\Realty\Core\Useroom\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class UseroomEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Useroom\UseroomTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}