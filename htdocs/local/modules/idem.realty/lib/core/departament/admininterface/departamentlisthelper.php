<?php
namespace Idem\Realty\Core\Departament\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class DepartamentListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Departament\DepartamentTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}