<?php
namespace Idem\Realty\Core\Realtyclass\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class RealtyclassListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Realtyclass\RealtyclassTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}