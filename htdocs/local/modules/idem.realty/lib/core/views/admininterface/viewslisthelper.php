<?php
namespace Idem\Realty\Core\Views\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ViewsListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Views\ViewsTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}