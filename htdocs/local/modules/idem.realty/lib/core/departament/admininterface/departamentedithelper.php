<?php

namespace Idem\Realty\Core\Departament\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class DepartamentEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Departament\DepartamentTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}