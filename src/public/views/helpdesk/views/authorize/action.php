<?php

use app\classes\Authorize;
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
$Authorize = new Authorize();

if ($action === "add") :
  try {
    $type_id = (isset($_POST['type_id']) ? $Validation->input($_POST['type_id']) : "");
    $user_id = (isset($_POST['user_id']) ? $Validation->input($_POST['user_id']) : "");

    $count = $Authorize->count([$type_id, $user_id]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ กรุณาตรวจสอบข้อมูล", "/helpdesk/authorize");
    }

    $Authorize->add([$type_id, $user_id]);

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/helpdesk/authorize");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "delete") :
  try {
    $auth = (isset($param1) ? $param1 : "");

    $Authorize->delete([$auth]);
    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/helpdesk/authorize");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "user") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Authorize->user_select($keyword);

    $data = [];
    foreach ($result as $row) :
      $data[] = [
        "id" => $row['user_id'],
        "text" => $row['user_name']
      ];
    endforeach;

    echo json_encode($data);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
