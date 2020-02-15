<?php
namespace Idem\Realty\Core\Valute\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ValuteListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Valute\ValuteTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}