<?php

namespace Idem\Realty\Core\Views\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ViewsEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Views\ViewsTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}