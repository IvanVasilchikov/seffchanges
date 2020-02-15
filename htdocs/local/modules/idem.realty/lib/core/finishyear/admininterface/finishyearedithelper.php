<?php

namespace Idem\Realty\Core\Finishyear\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class FinishyearEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Finishyear\FinishyearTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}