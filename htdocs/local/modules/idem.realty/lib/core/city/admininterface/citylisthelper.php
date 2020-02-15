<?php
namespace Idem\Realty\Core\City\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class CityListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\City\CityTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}