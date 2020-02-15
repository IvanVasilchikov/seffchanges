<?php
namespace Idem\Realty\Core\Zhkclass\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ZhkclassListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Zhkclass\ZhkclassTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}