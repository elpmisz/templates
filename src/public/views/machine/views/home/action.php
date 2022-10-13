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
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $brand_id = (isset($_POST['brand_id']) ? $Validation->input($_POST['brand_id']) : "");
    $model_id = (isset($_POST['model_id']) ? $Validation->input($_POST['model_id']) : "");
    $type_id = (isset($_POST['type_id']) ? $Validation->input($_POST['type_id']) : "");
    $location_id = (isset($_POST['location_id']) ? $Validation->input($_POST['location_id']) : "");
    $serial = (isset($_POST['serial']) ? $Validation->input($_POST['serial']) : "");
    $asset = (isset($_POST['asset']) ? $Validation->input($_POST['asset']) : "");
    $purchase = (isset($_POST['purchase']) ? $Validation->input($_POST['purchase']) : "");
    $purchase = (!empty($purchase) ? date("Y-m-d", strtotime(str_replace("/", "-", $purchase))) : "");
    $expire = (isset($_POST['expire']) ? $Validation->input($_POST['expire']) : "");
    $expire = (!empty($expire) ? date("Y-m-d", strtotime(str_replace("/", "-", $expire))) : "");
    $text = (isset($_POST['text']) ? $Validation->input($_POST['text']) : "");

    $count = $Request->machine_count([$brand_id, $model_id, $serial]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ กรุณาตรวจสอบข้อมูล", "/machine/request");
    }

    $file_name = (isset($_FILES['picture']['name']) ? $Validation->input($_FILES['picture']['name']) : "");

    if (!empty($file_name)) {
      $file_tmp = (isset($_FILES['picture']['tmp_name']) ? $_FILES['picture']['tmp_name'] : "");
      $file_random = md5(microtime());
      $file_image = ["jpg", "jpeg", "png"];
      $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
      $file_size = number_format($_FILES['picture']['size'] / (1024 * 1024));

      if (!in_array($file_extension, $file_image)) {
        $Validation->alert("danger", "เฉพาะไฟล์รูปภาพเท่านั้น", "/machine/request");
      }

      if ($file_size > 5) {
        $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/machine/request");
      }

      $file_rename = "{$file_random}.webp";
      $file_path = (__DIR__ . "/../../assets/img/machine/{$file_rename}");

      $Request->image_upload($file_tmp, $file_path);
    }
    $file_rename = (!empty($file_rename) ? $file_rename : "");

    $Request->machine_insert([$name, $file_rename, $brand_id, $model_id, $type_id, $location_id, $serial, $asset, $purchase, $expire, $text]);
    $request_id = $Request->last_insert_id();

    foreach (array_filter($_POST['item_id']) as $key => $value) {
      $item_id = (isset($_POST['item_id']) ? $Validation->input($_POST['item_id'][$key]) : "");
      $item_text = (isset($_POST['item_text']) ? $Validation->input($_POST['item_text'][$key]) : "");

      $Request->item_insert([$request_id, $item_id, $item_text]);
    }

    foreach (array_filter($_POST['software_id']) as $key => $value) {
      $software_id = (isset($_POST['software_id']) ? $Validation->input($_POST['software_id'][$key]) : "");
      $remark = (isset($_POST['remark']) ? $Validation->input($_POST['remark'][$key]) : "");

      $count = $Request->software_count([$request_id, $software_id]);
      if (intval($count) === 0) {
        $Request->software_insert([$request_id, $software_id, $remark]);
      }
    }

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/machine/view/{$request_id}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $request = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $brand_id = (isset($_POST['brand_id']) ? $Validation->input($_POST['brand_id']) : "");
    $model_id = (isset($_POST['model_id']) ? $Validation->input($_POST['model_id']) : "");
    $location_id = (isset($_POST['location_id']) ? $Validation->input($_POST['location_id']) : "");
    $serial = (isset($_POST['serial']) ? $Validation->input($_POST['serial']) : "");
    $asset = (isset($_POST['asset']) ? $Validation->input($_POST['asset']) : "");
    $purchase = (isset($_POST['purchase']) ? $Validation->input($_POST['purchase']) : "");
    $purchase = (!empty($purchase) ? date("Y-m-d", strtotime(str_replace("/", "-", $purchase))) : "");
    $expire = (isset($_POST['expire']) ? $Validation->input($_POST['expire']) : "");
    $expire = (!empty($expire) ? date("Y-m-d", strtotime(str_replace("/", "-", $expire))) : "");
    $text = (isset($_POST['text']) ? $Validation->input($_POST['text']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $file_name = (isset($_FILES['picture']['name']) ? $Validation->input($_FILES['picture']['name']) : "");

    if (!empty($file_name)) {
      $file_tmp = (isset($_FILES['picture']['tmp_name']) ? $_FILES['picture']['tmp_name'] : "");
      $file_random = md5(microtime());
      $file_image = ["jpg", "jpeg", "png"];
      $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
      $file_size = number_format($_FILES['picture']['size'] / (1024 * 1024));

      if (!in_array($file_extension, $file_image)) {
        $Validation->alert("danger", "เฉพาะไฟล์รูปภาพเท่านั้น", "/machine/request");
      }

      if ($file_size > 5) {
        $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/machine/request");
      }

      $file_rename = "{$file_random}.webp";
      $file_path = (__DIR__ . "/../../assets/img/machine/{$file_rename}");

      $Request->image_upload($file_tmp, $file_path);
      $Request->image_unlink([$request]);
    }
    $row = $Request->machine_fetch([$request]);
    $file_rename = (!empty($file_rename) ? $file_rename : $row['picture']);

    $Request->machine_update([$name, $file_rename, $brand_id, $model_id, $location_id, $serial, $asset, $purchase, $expire, $text, $status, $request]);

    foreach (array_filter($_POST['item_id']) as $key => $value) {
      $item_id = (isset($_POST['item_id']) ? $Validation->input($_POST['item_id'][$key]) : "");
      $item_text = (isset($_POST['item_text']) ? $Validation->input($_POST['item_text'][$key]) : "");

      $Request->item_update([$item_text, $item_id]);
    }

    foreach (array_filter($_POST['software_id']) as $key => $value) {
      $software_id = (isset($_POST['software_id']) ? $Validation->input($_POST['software_id'][$key]) : "");
      $software_remark = (isset($_POST['software_remark']) ? $Validation->input($_POST['software_remark'][$key]) : "");

      $Request->software_update([$software_remark, $software_id]);
    }

    foreach (array_filter($_POST['_software_id']) as $key => $value) {
      $software_id = (isset($_POST['_software_id']) ? $Validation->input($_POST['_software_id'][$key]) : "");
      $remark = (isset($_POST['_remark']) ? $Validation->input($_POST['_remark'][$key]) : "");

      $count = $Request->software_count([$request, $software_id]);
      if (intval($count) === 0) {
        $Request->software_insert([$request, $software_id, $remark]);
      }
    }

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/machine/view/{$request}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "type") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->type_search($keyword);

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

if ($action === "location") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->location_search($keyword);

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

if ($action === "brand") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->brand_search($keyword);

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

if ($action === "model") :
  try {
    $keyword = (isset($_POST['keyword']) ? $Validation->input($_POST['keyword']) : "");
    $brand = (isset($_POST['brand']) ? $Validation->input($_POST['brand']) : "");
    $result = $Request->model_search($keyword, $brand);

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

if ($action === "software") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Request->software_search($keyword);

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

if ($action === "itemcondition") :
  try {
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $data = $Request->item_condition([$type]);

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "softwarecondition") :
  try {
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $data = $Request->software_condition([$type]);

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
