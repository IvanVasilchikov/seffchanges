<?php
namespace Idem\Realty\Core\Useroom\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class UseroomListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Useroom\UseroomTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}