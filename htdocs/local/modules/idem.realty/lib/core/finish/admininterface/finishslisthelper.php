<?php
namespace Idem\Realty\Core\Finish\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class FinishListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Finish\FinishTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}