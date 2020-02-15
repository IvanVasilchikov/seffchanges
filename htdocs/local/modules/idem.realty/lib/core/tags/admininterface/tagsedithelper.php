<?php

namespace Idem\Realty\Core\Tags\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class TagsEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Tags\TagsTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}