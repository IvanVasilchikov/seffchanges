<?php
namespace Idem\Realty\Core\Locality\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class LocalityListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Locality\LocalityTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}