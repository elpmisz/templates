<?php

namespace app\classes;

class Authorize
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO leave_authorize(type_id,user_id) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function count($data)
  {
    $sql = "SELECT COUNT(*) FROM leave_authorize WHERE type_id = ? AND user_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function delete($data)
  {
    $sql = "UPDATE leave_authorize SET
    status = 2,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_select($keyword)
  {
    $sql = "SELECT A.id as user_id, CONCAT('คุณ',A.name,' ',A.surname) as user_name
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id 
    WHERE B.status = 1";
    if ($keyword) {
      $sql .= " AND (A.name LIKE '%{$keyword}%' OR A.surname LIKE '%{$keyword}%')";
    }
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}