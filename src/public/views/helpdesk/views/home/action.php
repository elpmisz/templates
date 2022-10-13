<?php

use app\classes\Request;
use app\classes\Validation;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : "");
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$Validation = new Validation();
$Request = new Request();

if ($action === "add") :
  try {
    $last = $Request->request_last();
    $service_id = (isset($_POST['service_id']) ? $Validation->input($_POST['service_id']) : "");
    $sub_id = (isset($_POST['sub_id']) ? $Validation->input($_POST['sub_id']) : "");
    $hardware = (isset($_POST['hardware']) ? $Validation->input($_POST['hardware']) : "");
    $date1 = (isset($_POST['date1']) ? $Validation->input($_POST['date1']) : "");
    $date2 = (isset($_POST['date2']) ? $Validation->input($_POST['date2']) : "");
    $text = (isset($_POST['text']) ? $Validation->input($_POST['text']) : "");
    $contact = (isset($_POST['service_id']) ? $Validation->input($_POST['contact']) : "");

    $approve = $Request->service_approve([$sub_id]);
    $status = (intval($approve) === 1 ? 1 : 2);

    if (array_filter($_FILES['file']['name'])) {
      foreach ($_FILES['file']['name'] as $key => $value) {
        $file_name = (isset($_FILES['file']['name']) ? $_FILES['file']['name'][$key] : "");
        $file_image = ["jpg", "jpeg", "png"];
        $file_document = ["pdf", "xls", "xlsx", "doc", "docx"];
        $file_allow = array_merge($file_image, $file_document);
        $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
        $file_size = round($_FILES['file']['size'][$key] / (1024 * 1024), 2);

        if (!in_array($file_extension, $file_allow)) {
          $Validation->alert("danger", "เฉพาะไฟล์เอกสาร WORD, EXCEL, PDF หรือไฟล์รูปภาพ PNG และ JPG เท่านั้น", "/helpdesk/request");
        }

        if ($file_size > 5) {
          $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/helpdesk/request");
        }
      }
    }

    $count = $Request->request_count([$user_id, $service_id, $sub_id, $hardware, $text]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ", "/helpdesk/request");
    }

    $Request->request_insert([$last, $user_id, $service_id, $sub_id, $hardware, $date1, $date2, $text, $contact, $status]);
    $request_id = $Request->last_insert_id();

    if (array_filter($_FILES['file']['name'])) {
      foreach ($_FILES['file']['name'] as $key => $value) {
        $file_name = (isset($_FILES['file']['name']) ? $_FILES['file']['name'][$key] : "");
        $file_tmp = (isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'][$key] : "");
        $file_random = md5(microtime());
        $file_image = ["jpg", "jpeg", "png"];
        $file_document = ["pdf", "xls", "xlsx", "doc", "docx"];
        $file_allow = array_merge($file_image, $file_document);
        $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);

        if (in_array($file_extension, $file_document)) {
          $file_new = "{$file_random}.{$file_extension}";
          $file_path = (__DIR__ . "/../../assets/upload/{$file_new}");
          $Request->document_upload($file_tmp, $file_path);
        }

        if (in_array($file_extension, $file_image)) {
          $file_new = "{$file_random}.webp";
          $file_path = (__DIR__ . "/../../assets/upload/{$file_new}");
          $Request->image_upload($file_tmp, $file_path);
        }

        $Request->upload_insert([$request_id, $file_new]);
      }
    }

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/helpdesk");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $request_id = (isset($_POST['request_id']) ? $Validation->input($_POST['request_id']) : "");
    $hardware = (isset($_POST['hardware']) ? $Validation->input($_POST['hardware']) : "");
    $date1 = (isset($_POST['date1']) ? $Validation->input($_POST['date1']) : "");
    $date2 = (isset($_POST['date2']) ? $Validation->input($_POST['date2']) : "");
    $text = (isset($_POST['text']) ? $Validation->input($_POST['text']) : "");
    $contact = (isset($_POST['contact']) ? $Validation->input($_POST['contact']) : "");

    if (array_filter($_FILES['file']['name'])) {
      foreach ($_FILES['file']['name'] as $key => $value) {
        $file_name = (isset($_FILES['file']['name']) ? $_FILES['file']['name'][$key] : "");
        $file_image = ["jpg", "jpeg", "png"];
        $file_document = ["pdf", "xls", "xlsx", "doc", "docx"];
        $file_allow = array_merge($file_image, $file_document);
        $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
        $file_size = round($_FILES['file']['size'][$key] / (1024 * 1024), 2);

        if (!in_array($file_extension, $file_allow)) {
          $Validation->alert("danger", "เฉพาะไฟล์เอกสาร WORD, EXCEL, PDF หรือไฟล์รูปภาพ PNG และ JPG เท่านั้น", "/helpdesk/request");
        }

        if ($file_size > 5) {
          $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/helpdesk/request");
        }
      }
    }

    $Request->request_update([$hardware, $date1, $date2, $text, $contact, $request_id]);

    if (array_filter($_FILES['file']['name'])) {
      foreach ($_FILES['file']['name'] as $key => $value) {
        $file_name = (isset($_FILES['file']['name']) ? $_FILES['file']['name'][$key] : "");
        $file_tmp = (isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'][$key] : "");
        $file_random = md5(microtime());
        $file_image = ["jpg", "jpeg", "png"];
        $file_document = ["pdf", "xls", "xlsx", "doc", "docx"];
        $file_allow = array_merge($file_image, $file_document);
        $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);

        if (in_array($file_extension, $file_document)) {
          $file_new = "{$file_random}.{$file_extension}";
          $file_path = (__DIR__ . "/../../assets/upload/{$file_new}");
          $Request->document_upload($file_tmp, $file_path);
        }

        if (in_array($file_extension, $file_image)) {
          $file_new = "{$file_random}.webp";
          $file_path = (__DIR__ . "/../../assets/upload/{$file_new}");
          $Request->image_upload($file_tmp, $file_path);
        }

        $Request->upload_insert([$request_id, $file_new]);
      }
    }

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/helpdesk/view/{$request_id}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "approve") :
  try {
    $request_id = (isset($_POST['request_id']) ? $Validation->input($_POST['request_id']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");
    $remark = (isset($_POST['remark']) ? $Validation->input($_POST['remark']) : "");

    $Request->request_approve([$user_id, $status, $remark, $request_id]);
    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/helpdesk");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "updatechecklist") :
  try {
    echo "<pre>";
    print_r($_POST);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "service") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->service_select($keyword);

    $data = [];
    foreach ($result as $row) :
      $data[] = [
        "id" => $row['id'],
        "text" => $row['name']
      ];
    endforeach;

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "sub") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $service = (isset($_POST['service']) ? $Validation->input($_POST['service']) : "");
    $result = $Request->sub_select($keyword, $service);

    $data = [];
    foreach ($result as $row) :
      $data[] = [
        "id" => $row['id'],
        "text" => $row['name']
      ];
    endforeach;

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "hardware") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->hardware_select($keyword);

    $data = [];
    foreach ($result as $row) :
      $data[] = [
        "id" => $row['id'],
        "text" => $row['name']
      ];
    endforeach;

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "condition") :
  try {
    $sub = (isset($_POST['sub']) ? $Validation->input($_POST['sub']) : "");
    $result = $Request->condition([$sub]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "checklist") :
  try {
    $service = (isset($_POST['service']) ? $Validation->input($_POST['service']) : '');
    $result = $Request->checklist_fetch([$service]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
