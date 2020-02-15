<?php
namespace Idem\Realty\Core\Objects;

use Bitrix\Main\Entity;
use \Bitrix\Main\ORM\Data\DataManager, \Bitrix\Main\ORM\Fields;
use Idem\Realty\Core\Departament\DepartamentTable;


class ObjectsTable extends DataManager
{
	public static function getTableName()
	{
		return 'i_objects';
	}

	public static function getMap()
	{
		return [
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'unique' => true,
                'autocomplite' => true,
                'required' => true,
            )),
            new Entity\IntegerField('DEPARTAMENT_ID'),
            new Entity\ReferenceField(
                'DEPARTAMENT',
                'Idem\Realty\Core\Departament\DepartamentTable',
                array('=this.DEPARTAMENT_ID' => 'ref.ID')
            ),
			new Fields\IntegerField('ACTIVE'),
			new Fields\DatetimeField('LAST_MODIFY'),
			new Fields\IntegerField('EXT_ID'),
			new Fields\IntegerField('VIEW_COUNT'),
			new Fields\IntegerField('LIKE_COUNT'),
			new Fields\IntegerField('DISLIKE_COUNT'),
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
