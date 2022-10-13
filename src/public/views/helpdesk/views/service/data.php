<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM helpdesk_services");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["id", "name"];

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : '');
$order = (isset($_POST['order']) ? $_POST['order'] : '');
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
$limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
$limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
$draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

$sql = "SELECT A.id,A.name,A.suggestion,
IF(A.period = 0,'-',A.period) as period,
IF(A.topic_id = 0,'-',B.name) as topic_name,
IF(A.status = 1,'รายละเอียด','ระงับการใช้งาน') as status_name,
IF(A.status = 1,'primary','danger') as status_color,
IF(A.approve = 1,'fa-check-circle text-success','') as approve
FROM helpdesk_services A
LEFT JOIN helpdesk_services B
ON A.topic_id = B.id
WHERE A.id != '' ";

if ($keyword) {
  $sql .= " AND (A.name LIKE '%{$keyword}%' OR B.name LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.id ASC ";
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
  $action = "<a href='/helpdesk/service/view/{$row['id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  $data[] = [
    "0" => $action,
    "1" => $row['name'],
    "2" => $row['topic_name'],
    "3" => $row['suggestion'],
    "4" => $row['period'],
    "5" => "<i class='fa {$row['approve']}'></i>",
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);
