<?php

use app\classes\Service;
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
$Service = new Service();

if ($action === "add") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $day = (isset($_POST['day']) ? $Validation->input($_POST['day']) : "");


    $count = $Service->count([$name, $type]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ", "/leave/service");
    }

    $Service->add([$name, $day]);

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/leave/service");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "view") :
  try {
    $leave_id = (isset($_POST['leave']) ? $Validation->input($_POST['leave']) : "");

    $result = $Service->fetch([$leave_id]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $id = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $day = (isset($_POST['day']) ? $Validation->input($_POST['day']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Service->update([$name, $day, $status, $id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/leave/service");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;