<?php

namespace Idem\Realty\Core\Zhkclass\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ZhkclassEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Zhkclass\ZhkclassTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}