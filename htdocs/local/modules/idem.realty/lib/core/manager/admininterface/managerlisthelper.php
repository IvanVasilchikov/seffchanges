<?php
namespace Idem\Realty\Core\Manager\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ManagerListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Manager\ManagerTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}