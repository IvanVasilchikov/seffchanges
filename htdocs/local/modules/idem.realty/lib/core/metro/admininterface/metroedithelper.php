<?php

namespace Idem\Realty\Core\Metro\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class MetroEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Metro\MetroTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}