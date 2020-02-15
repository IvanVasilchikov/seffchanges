<?php
namespace Idem\Realty\Core\Wallmaterial\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class WallmaterialListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Wallmaterial\WallmaterialTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}