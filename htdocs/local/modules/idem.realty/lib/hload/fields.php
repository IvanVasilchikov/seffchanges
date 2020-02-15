<?php
namespace Idem\Realty\Hload;

use Bitrix\Main\Entity;

class FieldsTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_user_field';
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
            new Entity\TextField('ENTITY_ID'),
            new Entity\TextField('FIELD_NAME'),
            new Entity\TextField('USER_TYPE_ID'),
            new Entity\TextField('XML_ID'),
            new Entity\TextField('SORT'),
            new Entity\TextField('MULTIPLE'),
            new Entity\TextField('MANDATORY'),
            new Entity\TextField('SHOW_FILTER'),
            new Entity\TextField('SHOW_IN_LIST'),
            new Entity\TextField('EDIT_IN_LIST'),
            new Entity\TextField('IS_SEARCHABLE'),
            new Entity\TextField('SETTINGS'),
        );
    }
}