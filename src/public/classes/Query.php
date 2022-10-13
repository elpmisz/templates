<?php

namespace app\classes;

class Query
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function helpdesk_approve_auth($data)
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_authorize WHERE type_id = 2 AND user_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function helpdesk_approve_count()
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function helpdesk_process_auth($data)
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_authorize WHERE type_id = 1 AND user_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function helpdesk_process_count()
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE status IN (2,3,4)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function helpdesk_check_auth($data)
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_authorize WHERE type_id = 3 AND user_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function helpdesk_check_count()
  {
    $sql = "SELECT COUNT(*) FROM helpdesk_request WHERE status = 5";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}
