<?php

namespace Idem\Realty\Core\Finishtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class FinishtypeEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Finishtype\FinishtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}