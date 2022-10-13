<?php

use app\classes\System;
use app\classes\Validation;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . "/../../vendor/autoload.php");


$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : '');
$param1 = (isset($param[1]) ? $param[1] : '');
$param2 = (isset($param[2]) ? $param[2] : '');

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");
$System = new System();
$Validation = new Validation();

if ($action === "edit") :
  try {
    $id = (isset($_POST['id']) ? $Validation->input($_POST['id']) : "");
    $company = (isset($_POST['company']) ? $Validation->input($_POST['company']) : "");
    $email_name = (isset($_POST['email_name']) ? $Validation->input($_POST['email_name']) : "");
    $email_username = (isset($_POST['email_username']) ? $Validation->input($_POST['email_username']) : "");
    $email_password = (isset($_POST['email_password']) ? $Validation->input($_POST['email_password']) : "");
    $default_password = (isset($_POST['default_password']) ? $Validation->input($_POST['default_password']) : "");

    $format_email = $Validation->email($email_username);
    if (!$format_email) {
      $Validation->alert("danger", "รูปแบบอีเมล์ไม่ถูกต้อง กรุณาตรวจสอบข้อมูล.", "/system");
    }

    $System->update([$company, $email_name, $email_username, $email_password, $default_password, $user_id, $id]);

    $Validation->alert("success", "แก้ไขเรียบร้อยแล้ว.", "/system");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;