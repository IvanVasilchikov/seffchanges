<?php
namespace Idem\Realty\Core\Parkingtype\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ParkingtypeListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Parkingtype\ParkingtypeTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}