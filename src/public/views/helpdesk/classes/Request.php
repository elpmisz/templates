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

  public function request_last()
  {
    $sql = "SELECT last FROM helpdesk_request WHERE YEAR(created) = YEAR(NOW()) ORDER BY id DESC";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return ($row['last'] + 1);
  }

  public function approve_count()
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE status IN (1,5)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function process_count()
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE status IN (2,3,4)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function service_approve($data)
  {
    $sql = "SELECT approve FROM helpdesk_services WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    return $row['approve'];
  }

  public function request_insert($data)
  {
    $sql = "INSERT INTO helpdesk_request(last,user_id,service_id,sub_id,hardware_id,date1,date2,text,contact,status) 
    VALUES(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function request_count($data)
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE user_id = ? AND service_id = ? AND sub_id = ? AND text = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function request_fetch($data)
  {
    $sql = "SELECT 
    A.id as request_id,A.status as request_status,A.*,C.*,
    CONCAT('คุณ',E.name,' ',E.surname) as user_name,
    CONCAT('คุณ',F.name,' ',F.surname) as approver_name,
    DATE_FORMAT(A.approve_datetime, '%d/%m/%Y, %H:%i น.') as approve_datetime,
    CONCAT('HD',YEAR(NOW()),LPAD(A.last, GREATEST(LENGTH(A.last), 4), '0')) AS gen_id,
    DATE_FORMAT(A.created, '%d/%m/%Y, %H:%i น.') as created,
    A.service_id,B.name as service_name,
    A.sub_id,C.name as sub_name,
    A.hardware_id,D.name as hardware_name,
    CASE
      WHEN A.status = 1 THEN 'danger'
      WHEN A.status = 2 THEN 'warning'
      WHEN A.status = 3 THEN 'primary'
      WHEN A.status = 4 THEN 'primary'
      WHEN A.status = 5 THEN 'danger'
      WHEN A.status = 6 THEN 'success'
      WHEN A.status = 7 THEN 'danger'
      ELSE NULL
    END AS status_color,
    CASE
      WHEN A.status = 1 THEN 'รออนุมัติ'
      WHEN A.status = 2 THEN 'รอรับเรื่อง'
      WHEN A.status = 3 THEN 'กำลังดำเนินการ'
      WHEN A.status = 4 THEN 'รออุปกรณ์ / อะไหล่'
      WHEN A.status = 5 THEN 'รอตรวจสอบ'
      WHEN A.status = 6 THEN 'ดำเนินการเรียบร้อย'
      WHEN A.status = 7 THEN 'รายการยกเลิก'
      ELSE NULL
    END AS status_name
    FROM helpdesk_request A
    LEFT JOIN helpdesk_services B
    ON A.service_id = B.id
    LEFT JOIN helpdesk_services C
    ON A.sub_id = C.id
    LEFT JOIN machine_request D
    ON A.hardware_id = D.id
    LEFT JOIN user_detail E
    ON A.user_id = E.id
    LEFT JOIN user_detail F
    ON A.approver = F.id
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function request_checklist($data)
  {
    $sql = "SELECT B.id, B.name
    FROM helpdesk_services A
    LEFT JOIN helpdesk_checklists B
    ON FIND_IN_SET(B.id, A.checklists)
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function checklist_fetch($data)
  {
    $sql = "SELECT id,name FROM helpdesk_checklists WHERE topic_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function process_fetch($data)
  {
    $sql = "SELECT * FROM helpdesk_process WHERE request_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function request_update($data)
  {
    $sql = "UPDATE helpdesk_request SET
    hardware_id = ?,
    date1 = ?,
    date2 = ?,
    text = ?,
    contact = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function request_approve($data)
  {
    $sql = "UPDATE helpdesk_request SET
    approver = ?,
    approve_datetime = NOW(),
    status = ?,
    remark = ?
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function upload_insert($data)
  {
    $sql = "INSERT INTO helpdesk_upload(request_id,name) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function upload_fetch($data)
  {
    $sql = "SELECT id,name FROM helpdesk_upload WHERE request_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function condition($data)
  {
    $sql = "SELECT * FROM helpdesk_services WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function service_select($keyword)
  {
    $sql = "SELECT id,name FROM helpdesk_services WHERE type_id = 1 AND status = 1";
    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function sub_select($keyword, $service)
  {
    $sql = "SELECT id,name FROM helpdesk_services WHERE type_id = 2 AND status = 1 AND topic_id = {$service}";
    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function hardware_select($keyword)
  {
    $sql = "SELECT A.id,CONCAT(A.name,' [',B.name,' / ',C.name,']') as name 
    FROM machine_request A
    LEFT JOIN machine_brand B
    ON A.model_id = B.id
    LEFT JOIN machine_location C
    ON A.location_id = C.id
    WHERE A.status = 1";
    if ($keyword) {
      $sql .= " AND (A.name LIKE '%{$keyword}%' OR B.name LIKE '%{$keyword}%' OR C.name LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
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
