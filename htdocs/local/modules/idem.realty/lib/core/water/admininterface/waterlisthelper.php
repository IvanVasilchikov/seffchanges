<?php
namespace Idem\Realty\Core\Water\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class WaterListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Water\WaterTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}