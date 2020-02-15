<?php

namespace Idem\Realty\Core\Transportring\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class TransportringEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Transportring\TransportringTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}