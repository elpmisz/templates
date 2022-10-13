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

  public function machine_dashboard()
  {
    $sql = "SELECT COUNT(*) as total,
    (SELECT COUNT(*) FROM machine_request WHERE type_id IN (1)) as computer_count,
    (SELECT COUNT(*) FROM machine_request WHERE type_id NOT IN (1)) as other_count,
    (SELECT COUNT(*) FROM machine_request WHERE status = 2) as inactive
    FROM machine_request";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function machine_count($data)
  {
    $sql = "SELECT COUNT(*) FROM machine_request WHERE brand_id = ? AND model_id = ? AND serial = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function machine_insert($data)
  {
    $sql = "INSERT INTO machine_request(name,picture,brand_id,model_id,type_id,location_id,serial,asset,purchase,expire,text) 
    VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function machine_update($data)
  {
    $sql = "UPDATE machine_request SET 
    name = ?,
    picture = ?,
    brand_id = ?,
    model_id = ?,
    location_id = ?,
    serial = ?,
    asset = ?,
    purchase = ?,
    expire = ?,
    text = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function machine_fetch($data)
  {
    $sql = "SELECT A.*,A.id as machine_id,A.name as machine_name,
    A.type_id,B.name as type_name,B.software,
    A.location_id,C.name as location_name,
    A.brand_id,D.name as brand_name,
    A.model_id,E.name as model_name,
    IF(purchase = '0000-00-00', '', DATE_FORMAT(purchase, '%d/%m/%Y')) as purchase,
    IF(expire = '0000-00-00', '', DATE_FORMAT(expire, '%d/%m/%Y')) as expire
    FROM machine_request A
    LEFT JOIN machine_type B
    ON A.type_id = B.id 
    LEFT JOIN machine_location C
    ON A.location_id = C.id
    LEFT JOIN machine_brand D
    ON A.brand_id = D.id
    LEFT JOIN machine_brand E
    ON A.model_id = E.id
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function software_insert($data)
  {
    $sql = "INSERT INTO machine_request_software(request_id,software_id,remark) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function software_count($data)
  {
    $sql = "SELECT COUNT(*) FROM machine_request_software WHERE request_id = ? AND software_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }


  public function software_update($data)
  {
    $sql = "UPDATE machine_request_software SET
    remark = ?
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function software_fetch_id($data)
  {
    $sql = "SELECT A.id,B.name as software_name,A.remark
    FROM machine_request_software A 
    LEFT JOIN machine_software B
    ON A.software_id = B.id
    WHERE A.status = 1 
    AND request_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function item_insert($data)
  {
    $sql = "INSERT INTO machine_request_item(request_id,item_id,text) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function item_update($data)
  {
    $sql = "UPDATE machine_request_item SET
    text = ?
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function item_fetch_id($data)
  {
    $sql = "SELECT A.id,A.text as item_text,B.subject as subject_name,B.type as item_type,B.text as item_select
    FROM machine_request_item A 
    LEFT JOIN machine_type_item B
    ON A.item_id = B.id
    WHERE request_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function type_search($keyword)
  {
    $sql = "SELECT id,name FROM machine_type 
    WHERE status = 1 ";

    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%') ";
    }

    $sql .= "LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function location_search($keyword)
  {
    $sql = "SELECT id,name FROM machine_location 
    WHERE status = 1 ";

    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%') ";
    }

    $sql .= "LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function brand_search($keyword)
  {
    $sql = "SELECT id,name FROM machine_brand 
    WHERE type = 1
    AND status = 1 ";

    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%') ";
    }

    $sql .= "LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function model_search($keyword, $brand)
  {
    $sql = "SELECT id,name FROM machine_brand 
    WHERE type = 2
    AND status = 1
    AND reference = {$brand} ";

    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%') ";
    }

    $sql .= "LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function software_search($keyword)
  {
    $sql = "SELECT id,name FROM machine_software 
    WHERE status = 1 ";

    if ($keyword) {
      $sql .= " AND (name LIKE '%{$keyword}%') ";
    }

    $sql .= "LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function software_condition($data)
  {
    $sql = "SELECT software FROM machine_type WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function item_condition($data)
  {
    $sql = "SELECT id,subject,type,text FROM machine_type_item WHERE type_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
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
