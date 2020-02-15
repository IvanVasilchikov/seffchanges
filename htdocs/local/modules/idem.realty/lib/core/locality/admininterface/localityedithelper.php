<?php

namespace Idem\Realty\Core\Locality\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class LocalityEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Locality\LocalityTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}