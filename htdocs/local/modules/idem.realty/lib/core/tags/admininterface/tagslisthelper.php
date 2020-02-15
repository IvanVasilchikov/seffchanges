<?php
namespace Idem\Realty\Core\Tags\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class TagsListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Tags\TagsTable';
    
    public static function getModule(){
        return 'idem.realty';
    }
}