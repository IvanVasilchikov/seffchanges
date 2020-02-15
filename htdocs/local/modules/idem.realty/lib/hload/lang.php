<?php
namespace Idem\Realty\Hload;

use Bitrix\Main\Entity;

class LangTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_hlblock_entity_lang';
    }
    
    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => false,
            ]),
            new Entity\TextField('NAME'),
            new Entity\TextField('LID'),
        );
    }
}