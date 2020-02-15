<?php
namespace Idem\Realty\Core\Countrytype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class CountrytypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Countrytype\CountrytypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}