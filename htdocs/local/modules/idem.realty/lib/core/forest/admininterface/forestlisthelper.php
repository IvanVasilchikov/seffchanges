<?php
namespace Idem\Realty\Core\Forest\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ForestListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Forest\ForestTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}