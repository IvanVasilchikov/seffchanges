<?php

namespace Idem\Realty\Core\Seo;

use \Bitrix\Main\ORM\Data\DataManager, Bitrix\Main\Entity;
use \Bitrix\Main\ORM\Fields;

class SeoTable extends DataManager
{
    public static function getTableName()
    {
        return 'i_seo';
    }
    
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplite' => true,
                'required' => false,
            )),
            new Entity\StringField('LINK'),
            new Fields\TextField('INFO', [
                'fetch_data_modification' => function () {
                    return array(
                        function ($value) {
                            return json_decode($value, true);
                        }
                    );
                }
            ]),
        ];
    }
}
