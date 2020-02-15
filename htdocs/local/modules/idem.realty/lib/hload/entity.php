<?php
namespace Idem\Realty\Hload;

use Bitrix\Main\Entity;

class EntityTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_hlblock_entity';
    }
    
    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
            )),
            new Entity\TextField('NAME'),
            new Entity\TextField('TABLE_NAME'),
        );
    }
}