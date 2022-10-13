<?php

use app\classes\Software;
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
$Sofeware = new Software();

if ($action === "add") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");

    $Sofeware->add([$name]);

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/machine/software");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "view") :
  try {
    $software_id = (isset($_POST['software']) ? $Validation->input($_POST['software']) : "");

    $result = $Sofeware->fetch([$software_id]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $id = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Sofeware->update([$name, $status, $id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/machine/software");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;