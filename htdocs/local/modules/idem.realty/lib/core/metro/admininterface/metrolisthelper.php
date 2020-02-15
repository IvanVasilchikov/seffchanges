<?php
namespace Idem\Realty\Core\Metro\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class MetroListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Metro\MetroTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}