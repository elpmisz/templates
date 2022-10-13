<?php

namespace app\classes;

class System
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function fetch()
  {
    $sql = "SELECT * FROM system WHERE id = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function update($data)
  {
    $sql = "UPDATE system SET
    company = ?,
    email_name = ?,
    email_username = ?,
    email_password = ?,
    default_password = ?,
    user_id = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }
}
