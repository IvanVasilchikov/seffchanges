<?php
namespace Idem\Realty\Core\Finishyear\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class FinishyearListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Finishyear\FinishyearTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}