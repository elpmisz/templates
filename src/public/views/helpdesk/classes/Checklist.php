<?php

namespace app\classes;

class Checklist
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO helpdesk_checklists(name,type_id,topic_id) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function count($data)
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_checklists WHERE name = ? AND type_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function update($data)
  {
    $sql = "UPDATE helpdesk_checklists SET
    name = ?,
    type_id = ?,
    topic_id = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function fetch($data)
  {
    $sql = "SELECT A.id,A.name,A.type_id,A.topic_id,A.status,
    IF(A.topic_id = 0,'-',B.name) as topic_name,
    IF(A.status = 1,'รายละเอียด','ระงับการใช้งาน') as status_name,
    IF(A.status = 1,'primary','danger') as status_color 
    FROM helpdesk_checklists A
    LEFT JOIN helpdesk_checklists B
    ON A.topic_id = B.id
    WHERE A.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function topic_select($keyword)
  {
    $sql = "SELECT id,name FROM helpdesk_checklists WHERE type_id = 1 AND status = 1";
    if ($keyword) {
      $sql .= " AND (A.name LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
