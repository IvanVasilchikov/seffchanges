<?php

namespace Idem\Realty\Core\Valute\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ValuteEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Valute\ValuteTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}