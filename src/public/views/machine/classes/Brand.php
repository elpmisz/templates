<?php

namespace app\classes;

class Brand
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO machine_brand(name,type,reference) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function fetch($data)
  {
    $sql = "SELECT A.id,A.name,
    B.id as reference_id,B.name as reference_name,
    IF(A.type = 1, 'ยี่ห้อ', 'รุ่น') as type_name,A.type,
    IF(A.status = 1,'รายละเอียด', 'ระงับการใช้งาน') as status_name,A.status
    FROM machine_brand A
    LEFT JOIN machine_brand B
    ON A.reference = B.id 
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function update($data)
  {
    $sql = "UPDATE machine_brand SET
    name = ?,
    type = ?,
    reference = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function reference_search($keyword)
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
}
