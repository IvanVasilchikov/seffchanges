<?php
namespace Idem\Realty\Core\Infrastructure\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class InfrastructureListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Infrastructure\InfrastructureTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}