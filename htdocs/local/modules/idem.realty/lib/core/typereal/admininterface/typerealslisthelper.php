<?php
namespace Idem\Realty\Core\Typereal\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class TyperealListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Typereal\TyperealTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}