<?php

namespace app\classes;

class Request
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO leave_request(user_id,service_id,date,start,end,text) VALUES(?,?,?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function service_select($keyword)
  {
    $sql = "SELECT id,name FROM leave_service WHERE status = 1";
    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function service_read()
  {
    $sql = "SELECT * FROM leave_service WHERE status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function service_fetch($data)
  {
    $sql = "SELECT * FROM leave_service WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function service_used($data)
  {
    $sql = "SELECT DATEDIFF(end, start) as diff 
    FROM leave_request 
    WHERE status IN (1,2) 
    AND user_id = ? 
    AND service_id = ?
    AND YEAR(created) = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    return (isset($row['diff']) ? $row['diff'] + 1 : 0);
  }

  public function document_upload($tmp, $path)
  {
    move_uploaded_file($tmp, $path);
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
    $stmt = $this->dbcon->prepare("SELECT picture FROM machine_request WHERE id = ?");
    $stmt->execute($id);
    $row = $stmt->fetch();
    if (!empty($row['picture'])) {
      return unlink(__DIR__ . "/../assets/img/machine/{$row['picture']}");
    } else {
      return false;
    }
  }

  public function last_insert_id()
  {
    return $this->dbcon->lastInsertId();
  }
}