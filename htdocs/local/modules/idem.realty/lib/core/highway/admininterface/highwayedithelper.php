<?php

namespace Idem\Realty\Core\Highway\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class HighwayEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Highway\HighwayTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}