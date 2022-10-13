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
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $topic = (isset($_POST['topic']) ? $Validation->input($_POST['topic']) : "");
    $suggestion = (isset($_POST['suggestion']) ? $Validation->input($_POST['suggestion']) : "");
    $period = (isset($_POST['period']) ? $Validation->input($_POST['period']) : "");
    $hardware = (isset($_POST['hardware']) ? $Validation->input($_POST['hardware']) : "");
    $approve = (isset($_POST['approve']) ? $Validation->input($_POST['approve']) : "");
    $calendar1 = (isset($_POST['calendar1']) ? $Validation->input($_POST['calendar1']) : "");
    $calendar2 = (isset($_POST['calendar2']) ? $Validation->input($_POST['calendar2']) : "");
    $checklist = (isset($_POST['checklist']) ? $Validation->input($_POST['checklist']) : "");
    $checklists = (isset($_POST['checklists']) ? implode(",", $_POST['checklists']) : "");
    $checker = (isset($_POST['checker']) ? $Validation->input($_POST['checker']) : "");

    $count = $Service->count([$name, $type]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ", "/helpdesk/service");
    }

    $Service->add([$name, $type, $topic, $suggestion, $period, $hardware, $approve, $calendar1, $calendar2, $checklist, $checklists, $checker]);

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/helpdesk/service");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $id = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $topic = (isset($_POST['topic']) ? $Validation->input($_POST['topic']) : "");
    $suggestion = (isset($_POST['suggestion']) ? $Validation->input($_POST['suggestion']) : "");
    $period = (isset($_POST['period']) ? $Validation->input($_POST['period']) : "");
    $hardware = (isset($_POST['hardware']) ? $Validation->input($_POST['hardware']) : "");
    $approve = (isset($_POST['approve']) ? $Validation->input($_POST['approve']) : "");
    $calendar1 = (isset($_POST['calendar1']) ? $Validation->input($_POST['calendar1']) : "");
    $calendar2 = (isset($_POST['calendar2']) ? $Validation->input($_POST['calendar2']) : "");
    $checklist = (isset($_POST['checklist']) ? $Validation->input($_POST['checklist']) : "");
    $checklists = (isset($_POST['checklists']) ? implode(",", $_POST['checklists']) : "");
    $checker = (isset($_POST['checker']) ? $Validation->input($_POST['checker']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Service->update([$name, $type, $topic, $suggestion, $period, $hardware, $approve, $calendar1, $calendar2, $checklist, $checklists, $checker, $status, $id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/helpdesk/service");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "topic") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Service->topic_select($keyword);

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
