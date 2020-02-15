<?php

namespace app\Form\Base;

class CIdemForm
{
    private $errors = [];
    private $status = true;

    public function saveData($codeForm)
    {
        if(!\Bitrix\Main\Loader::includeModule('form')){
            $this->setError('Отсутствует модуль форм');
        }
        /*if(!$this->checkSession()){
            $this->setError('Ошибка проверки сессии');
        }*/
        if($this->status){
            $fields = $this->getQuestions($this->getId($codeForm));
            if(!$fields){
                $this->setError('Отсутствуют поля вопросов');
            }
        }

        if($this->status)
            $data = $this->parseData($fields);

        if($this->status)
            $this->saveResult($this->getId($codeForm),$data);
        if($this->status){
            echo json_encode(['status' => 'success']);
        }else{
            echo json_encode(['status' => $this->errors]);
        }
    }
    private function parseFile()
    {
        if (!empty($_FILES['file']['tmp_name'])) {    
            $name = rand().'_'.$_FILES['file']['name'];
            $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/upload/tmp_resume';
            $is_moved = move_uploaded_file($_FILES['file']['tmp_name'], "$uploads_dir/$name");
            if ($is_moved){
                return 'http://'.$_SERVER['HTTP_HOST']."/upload/tmp_resume/".$name;
            }else{
                return 'Ошибка файла';
            }
        }
    }

    private function parseData($fields)
    {
        $res = [];
        $cntErr = 0;
        foreach ($fields as $field){            
            if((!isset($_POST[$field['SID']]) || $_POST[$field['SID']] == '') && $field['REQUIRED'] == 'Y'){
                $this->setError('Не заполнено поле "'.$field['TITLE'].'"');
                $cntErr++;
            }
            if($cntErr == 0){
                if($field['ANSWER'] != null){
                    if($field['SID'] == "file"){
                        $fieldName = 'form_'.$field['ANSWER']['FIELD_TYPE'].'_'.$field['ANSWER']['FIELD_ID'];
                        $res[$fieldName] = $this->parseFile(); 
                    }else{
                        $fieldName = 'form_'.$field['ANSWER']['FIELD_TYPE'].'_'.$field['ANSWER']['FIELD_ID'];
                        $res[$fieldName] = htmlspecialchars($_POST[$field['SID']]);
                    }                   
                }else{
                    $this->setError('Отсутствует ответ у поля "'.$field['TITLE'].'"');
                }
            }
        }
        return $res;
    }

    private function saveResult($formId,$data)
    {
        $res = \CFormResult::Add($formId,$data);
        if($res){
            $this->sendEmail($res);
        }else{
            $this->setError('Ошибка сохранения результата');
        }
    }

    private function checkSession()
    {
        $res = check_bitrix_sessid();

        return $res;
    }

    private function getFormByCode($code)
    {
        $res = null;
        $dbRes = \Cform::GetList($by = 's_sort',$order = 'asc',['SID' => $code],$isFiltered);
        if($item = $dbRes->Fetch())
            $res = $item;

        return $item;
    }

    private function getQuestions($formId)
    {
        $res = [];
        $fields = new \CFormField();
        $dbRes = $fields->GetList($formId,'N',$by = "s_sort",$order = "asc",[],$isFiltered);
        while ($item = $dbRes->Fetch()){
            $item['ANSWER'] = $this->getAnswers($item['ID']);
            $res[$item['SID']] = $item;
        }

        return count($res) ? $res : null;
    }

    private function getAnswers($questionId)
    {
        $res = null;
        $dbRes = (new \CFormAnswer())->GetByID($questionId);
        if ($item = $dbRes->Fetch()){
            $res = $item;
        }

        return $res;
    }

    private function sendEmail($resId){
        $res = \CFormResult::Mail($resId);
        if(!$res){
            $this->status = false;
            $this->errors[] = 'Ошибка отправки результата';
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getStatus()
    {
        return $this->status;
    }

    private function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    /**
     * @fixme Проработать сбор ошибок
     */
    private function setError($text)
    {
        $this->status = false;
        $this->errors = $text;
    }
    public function getId($codeForm)
    {
        //if(!\Bitrix\Main\Loader::includeModule('form')){
        //    $this->setError('Отсутствует модуль форм');
        //}
        $id=0;
        $arFilter = Array("SID" => $codeForm);
        $form = new \CForm();
        $rsForms = $form::GetList($by="s_id", $order="desc", $arFilter, $is_filtered);
        while ($arForm = $rsForms->Fetch())
        {
            $id=$arForm["ID"];
        }
        return $id;
    }
   /* public static function getCode()
    {

    }*/
}
