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

$Request = new Request();
$Validation = new Validation();

if ($action === "add") :
  try {
    $service_id = (isset($_POST['service_id']) ? $Validation->input($_POST['service_id']) : "");
    $text = (isset($_POST['text']) ? $Validation->input($_POST['text']) : "");
    $date = (isset($_POST['date']) ? $Validation->input($_POST['date']) : "");
    $conv = explode("-", $date);
    $start = date("Y-m-d", strtotime(str_replace("/", "-", trim($conv[0]))));
    $end = date("Y-m-d", strtotime(str_replace("/", "-", trim($conv[1]))));

    $Request->add([$user_id, $service_id, $date, $start, $end, $text]);

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/leave");
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

if ($action === "used") :
  try {
    $service = (isset($_POST['service']) ? $Validation->input($_POST['service']) : "");
    $row = $Request->service_fetch([$service]);
    $used = $Request->service_used([$user_id, $service, date("Y")]);

    $calc = ($row['day'] - $used);
    echo json_encode($calc);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;