<?php
namespace Idem\Realty\Core\District\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class DistrictListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\District\DistrictTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}