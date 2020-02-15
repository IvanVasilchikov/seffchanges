<?php

namespace Idem\Realty\Core\Infrastructure\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class InfrastructureEditHelper extends AdminEditHelper
{
    protected static $model = 'Idem\Realty\Core\Infrastructure\InfrastructureTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}