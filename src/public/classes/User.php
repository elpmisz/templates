<?php

namespace app\classes;

class User
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function user_count()
  {
    $sql = "SELECT COUNT(*) as total,
    (
      SELECT COUNT(*) 
      FROM user_detail A
      LEFT JOIN user_login B 
      ON A.id = B.user_id 
      WHERE B.level = 1
    ) as user_active,
    (
      SELECT COUNT(*) 
      FROM user_detail A
      LEFT JOIN user_login B 
      ON A.id = B.user_id 
      WHERE B.status = 1
      AND B.level = 9
    ) as admin_active,
    (
      SELECT COUNT(*) 
      FROM user_detail A
      LEFT JOIN user_login B
      ON A.id = B.user_id 
      WHERE B.status = 2
    ) as inactive
    FROM user_detail";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function email_count($data)
  {
    $sql = "SELECT COUNT(*) 
      FROM user_detail A 
      LEFT JOIN user_login B 
      ON A.id = B.user_id
      WHERE email = ?
      AND B.status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function password_verify($data, $password)
  {
    $sql = "SELECT password 
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id 
    WHERE email = ?
    AND B.status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    return  password_verify($password, $row['password']);
  }

  public function detail_register($data)
  {
    $sql = "INSERT INTO user_detail(email) VALUES(?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function login_register($data)
  {
    $sql = "INSERT INTO user_login(user_id, password) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function detail_insert($data)
  {
    $sql = "INSERT INTO user_detail(name,surname,email) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function login_insert($data)
  {
    $sql = "INSERT INTO user_login(user_id,password,level) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function log_insert($data)
  {
    $sql = "INSERT INTO login_log(user_id) VALUES(?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function detail_update($data)
  {
    $sql = "UPDATE user_detail SET
    name = ?,
    surname = ?,
    picture = ?,
    email = ?,
    contact = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function login_update($data)
  {
    $sql = "UPDATE user_login SET
    level = ?,
    status = ?,
    updated = NOW()
    WHERE user_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_update($data)
  {
    $sql = "UPDATE user_detail SET
    name = ?,
    surname = ?,
    picture = ?,
    contact = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_fetch_email($data)
  {
    $sql = "SELECT A.id as user_id,CONCAT('คุณ',A.name,' ',A.surname) as fullname,A.picture,A.email,A.contact,B.level,B.status
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id 
    WHERE A.email = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function user_fetch_id($data)
  {
    $sql = "SELECT A.id as user_id,A.name,A.surname,
    CONCAT('คุณ',A.name,' ',A.surname) as fullname,A.picture,A.email,A.contact,B.level,B.status
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id 
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function change_password($data)
  {
    $sql = "UPDATE user_login SET
    password = ?,
    updated = NOW()
    WHERE user_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function image_upload($tmp, $path)
  {
    $imageInfo   = (isset($tmp) ? getimagesize($tmp) : '');
    $imageWidth   = 500;
    $imageHeight = (isset($imageInfo) ? round($imageWidth * $imageInfo[1] / $imageInfo[0]) : '');
    $imageType    = $imageInfo[2];

    if ($imageType === IMAGETYPE_PNG) {
      $imageResource = imagecreatefrompng($tmp);
      $imageX = imagesx($imageResource);
      $imageY = imagesy($imageResource);
      $imageTarget = imagecreatetruecolor($imageWidth, $imageHeight);
      imagecopyresampled($imageTarget, $imageResource, 0, 0, 0, 0, $imageWidth, $imageHeight, $imageX, $imageY);
      imagewebp($imageTarget, $path, 100);
      imagedestroy($imageTarget);
    } else {
      $imageResource = imagecreatefromjpeg($tmp);
      $imageX = imagesx($imageResource);
      $imageY = imagesy($imageResource);
      $imageTarget = imagecreatetruecolor($imageWidth, $imageHeight);
      imagecopyresampled($imageTarget, $imageResource, 0, 0, 0, 0, $imageWidth, $imageHeight, $imageX, $imageY);
      imagewebp($imageTarget, $path, 100);
      imagedestroy($imageTarget);
    }
  }

  public function image_unlink($id)
  {
    $stmt = $this->dbcon->prepare("SELECT picture FROM user_detail WHERE id = ?");
    $stmt->execute($id);
    $row = $stmt->fetch();
    if (!empty($row['picture'])) {
      return unlink(__DIR__ . "/../assets/img/profile/{$row['picture']}");
    } else {
      return false;
    }
  }

  public function last_insert_id()
  {
    return $this->dbcon->lastInsertId();
  }
}
