<?php
namespace Idem\Realty\Core\Objects\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;
use Idem\Realty\Core\Objects\AdminInterface\ObjectsEditHelper;
use Bitrix\Main\Localization\Loc;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ObjectsListHelper extends AdminListHelper
{
    protected static $model = 'Idem\Realty\Core\Objects\ObjectsTable';
   
    public static function getModule(){
        return 'idem.realty';
    }
    
    public function buildList($sort)
    {
        $this->setContext(AdminListHelper::OP_GET_DATA_BEFORE);
        
        $headers = $this->arHeader;
        
        
        // сортировка столбцов с сохранением исходной позиции в
        // массиве для развнозначных элементов
        // массив $headers модифицируется
        $this->mergeSortHeader($headers);
        
        $this->list->AddHeaders($headers);
        $visibleColumns = $this->list->GetVisibleHeaderColumns();
        
        $className = static::getModel();
        $visibleColumns[] = $this->pk();
        $sectionsVisibleColumns[] = $this->sectionPk();
        
        $raw = array(
            'SELECT' => $visibleColumns,
            'FILTER' => $this->arFilter,
            'SORT' => $sort
        );
        
        foreach ($this->fields as $name => $settings) {
            if ((isset($settings['VIRTUAL']) AND $settings['VIRTUAL'] == true)) {
                $key = array_search($name, $visibleColumns);
                unset($visibleColumns[$key]);
                unset($this->arFilter[$name]);
                unset($sort[$name]);
            }
            if (isset($settings['FORCE_SELECT']) AND $settings['FORCE_SELECT'] == true) {
                $visibleColumns[] = $name;
            }
        }
        
        $visibleColumns = array_unique($visibleColumns);
        $sectionsVisibleColumns = array_unique($sectionsVisibleColumns);
        
        // Поля для селекта (перевернутый массив)
        $listSelect = array_flip($visibleColumns);
        foreach ($this->fields as $code => $settings) {
            $widget = $this->createWidgetForField($code);
            $widget->changeGetListOptions($this->arFilter, $visibleColumns, $sort, $raw);
            // Множественные поля не должны быть в селекте
            if (!empty($settings['MULTIPLE'])) {
                unset($listSelect[$code]);
            }
        }
        // Поля для селекта (множественные поля отфильтрованы)
        $listSelect = array_flip($listSelect);
        
        
        /*добавленный блок*/
        if($_REQUEST['entity'] == 'core_objects'){
            $listSelect = ['ID','INFO'];
        }
        $res = $this->getData($className, $this->arFilter, $listSelect, $sort, $raw);
        $res = new \CAdminResult($res, $this->getListTableID());
        $res->NavStart();
        $this->list->NavText($res->GetNavPrint(Loc::getMessage("PAGES")));
        while ($data = $res->NavNext(false)) {
            /*добавленный блок*/
            if($_REQUEST['entity'] == 'core_objects')
                $data['INFO']['ID'] = $data['ID'];
                $data = $data['INFO'];
            $this->modifyRowData($data);
            list($link, $name) = $this->getRow($data);
            $row = $this->list->AddRow($data[$this->pk()], $data, $link, $name);
            foreach ($this->fields as $code => $settings) {
                $this->addRowCell($row, $code, $data);
            }
            $row->AddActions($this->getRowActions($data));
        }
        
        
        $this->list->AddFooter($this->getFooter($res));
        $this->list->AddGroupActionTable($this->getGroupActions(), $this->groupActionsParams);
        $this->list->AddAdminContextMenu($this->getContextMenu());
        
        $this->list->BeginPrologContent();
        echo $this->prologHtml;
        $this->list->EndPrologContent();
        
        $this->list->BeginEpilogContent();
        echo $this->epilogHtml;
        $this->list->EndEpilogContent();
        
        // добавляем ошибки в CAdminList для режимов list и frame
        if(in_array($_GET['mode'], array('list','frame')) && is_array($this->getErrors())) {
            foreach($this->getErrors() as $error) {
                $this->list->addGroupError($error);
            }
        }
        
        $this->list->CheckListMode();
    }
    
    /*
     * функционал фильтрации списка объектов
     */
    protected function getData($className, $filter, $select, $sort, $raw)
    {
        $parameters = array(
            'filter' => $this->getElementsFilter($filter),
            'select' => $select,
            'order' => $sort
        );
        
        $sqlFilter = "";
        foreach ($filter as $field => $searchVal) {
            if($field == 'ID'){
                if (empty($sqlFilter))
                    $sqlFilter = " WHERE ID = {$searchVal}";
                else
                    $sqlFilter .= " AND ID = {$searchVal}";
            }
            else {
                if (empty($sqlFilter))
                    $sqlFilter = " WHERE INFO->\"$.{$field}\" = {$searchVal}";
                else
                    $sqlFilter .= " AND INFO->\"$.{$field}\" = {$searchVal}";
            }
        }
        $connection = \Bitrix\Main\Application::getConnection();
        $countResult =  $connection->query('select ID from i_objects'.$sqlFilter)->fetchAll();
        $arIDs = array_column($countResult, 'ID');
        if(!empty($arIDs))
            $parameters['filter'] = ['ID' => $arIDs];
        else
            return [];
        
        /** @var Result $res */
        $res = $className::getList($parameters);
        
        return $res;
    }
}