<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
use Idem\Realty\Realty\Data;
use mikehaertl\wkhtmlto\Pdf;
use Idem\Realty\Core\Objects\ObjectsTable;
use PHPMailer\PHPMailer\PHPMailer;
use app\Util\Util;


Loader::includeModule('idem.realty');

$tmp = json_decode(file_get_contents('php://input'), true);
if ($tmp) {
    $_POST = $tmp;
}
use app\Form\Base\CIdemForm;
$write=new CIdemForm;
$arResult=$write->saveData("presentation_plan");
echo $arResult;

if($_POST["send"]=="Y"){
  global $APPLICATION;
  $detailObj = ObjectsTable::wakeUpObject(intval($_POST['object']));
  $detailObj->fill();
  $json = $detailObj->getInfo();
  if ($json["department_id"] == LIVE_DEPARTAMENT) {
    $titleConfig = ['object_type', 'area|postfix:м²'];
  } else if ($json["department_id"] == COUNTRY_DEPARTAMENT) {
    $titleConfig = ['object_type', 'area_building|postfix:м²'];
  } else if ($json["department_id"] == COMMERC_DEPARTAMENT || $json["department_id"] == FOREIGN_DEPARTAMENT) {
    $titleConfig = ['lot_name'];
  }
  if ($JK) {
    $titleConfig = ['lot_name'];
  }
  $title = Util::generatedFields($titleConfig, $json);
  $filename=$_SERVER["DOCUMENT_ROOT"] .'/upload/prez_tmp/'.intval($_POST["object"]).'.pdf';
  if (!file_exists($filename) || date("d.m.Y")!=date("d.m.Y", filectime($filename))) {
    $fieldsUrl = [
      "object_type" => $json["object_type"],
      "deal_type" => $json["deal_type"],
      "department" => $json["department"],
      "department_id" => $json["department_id"],
    ];
    $url = Data::createUrl([], $fieldsUrl);

    $pdf = new Pdf('https://admin:idem@' . SITE_SERVER_NAME . $url. 'id'.intval($_POST['object']).'/pdf/?html=Y');
    $globalOptions = [
      'margin-bottom'    => 0,
      'margin-left'    => 0,
      'margin-right'    => 0,
      'margin-top'    => 0,
      'page-width' => 1840,
      'dpi' => 300,
      'zoom' => 0.58,
      'page-size' => 'A4',
      'disable-smart-shrinking',
    ];
    $pdf->setOptions($globalOptions);
    if (!$pdf->saveAs($_SERVER["DOCUMENT_ROOT"] .'/upload/prez_tmp/'.intval($_POST['object']).'.pdf')) {
      $error = $pdf->getError();
      dump($error);
    }
  }
  $email = new PHPMailer();
  $email->SMTPDebug = 0;                                       // Enable verbose debug output
  $email->isSMTP();                                            // Set mailer to use SMTP
  $email->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
  $email->SMTPAuth = true;                                   // Enable SMTP authentication
  $email->Username = 'no-reply@idem.agency';                     // SMTP username
  $email->Password = 'YcgycQpVtWt';                               // SMTP password
  $email->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
  $email->Port = 465;
  $email->setFrom('no-reply@idem.agency', 'Saffariestate');
  $email->addAddress($_POST["email"]);
  $email->isHTML(true);
  $email->Subject = 'Заявка на презентацию Saffariestate.ru';
  $email->Body    = ' Вы заполнили заявку на получение презентации по объекту "'.$title.'".  Презентация во вложении';
  $email->CharSet = 'utf-8';
  $email->AddAttachment($filename, 'presentation.pdf');
  $email->send();
}