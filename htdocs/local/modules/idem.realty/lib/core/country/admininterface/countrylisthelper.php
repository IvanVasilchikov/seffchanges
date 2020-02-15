<?php
namespace Idem\Realty\Core\Country\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class CountryListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Country\CountryTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}