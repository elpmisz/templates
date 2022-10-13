<?php

use app\classes\Brand;
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
$Brand = new Brand();

if ($action === "add") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $reference = (isset($_POST['reference']) ? $Validation->input($_POST['reference']) : "");

    $Brand->add([$name, $type, $reference]);

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/machine/brand");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "view") :
  try {
    $brand_id = (isset($_POST['brand']) ? $Validation->input($_POST['brand']) : "");

    $result = $Brand->fetch([$brand_id]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $id = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $reference = (isset($_POST['reference']) ? $Validation->input($_POST['reference']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Brand->update([$name, $type, $reference, $status, $id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/machine/brand");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "reference") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Brand->reference_search($keyword);

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