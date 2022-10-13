<?php

use app\classes\System;
use app\classes\User;
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

$Users = new User();
$Systems = new System();
$Validation = new Validation();

$system = $Systems->fetch();

if ($action === "add") :
  try {
    $email = (isset($_POST['email']) ? $Validation->input($_POST['email']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $surname = (isset($_POST['surname']) ? $Validation->input($_POST['surname']) : "");
    $level = (isset($_POST['level']) ? $Validation->input($_POST['level']) : "");
    $password = $system['default_password'];
    $options = ["cost" => 15, "salt" => "ceb20772e0c9d240c75eb26b0e37abee"];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    $format_email = $Validation->email($email);
    if (!$format_email) {
      $Validation->alert("danger", "รูปแบบอีเมล์ไม่ถูกต้อง กรุณาตรวจสอบข้อมูล", "/users");
    }

    $email_count = $Users->email_count([$email]);
    if ($email_count > 0) {
      $Validation->alert("danger", "อีเมล์ซ้ำในระบบ กรุณาตรวจสอบข้อมูล", "/users");
    }

    $Users->detail_insert([$name, $surname, $email]);
    $user__id = $Users->last_insert_id();
    $Users->login_insert([$user__id, $hash, $level]);

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/users");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "adminupdate") :
  try {
    $user_id = (isset($_POST['user_id']) ? $Validation->input($_POST['user_id']) : "");
    $email = (isset($_POST['email']) ? $Validation->input($_POST['email']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $surname = (isset($_POST['surname']) ? $Validation->input($_POST['surname']) : "");
    $contact = (isset($_POST['contact']) ? $Validation->input($_POST['contact']) : "");
    $level = (isset($_POST['level']) ? $Validation->input($_POST['level']) : "");
    $status = (isset($_POST['status']) ? $Validation->input($_POST['status']) : "");

    $file_name = (isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : "");

    if (!empty($file_name)) {
      $file_tmp = (isset($_FILES['picture']['tmp_name']) ? $_FILES['picture']['tmp_name'] : "");
      $file_random = md5(microtime());
      $file_image = ["jpg", "jpeg", "png"];
      $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
      $file_size = number_format($_FILES['picture']['size'] / (1024 * 1024));

      if (!in_array($file_extension, $file_image)) {
        $Validation->alert("danger", "เฉพาะไฟล์รูปภาพเท่านั้น", "/users/view/{$user_id}");
      }

      if ($file_size > 5) {
        $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/users/view/{$user_id}");
      }

      $file_rename = "{$file_random}.webp";
      $file_path = (__DIR__ . "/../../assets/img/profile/{$file_rename}");

      $Users->image_upload($file_tmp, $file_path);
      $Users->image_unlink([$user_id]);
    }

    $row = $Users->user_fetch_id([$user_id]);
    $file_rename = (!empty($file_name) ? $file_rename : $row['picture']);

    $Users->detail_update([$name, $surname, $file_rename, $email, $contact, $user_id]);
    $Users->login_update([$level, $status, $user_id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/users");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "userupdate") :
  try {
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $surname = (isset($_POST['surname']) ? $Validation->input($_POST['surname']) : "");
    $contact = (isset($_POST['contact']) ? $Validation->input($_POST['contact']) : "");

    $file_name = (isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : "");

    if (!empty($file_name)) {
      $file_tmp = (isset($_FILES['picture']['tmp_name']) ? $_FILES['picture']['tmp_name'] : "");
      $file_random = md5(microtime());
      $file_image = ["jpg", "jpeg", "png"];
      $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
      $file_size = number_format($_FILES['picture']['size'] / (1024 * 1024));

      if (!in_array($file_extension, $file_image)) {
        $Validation->alert("danger", "เฉพาะไฟล์รูปภาพเท่านั้น", "/users/view/{$user_id}");
      }

      if ($file_size > 5) {
        $Validation->alert("danger", "ไฟล์ขนาดไม่เกิน 5 Mb. เท่านั้น", "/users/view/{$user_id}");
      }

      $file_rename = "{$file_random}.webp";
      $file_path = (__DIR__ . "/../../assets/img/profile/{$file_rename}");

      $Users->image_upload($file_tmp, $file_path);
      $Users->image_unlink([$user_id]);
    }

    $row = $Users->user_fetch_id([$user_id]);
    $file_rename = (!empty($file_name) ? $file_rename : $row['picture']);

    $Users->user_update([$name, $surname, $file_rename, $contact, $user_id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/users/profile");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "change") :
  try {
    $password = (isset($_POST['password']) ? $Validation->input($_POST['password']) : "");
    $password2 = (isset($_POST['password2']) ? $Validation->input($_POST['password2']) : "");
    $options = ["cost" => 15, "salt" => "ceb20772e0c9d240c75eb26b0e37abee"];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    if ($password != $password2) {
      $Validation->alert("danger", "รหัสผ่านไม่เหมือนกัน กรุณากรอกอีกครั้ง", "/users/profile");
    }

    $Users->change_password([$hash, $user_id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/users/profile");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;