<?php

namespace app\classes;

class Type
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function type_add($data)
  {
    $sql = "INSERT INTO machine_type(name,software) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function item_add($data)
  {
    $sql = "INSERT INTO machine_type_item(type_id,subject,type,text) VALUES(?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function type_fetch($data)
  {
    $sql = "SELECT * FROM machine_type WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function item_fetch_id($data)
  {
    $sql = "SELECT * FROM machine_type_item WHERE type_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchAll();
  }

  public function type_update($data)
  {
    $sql = "UPDATE machine_type SET
    name = ?,
    software = ?,
    status = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function item_update($data)
  {
    $sql = "UPDATE machine_type_item SET
    subject = ?,
    type = ?,
    text = ?
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function item_delete($data)
  {
    $sql = "UPDATE machine_type_item SET
    status = 2,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function last_insert_id()
  {
    return $this->dbcon->lastInsertId();
  }
}
