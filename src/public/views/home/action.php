<?php

use app\classes\User;
use app\classes\Validation;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . '/../../vendor/autoload.php');


$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : "");
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

$Users = new User();
$Validation = new Validation();

if ($action === "login") :
  try {
    $email = (isset($_POST['email']) ? $Validation->input($_POST['email']) : "");
    $password = (isset($_POST['password']) ? $Validation->input($_POST['password']) : "");

    $email_count = $Users->email_count([$email]);
    if ($email_count === 0) {
      $Validation->alert("danger", "อีเมล์หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบข้อมูล", "/login");
    }

    $verify = $Users->password_verify([$email], $password);
    if (!$verify) {
      $Validation->alert("danger", "อีเมล์หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบข้อมูล", "/login");
    }

    $row = $Users->user_fetch_email([$email]);
    $Users->log_insert([$row['user_id']]);
    $_SESSION['user_id'] = $row['user_id'];
    $text = (!empty($row['name']) ? $row['fullname'] : "");

    $Validation->alert("primary", "ยินดีต้อนรับ {$text}", "/home");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "register") :
  try {
    $email = (isset($_POST['email']) ? $Validation->input($_POST['email']) : "");
    $password = (isset($_POST['password']) ? $Validation->input($_POST['password']) : "");
    $password2 = (isset($_POST['password2']) ? $Validation->input($_POST['password2']) : "");
    $options = ["cost" => 15, "salt" => "ceb20772e0c9d240c75eb26b0e37abee"];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    $format_email = $Validation->email($email);
    if (!$format_email) {
      $_SESSION['email'] = $email;
      $Validation->alert("danger", "รูปแบบอีเมล์ไม่ถูกต้อง กรุณาตรวจสอบข้อมูล", "/register");
    }

    $email_count = $Users->email_count([$email]);
    if ($email_count > 0) {
      $_SESSION['email'] = $email;
      $Validation->alert("danger", "อีเมล์นี้ถูกใช้ลงทะเบียนไปแล้ว กรุณาตรวจสอบข้อมูล", "/register");
    }

    if ($password !== $password2) {
      $_SESSION['email'] = $email;
      $Validation->alert("danger", "รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบข้อมูล", "/register");
    }

    session_unset((isset($_SESSION['email']) ? $Validation->input($_SESSION['email']) : ""));
    $Users->detail_register([$email]);
    $user__id = $Users->last_insert_id();
    $Users->login_register([$user__id, $hash]);

    $Validation->alert("success", "สร้างบัญชีใหม่เรียบร้อยแล้ว", "/login");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;