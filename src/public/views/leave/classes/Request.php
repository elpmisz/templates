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

  public function fetch($data)
  {
    $sql = "SELECT A.*, DATEDIFF(end, start) + 1 as diff,
    B.name as service_name,
    CONCAT('คุณ',C.name,' ',C.surname,' - ',DATE_FORMAT(A.approve_datetime, '%d/%m/%Y - %H:%i น.')) approver,
    CASE A.status
      WHEN 1 THEN 'รออนุมัติ'
      WHEN 2 THEN 'ผ่านการอนุมัติ'
      WHEN 3 THEN 'รายการถูกยกเลิก'
      ELSE NULL
    END as status_name,
    CASE A.status 
      WHEN 1 THEN 'primary'
      WHEN 2 THEN 'success'
      WHEN 3 THEN 'danger'
      ELSE NULL
    END as status_color
    FROM leave_request A 
    LEFT JOIN leave_service B 
    ON A.service_id = B.id
    LEFT JOIN user_detail C
    ON A.approver = C.id
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function update($data)
  {
    $sql = "UPDATE leave_request SET
    date = ?,
    start = ?,
    end = ?,
    text = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function approve($data)
  {
    $sql = "UPDATE leave_request SET
    approver = ?,
    approve_datetime = NOW(),
    remark = ?,
    status = ?
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function approve_count()
  {
    $sql = "SELECT COUNT(*) FROM leave_request WHERE status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
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
    $sql = "SELECT DATEDIFF(end, start) + 1 as diff 
    FROM leave_request 
    WHERE status IN (1,2) 
    AND user_id = ? 
    AND service_id = ?
    AND YEAR(created) = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    return (isset($row['diff']) ? $row['diff'] : 0);
  }

  public function service_remain($service, $request)
  {
    $sql = "SELECT day FROM leave_service WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($service);
    $service = $stmt->fetch();
    $total = $service['day'];

    $sql = "SELECT DATEDIFF(end, start) + 1 as diff 
    FROM leave_request 
    WHERE status IN (1,2) 
    AND user_id = ? 
    AND service_id = ?
    AND YEAR(created) = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($request);
    $row = $stmt->fetch();
    $used = (isset($row['diff']) ? $row['diff'] : 0);
    $remain = $total - $used;
    return $remain;
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
