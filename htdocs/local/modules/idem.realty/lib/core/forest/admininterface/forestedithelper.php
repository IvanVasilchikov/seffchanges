<?php

namespace Idem\Realty\Core\Forest\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ForestEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Forest\ForestTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}