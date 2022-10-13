<?php

namespace app\classes;

class Service
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO leave_service(name,day) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function count($data)
  {
    $sql = "SELECT COUNT(*) FROM leave_service WHERE name = ? AND day = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function update($data)
  {
    $sql = "UPDATE leave_service SET
    name = ?,
    day = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function fetch($data)
  {
    $sql = "SELECT * FROM leave_service WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }
}