<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM machine_request");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["A.status", "A.service_id", "A.start", "A.id", "A.text", "A.created"];

$year = (isset($_POST['year']) ? intval($_POST['year']) : date("Y"));

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : "");
$order = (isset($_POST['order']) ? $_POST['order'] : "");
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
$limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
$limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
$draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

$sql = "SELECT A.id as request_id,A.date as request_date,A.text as request_text, DATEDIFF(A.end, A.start) + 1 as diff,
B.name as service_name,
CONCAT('คุณ',C.name,' ',C.surname) as user_name,
DATE_FORMAT(A.created, '%d/%m/%Y - %H:%i น.') as request_created,
CASE A.status 
  WHEN 1 THEN 'รออนุมัติ'
  WHEN 2 THEN 'ผ่านการอนุมัติ'
  WHEN 3 THEN 'รายการถูกยกเลิก'
  ELSE NULL
END AS status_name,
CASE A.status 
  WHEN 1 THEN 'warning'
  WHEN 2 THEN 'success'
  WHEN 3 THEN 'danger'
  ELSE NULL
END AS status_color
FROM leave_request A
LEFT JOIN leave_service B
ON A.service_id = B.id
LEFT JOIN user_detail C
ON A.user_id = C.id
WHERE A.status = 1 ";

if ($keyword) {
  $sql .= " AND (A.text LIKE '%{$keyword}%') ";
}

if ($year) {
  $sql .= " AND YEAR(A.created) = {$year} ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.status ASC ";
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
  $status = "<a href='/leave/approve/{$row['request_id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  $data[] = [
    "0" => $status,
    "1" => $row['service_name'],
    "2" => $row['request_date'],
    "3" => $row['diff'],
    "4" => $row['request_text'],
    "5" => $row['request_created'],
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);