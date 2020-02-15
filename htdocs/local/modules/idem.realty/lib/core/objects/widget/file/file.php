<?php

namespace Idem\Realty\Core\Objects\Widget\File;

use DigitalWand\AdminHelper\Widget\HelperWidget;
use Idem\Realty\Core\Files\FilesTable;
/**
 * Для множественного поля в таблице должен быть столбец FILE_ID.
 * Настройки класса:
 * <ul>
 * <li><b>DESCRIPTION_FIELD</b> - bool нужно ли поле описания</li>
 * <li><b>MULTIPLE</b> - bool является ли поле множественным</li>
 * <li><b>IMAGE</b> - bool отображать ли изображение файла, для старого вида отображения</li>
 * </ul>
 */
class File extends HelperWidget
{
    protected static $defaults = array(
        'IMAGE' => false,
        'DESCRIPTION_FIELD' => false,
        'EDIT_IN_LIST' => false,
        'FILTER' => false,
        'UPLOAD' => true,
        'MEDIALIB' => true,
        'FILE_DIALOG' => true,
        'CLOUD' => true,
        'DELETE' => true,
        'EDIT' => true,
    );

    /**
     * {@inheritdoc}
     */
    public function __construct(array $settings = array())
    {
        parent::__construct($settings);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditHtml()
    {
        if (class_exists('\Bitrix\Main\UI\FileInput', true) && $this->getSettings('IMAGE') === true) {
            $html = FileInput::createInstance(array(
                'name' => $this->getEditInputName('_FILE'),
                'description' => $this->getSettings('DESCRIPTION_FIELD'),
                'upload' => $this->getSettings('UPLOAD'),
                'allowUpload' => 'I',
                'medialib' => $this->getSettings('MEDIALIB'),
                'fileDialog' => $this->getSettings('FILE_DIALOG'),
                'cloud' => $this->getSettings('CLOUD'),
                'delete' => $this->getSettings('DELETE'),
                'edit' => $this->getSettings('EDIT'),
                'maxCount' => 1
            ))->show($this->getValue());
        } else {

            $html = \CFileInput::Show($this->getEditInputName('_FILE'), (!empty($this->getValue()) ? $this->getValue() : 0),
                array(
                    'IMAGE' => $this->getSettings('IMAGE') === true ? 'Y' : 'N',
                    'PATH' => 'Y',
                    'FILE_SIZE' => 'Y',
                    'ALLOW_UPLOAD' => 'I',
                ), array(
                    'upload' => $this->getSettings('UPLOAD'),
                    'medialib' => $this->getSettings('MEDIALIB'),
                    'file_dialog' => $this->getSettings('FILE_DIALOG'),
                    'cloud' => $this->getSettings('CLOUD'),
                    'del' => $this->getSettings('DELETE'),
                    'description' => $this->getSettings('DESCRIPTION_FIELD'),
                )
            );
        }
        if ($this->getValue() && !is_array($this->getValue())) {
            $html .= '<input type="hidden" name="' . $this->getEditInputName() . '" value=' . $this->getValue() . '>';
        }
        elseif ($this->getValue() && is_array($this->getValue())) {
            foreach ($this->getValue() as $val)
                $html .= '<input type="hidden" name="' . $this->getEditInputName() . '[]" value=' . $val . '>';
        }

        return $html;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMultipleEditHtml()
    {
        $inputName = $this->getValue();
        $inputHidden = $this->getValue();

        if (class_exists('\Bitrix\Main\UI\FileInput', true) && $this->getSettings('IMAGE') === true) {
            $html = \Bitrix\Main\UI\FileInput::createInstance(array(
                'name' => $this->code . '[n#IND#]',
                'description' => $this->getSettings('DESCRIPTION_FIELD'),
                'upload' => $this->getSettings('UPLOAD'),
                'allowUpload' => 'I',
                'medialib' => $this->getSettings('MEDIALIB'),
                'fileDialog' => $this->getSettings('FILE_DIALOG'),
                'cloud' => $this->getSettings('CLOUD'),
                'delete' => $this->getSettings('DELETE'),
                'edit' => $this->getSettings('EDIT')
            ))->show($inputName);
        } else {

            $val = $this->getValue();
            if (!is_array($val))
                $val = [$this->getValue()];
            $html = \CFileInput::ShowMultiple($val, $this->code . '[n#IND#]',
                array(
                    'IMAGE' => $this->getSettings('IMAGE') === true ? 'Y' : 'N',
                    'PATH' => 'Y',
                    'FILE_SIZE' => 'Y',
                    'DIMENSIONS' => 'Y',
                    'IMAGE_POPUP' => 'Y',
                ),
                false,
                array(
                    'upload' => $this->getSettings('UPLOAD'),
                    'medialib' => $this->getSettings('MEDIALIB'),
                    'file_dialog' => $this->getSettings('FILE_DIALOG'),
                    'cloud' => $this->getSettings('CLOUD'),
                    'del' => $this->getSettings('DELETE'),
                    'description' => $this->getSettings('DESCRIPTION_FIELD'),
                )
            );
        }

        foreach ($inputHidden as $key => $input) {
            if (!empty($input)) {
                $html .= '<input type="hidden" name="' . $this->code . '[' . $key . '][ID]" value=' . $key . '>
                <input type="hidden" name="' . $this->code . '[' . $key . '][VALUE]" value=' . $input . '>';

                //$html .= '<input type="hidden" name="' . $this->code . '[]" value=' . $input . '>';
            }
        }


        return $html;
    }

    /**
     * {@inheritdoc}
     */
    public function generateRow(&$row, $data)
    {
        $html = '';

        if ($this->getSettings('MULTIPLE')) {

        } else {
            $path = \CFile::GetPath($data[$this->code]);
            $rsFile = \CFile::GetByID($data[$this->code]);
            $file = $rsFile->Fetch();

            if ($path) {
                $html = '<a href="' . $path . '" >' . $file['FILE_NAME'] . ' (' . $file['FILE_DESCRIPTION'] . ')' . '</a>';
            }

            $row->AddViewField($this->code, $html);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function showFilterHtml()
    {
        // TODO: Implement genFilterHTML() method.
    }

    public function getFileIDByName($name)
    {
        $BDres = FilesTable::getList([
            'select' => ['ID','FILE_NAME'],
            'filter' => ['FILE_NAME' => $name]
        ]);
        if($res = $BDres->fetch())
            return $res['ID'];
        else
            return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function processEditAction()
    {
        parent::processEditAction();

        if ($this->getSettings('MULTIPLE')) {
            if ($this->getSettings('READONLY') === true) {
                //удаляем все добавленные файлы в режиме только для чтения
                foreach ($this->data[$this->code] as $key => $value) {
                    if (!is_array($value)) {
                        unset($this->data[$this->code][$key]);
                    }
                }
                return false;
            }

            if (class_exists('\Bitrix\Main\UI\FileInput', true) && $this->getSettings('IMAGE') === true) {
                foreach ($this->data[$this->code] as $key => $value) {
                    if (is_array($value) && ($value['name'] || $value['tmp_name'])) {
                        $_FILES[$this->code]['name'][$key] = $value['name'];
                        $_FILES[$this->code]['type'][$key] = $value['type'];
                        $_FILES[$this->code]['tmp_name'][$key] = $value['tmp_name'];
                        $_FILES[$this->code]['error'][$key] = $value['error'];
                        $_FILES[$this->code]['size'][$key] = $value['size'];
                        unset($this->data[$this->code][$key]);
                    } else {
                        $_FILES[$this->code]['name'][$key] = '';
                    }
                }
                if (!count($this->data[$this->code])) {
                    unset($this->data[$this->code]);
                }
            }

            if (!empty($_FILES[$this->getCode()])) {

                foreach ($_FILES[$this->getCode()]['name'] as $key => $fileName) {
                    if (empty($fileName)
                        || empty($_FILES[$this->getCode()]['tmp_name'][$key])
                        || !empty($_FILES[$this->getCode()]['error'][$key])
                    ) {
                        if (isset($_REQUEST[$this->getCode() . '_del'][$key])) {
                            if (is_array($this->data[$this->getCode()][$key]) &&
                                !empty($this->data[$this->getCode()][$key]['VALUE'])
                            ) {
                                $tempPath = $this->data[$this->getCode()][$key]['VALUE'];
                                $io = \CBXVirtualIo::GetInstance();
                                $strFilePath = $_SERVER["DOCUMENT_ROOT"].$tempPath;
                                if($io->FileExists($strFilePath) && !is_numeric($tempPath)) {
                                    $arTemp = explode('/', $this->data[$this->getCode()][$key]['VALUE']);
                                    $cnt = count($arTemp);
                                    $delFileName = $arTemp[$cnt - 1];
                                    if ($fileID = $this->getFileIDByName($delFileName))
                                        $this->data[$this->getCode()][$key]['VALUE'] = $fileID;
                                }
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]['VALUE']));

                            } else {
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]));
                            }

                            unset($this->data[$this->getCode()][$key]);
                        } elseif ($this->data[$this->getCode()][$key]['VALUE']) {
                            \CFile::UpdateDesc($this->data[$this->getCode()][$key]['VALUE'],
                                $_REQUEST[$this->getCode() . '_descr'][$key]);
                        }
                        continue;
                    } elseif (is_int($key)) {
                        //Удаляем старый файл при замене

                        if (is_array($this->data[$this->getCode()][$key]) &&
                            !empty($this->data[$this->getCode()][$key]['VALUE'])
                        ) {
                            $tempPath = $this->data[$this->getCode()][$key]['VALUE'];
                            $io = \CBXVirtualIo::GetInstance();
                            $strFilePath = $_SERVER["DOCUMENT_ROOT"].$tempPath;
                            if($io->FileExists($strFilePath) && !is_numeric($tempPath)) {
                                $arTemp = explode('/', $this->data[$this->getCode()][$key]['VALUE']);
                                $cnt = count($arTemp);
                                $delFileName = $arTemp[$cnt - 1];
                                if ($fileID = $this->getFileIDByName($delFileName))
                                    $this->data[$this->getCode()][$key]['VALUE'] = $fileID;
                            }
                            \CFile::Delete(intval($this->data[$this->getCode()][$key]['VALUE']));
                        } else {
                            \CFile::Delete(intval($this->data[$this->getCode()][$key]));
                        }
                    }

                    $description = null;

                    if (isset($_REQUEST[$this->getCode() . '_descr'][$key])) {
                        $description = $_REQUEST[$this->getCode() . '_descr'][$key];
                    }

                    if (empty($this->data[$this->getCode()][$key])) {
                        unset($this->data[$this->getCode()][$key]);
                    }

                    $fileId = $this->saveFile($fileName, $_FILES[$this->getCode()]['tmp_name'][$key], false, $description);

                    if ($fileId) {
                        $this->data[$this->getCode()][$key] = array('VALUE' => $fileId);
                    } else {
                        $this->addError('DIGITALWAND_AH_FAIL_ADD_FILE', array(
                            'FILE_NAME' => $_FILES[$this->getCode()]['name'][$key]
                        ));
                    }
                }
            }
            else{
                    if (isset($_REQUEST[$this->getCode() . '_del'])) {

                        foreach ($_REQUEST[$this->getCode() . '_del'] as $key => $item) {
                            if (is_array($this->data[$this->getCode()][$key]) &&
                                !empty($this->data[$this->getCode()][$key]['VALUE'])
                            ) {
                                $tempPath = $this->data[$this->getCode()][$key]['VALUE'];
                                $io = \CBXVirtualIo::GetInstance();
                                $strFilePath = $_SERVER["DOCUMENT_ROOT"].$tempPath;
                                if($io->FileExists($strFilePath) && !is_numeric($tempPath)) {
                                    $arTemp = explode('/', $this->data[$this->getCode()][$key]['VALUE']);
                                    $cnt = count($arTemp);
                                    $delFileName = $arTemp[$cnt - 1];
                                    if ($fileID = $this->getFileIDByName($delFileName))
                                        $this->data[$this->getCode()][$key]['VALUE'] = $fileID;
                                }
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]['VALUE']));
                            } else {
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]));
                            }

                            unset($this->data[$this->getCode()][$key]);
                        }
                    }
                    else {
                        foreach ($_REQUEST[$this->getCode() . '_del'] as $key => $item) {
                            //Удаляем старый файл при замене
                            if (is_array($this->data[$this->getCode()][$key]) &&
                                !empty($this->data[$this->getCode()][$key]['VALUE'])
                            ) {
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]['VALUE']));
                            } else {
                                \CFile::Delete(intval($this->data[$this->getCode()][$key]));
                            }
                        }
                    }

            }
        } else {
            if (class_exists('\Bitrix\Main\UI\FileInput', true) && $this->getSettings('IMAGE') === true) {
                if (is_array($this->data[$this->code . '_FILE']) && ($this->data[$this->code . '_FILE']['name'] ||
                        $this->data[$this->code . '_FILE']['tmp_name'])
                ) {
                    $_FILES['FIELDS']['name'][$this->code . '_FILE'] = $this->data[$this->code . '_FILE']['name'];
                    $_FILES['FIELDS']['type'][$this->code . '_FILE'] = $this->data[$this->code . '_FILE']['type'];
                    $_FILES['FIELDS']['tmp_name'][$this->code . '_FILE'] = $this->data[$this->code . '_FILE']['tmp_name'];
                    $_FILES['FIELDS']['error'][$this->code . '_FILE'] = $this->data[$this->code . '_FILE']['error'];
                    $_FILES['FIELDS']['size'][$this->code . '_FILE'] = $this->data[$this->code . '_FILE']['size'];
                }
            }

            unset($this->data[$this->code . '_FILE']);

            if ($this->getSettings('READONLY') === true) {
                return false;
            }

            if (empty($_FILES['FIELDS']['name'][$this->code . '_FILE'])
                || empty($_FILES['FIELDS']['tmp_name'][$this->code . '_FILE'])
                || !empty($_FILES['FIELDS']['error'][$this->code . '_FILE'])
            ) {
                if (isset($_REQUEST['FIELDS_del'][$this->code . '_FILE']) AND $_REQUEST['FIELDS_del'][$this->code . '_FILE'] == 'Y') {
                    \CFile::Delete(intval($this->data[$this->code]));
                    $this->data[$this->code] = 0;
                } elseif ($this->data[$this->code] && isset($_REQUEST['FIELDS_descr'][$this->code . '_FILE'])) {
                    \CFile::UpdateDesc($this->data[$this->code],
                        $_REQUEST['FIELDS_descr'][$this->code . '_FILE']);
                }
                return false;
            }

            $description = null;

            if (isset($_REQUEST['FIELDS_descr'][$this->code . '_FILE'])) {
                $description = $_REQUEST['FIELDS_descr'][$this->code . '_FILE'];
            }

            $name = $_FILES['FIELDS']['name'][$this->code . '_FILE'];
            $path = $_FILES['FIELDS']['tmp_name'][$this->code . '_FILE'];
            $type = $_FILES['FIELDS']['type'][$this->code . '_FILE'];

            $this->saveFile($name, $path, $type, $description);
        }
    }

    protected function saveFile($name, $path, $type = false, $description = null)
    {
        if (!$path) {
            return false;
        }

        $file = \CFile::MakeFileArray($path, $type);

        if (!$file) {
            return false;
        }

        if (!empty($description)) {
            $file['description'] = $description;
        }

        if ($this->getSettings('IMAGE') === true && stripos($file['type'], "image") === false) {
            $this->addError('FILE_FIELD_TYPE_ERROR');

            return false;
        }

        $file['name'] = $name;

        $moduleId = $this->helper->getModule();
        $file['MODULE_ID'] = $moduleId;

        $fileId = \CFile::SaveFile($file, "client_imgs");

        if (!$this->getSettings('MULTIPLE')) {
            $code = $this->code;

            if (isset($this->data[$code])) {
                \CFile::Delete($this->data[$code]);
            }

            $this->data[$code] = $fileId;
        }

        return $fileId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getValueReadonly()
    {
        $this->setSetting('UPLOAD', false);
        $this->setSetting('MEDIALIB', false);
        $this->setSetting('FILE_DIALOG', false);
        $this->setSetting('CLOUD', false);
        $this->setSetting('DELETE', false);
        $this->setSetting('EDIT', false);

        return $this->getEditHtml();
    }

    /**
     * {@inheritdoc}
     */
    protected function getMultipleValueReadonly()
    {
        $this->setSetting('UPLOAD', false);
        $this->setSetting('MEDIALIB', false);
        $this->setSetting('FILE_DIALOG', false);
        $this->setSetting('CLOUD', false);
        $this->setSetting('DELETE', false);
        $this->setSetting('EDIT', false);

        return $this->getMultipleEditHtml();
    }
}