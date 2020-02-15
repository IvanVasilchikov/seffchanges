<?php

namespace Idem\Realty\Core\Departament;

use \Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\Entity;

class DepartamentTable extends DataManager
{
    public static function getCollectionClass()
    {
        return DepartamentCollection::class;
    }
    public static function getObjectClass()
    {
        return Departament::class;
    }
    
    public static function getTableName()
    {
        return 'i_departament';
    }
    
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplite' => true,
                'required' => false,
            )),
            new Entity\StringField('NAME', array(
                'required' => true,
            )),
            new Entity\StringField('CODE', array(
                'required' => true,
            ))
        ];
    }
}
