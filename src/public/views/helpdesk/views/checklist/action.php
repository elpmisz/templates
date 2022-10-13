<?php

use app\classes\Checklist;
use app\classes\Validation;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . "/../../vendor/autoload.php");

$Validation = new Validation();
$Checklist = new Checklist();

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $Validation->input($param[0]) : "");
$param1 = (isset($param[1]) ? $Validation->input($param[1]) : "");
$param2 = (isset($param[2]) ? $Validation->input($param[2]) : "");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

if ($action === "add") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $type = (isset($_POST['type']) ? $Validation->input($_POST['type']) : "");
    $topic = (isset($_POST['topic']) ? $Validation->input($_POST['topic']) : "");

    $count = $Checklist->count([$name, $type]);
    if ($count > 0) {
      $Validation->alert("danger", "ข้อมูลซ้ำในระบบ", "/helpdesk/checklist");
    }

    $Checklist->add([$name, $type, $topic]);

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/helpdesk/checklist");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "topic") :
  try {
    $keyword = (isset($_POST['q']) ? $Validation->input($_POST['q']) : "");
    $result = $Checklist->topic_select($keyword);

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

if ($action === "view") :
  try {
    $checklist = (isset($_POST['checklist']) ? $Validation->input($_POST['checklist']) : "");

    $result = $Checklist->fetch([$checklist]);

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
    $topic = (isset($_POST['topic']) ? $Validation->input($_POST['topic']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Checklist->update([$name, $type, $topic, $status, $id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/helpdesk/checklist");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
