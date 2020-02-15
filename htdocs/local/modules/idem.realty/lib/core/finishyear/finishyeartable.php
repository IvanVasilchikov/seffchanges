<?php

namespace Idem\Realty\Core\Finishyear;

use \Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\Entity;

class FinishyearTable extends DataManager
{
    public static function getTableName()
    {
        return 'i_finishyear';
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
