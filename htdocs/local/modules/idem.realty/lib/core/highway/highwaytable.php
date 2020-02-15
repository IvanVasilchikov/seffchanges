<?php

namespace Idem\Realty\Core\Highway;

use \Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\Entity;

class HighwayTable extends DataManager
{
    public static function getTableName()
    {
        return 'i_highway';
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
