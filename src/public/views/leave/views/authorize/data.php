<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM leave_authorize WHERE status = 1");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["id", "type_id", "user_id"];

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : '');
$order = (isset($_POST['order']) ? $_POST['order'] : '');
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
$limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
$limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
$draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

$sql = "SELECT A.id,CONCAT('คุณ',B.name,' ',B.surname) as username,
CASE type_id
  WHEN 1 THEN 'ผู้จัดการระบบ'
  WHEN 2 THEN 'ผู้อนุมัติ'
  WHEN 3 THEN 'ผู้ตรวจสอบ'
  ELSE NULL
END as type_name
FROM leave_authorize A
LEFT JOIN user_detail B
ON A.user_id = B.id
WHERE A.status = 1 ";

if ($keyword) {
  $sql .= " AND (B.name LIKE '%{$keyword}%' OR B.surname LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.type_id ASC, A.id ASC ";
}

$query = "";
if (!empty($limit_length)) {
  $query .= "LIMIT {$limit_start}, {$limit_length}";
}

$stmt = $dbcon->prepare($sql);
$stmt->execute();
$filter = $stmt->rowCount();
$stmt = $dbcon->prepare($sql . $query);
$stmt->execute();
$result = $stmt->fetchAll();

$data = [];
foreach ($result as $row) {
  $action = "<a href='javascript:void(0)' class='badge text-bg-danger fw-lighter btn_delete' id='{$row['id']}'>ลบ</a>";
  $data[] = [
    "0" => $action,
    "1" => $row['type_name'],
    "2" => $row['username'],
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);