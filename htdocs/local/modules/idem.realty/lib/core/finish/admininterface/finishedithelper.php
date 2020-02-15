<?php

namespace Idem\Realty\Core\Finish\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class FinishEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Finish\FinishTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}