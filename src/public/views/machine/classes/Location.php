<?php

namespace app\classes;

class Location
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function add($data)
  {
    $sql = "INSERT INTO machine_location(name) VALUES(?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function fetch($data)
  {
    $sql = "SELECT * FROM machine_location WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function update($data)
  {
    $sql = "UPDATE machine_location SET
    name = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }
}
