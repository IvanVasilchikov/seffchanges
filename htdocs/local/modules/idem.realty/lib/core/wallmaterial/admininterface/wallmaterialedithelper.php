<?php

namespace Idem\Realty\Core\Wallmaterial\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class WallmaterialEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Wallmaterial\WallmaterialTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}