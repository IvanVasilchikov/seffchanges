<?php

namespace Idem\Realty\Core\Manager\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ManagerEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Manager\ManagerTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}