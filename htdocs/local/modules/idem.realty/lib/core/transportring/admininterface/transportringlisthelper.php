<?php
namespace Idem\Realty\Core\Transportring\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class TransportringListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Transportring\TransportringTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}