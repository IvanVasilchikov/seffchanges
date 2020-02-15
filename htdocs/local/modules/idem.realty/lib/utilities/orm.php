<?
namespace Idem\Realty\Utilities;

use Bitrix\Main\ORM\Fields;

trait Orm {

	private static function removeEmptyFields($input) {
		$tmp = [];
		foreach($input as $key=>$value) {
			if ($value) {
				$tmp[$key] = $value;
			}
		}
		return $tmp;
	}

	public function saveGroup() {
	    $arResult = [];
		$elements = $this->getAll();
		$inserted = array_chunk($elements, 20);
        $arResult[] = 'Загрузка класса: '.self::class."\n";
        $arResult[] = 'Ожидаемое кол-во: '.count($elements)."\n";
		$maxCount= count($elements);
		$count = 0;
		foreach($inserted as $chunk) {
			$collection = new self();
			foreach ($chunk as $item) {
				$collection[] = $item;
			}
            $collection->fill(Fields\FieldTypeMask::SCALAR | Fields\FieldTypeMask::USERTYPE);
			$collection->save();
			$count += count($chunk);
            $arResult[] = 'Сохранены данные на элементы: '.$count." из {$maxCount}\n";
		}
		
		return $arResult;
	}
}
