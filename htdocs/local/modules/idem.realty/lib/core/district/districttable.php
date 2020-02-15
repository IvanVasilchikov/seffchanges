<?php

namespace Idem\Realty\Core\District;

use \Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\Entity;

class DistrictTable extends DataManager
{
    public static function getTableName()
    {
        return 'i_district';
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
