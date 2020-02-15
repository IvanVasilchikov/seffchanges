<?php

namespace Idem\Realty\Core\Foreigntype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ForeigntypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Foreigntype\ForeigntypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}