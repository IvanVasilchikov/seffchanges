<?php
namespace Idem\Realty\Core\Highway\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class HighwayListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Highway\HighwayTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}