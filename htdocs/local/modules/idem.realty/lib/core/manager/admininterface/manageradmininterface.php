<?php

namespace Idem\Realty\Core\Manager\AdminInterface;
use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface as DAdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\ComboBoxWidget;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\FileWidget;
use DigitalWand\AdminHelper\Widget\IblockElementWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\UserWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;
/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class ManagerAdminInterface extends DAdminInterface
{

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => 'Менеджер',
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'VIRTUAL' => false,
                        'TITLE' => 'ID',
                    ),
                    'NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'READONLY' => false,
                        'FILTER' => true,
                        'VIRTUAL' => false,
                        'TITLE' => 'Название',
                        'REQUIRED' => true,
                    ),
                    'CODE' => array(
                        'WIDGET' => new StringWidget(),
                        'READONLY' => false,
                        'FILTER' => true,
                        'VIRTUAL' => false,
                        'TITLE' => 'Код',
                        'REQUIRED' => true,
                    ),
                    'PHONE' => array(
                        'WIDGET' => new StringWidget(),
                        'READONLY' => false,
                        'FILTER' => true,
                        'VIRTUAL' => false,
                        'TITLE' => 'Телефон',
                        'REQUIRED' => true,
                    ),
                ),
            ),
        );
    }

    /**
     * @inheritdoc
     */
    
    public function helpers()
    {
        return array(
            '\Idem\Realty\Core\Manager\AdminInterface\ManagerListHelper' => array(
                'BUTTONS' => array(
                    'LIST_CREATE_NEW' => array(
                        'TEXT' => "Добавить менеджера",
                    ),
                )
            ),
            '\Idem\Realty\Core\Manager\AdminInterface\ManagerEditHelper' => array(
                'BUTTONS' => array(
                    'ADD_ELEMENT' => array(
                        'TEXT' => "Добавить менеджера",
                    ),
                    'DELETE_ELEMENT' => array(
                        'TEXT' => "Удалить менеджера",
                    )
                )
            )
        );
    }
}