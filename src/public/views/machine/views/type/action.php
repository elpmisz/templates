<?php

use app\classes\Type;
use app\classes\Validation;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . "/../../vendor/autoload.php");

$Validation = new Validation();
$Type = new Type();

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $Validation->input($param[0]) : "");
$param1 = (isset($param[1]) ? $Validation->input($param[1]) : "");
$param2 = (isset($param[2]) ? $Validation->input($param[2]) : "");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");


if ($action === "add") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $software = (isset($_POST['software']) ? $Validation->input($_POST['software']) : "");

    $Type->type_add([$name, $software]);
    $type_id = $Type->last_insert_id();

    foreach (array_filter($_POST['subject']) as $key => $value) {
      $subject = (isset($_POST['subject']) ? $Validation->input($_POST['subject'][$key]) : "");
      $type = (isset($_POST['type']) ? $Validation->input($_POST['type'][$key]) : "");
      $text = (isset($_POST['text']) ? $Validation->input($_POST['text'][$key]) : "");

      $Type->item_add([$type_id, $subject, $type, $text]);
    }

    $Validation->alert("success", "เพิ่มเรียบร้อยแล้ว", "/machine/type");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "update") :
  try {
    $id = (isset($_POST['request']) ? $Validation->input($_POST['request']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $software = (isset($_POST['software']) ? $Validation->input($_POST['software']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $Type->type_update([$name, $software, $status, $id]);

    foreach (array_filter($_POST['subject']) as $key => $value) {
      $item = (isset($_POST['item']) ? $Validation->input($_POST['item'][$key]) : "");
      $subject = (isset($_POST['subject']) ? $Validation->input($_POST['subject'][$key]) : "");
      $type = (isset($_POST['type']) ? $Validation->input($_POST['type'][$key]) : "");
      $text = (isset($_POST['text']) ? $Validation->input($_POST['text'][$key]) : "");

      $Type->item_update([$subject, $type, $text, $item]);
    }

    foreach (array_filter($_POST['_subject']) as $key => $value) {
      $subject = (isset($_POST['_subject']) ? $Validation->input($_POST['_subject'][$key]) : "");
      $type = (isset($_POST['_type']) ? $Validation->input($_POST['_type'][$key]) : "");
      $text = (isset($_POST['_text']) ? $Validation->input($_POST['_text'][$key]) : "");

      $Type->item_add([$id, $subject, $type, $text]);
    }

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/machine/type/view/{$id}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "itemdelete") :
  try {
    $item = (isset($param1) ? $param1 : "");
    $request = (isset($param2) ? $param2 : "");

    $Type->item_delete([$item]);

    $Validation->alert("success", "ดำเนินการเรียบร้อยแล้ว", "/machine/type/view/{$request}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
