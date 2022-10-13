<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM user_detail");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["A.status", "A.id", "A.name", "A.email", "B.level"];

$status = (isset($_POST['status']) ? intval($_POST['status']) : "");

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : "");
$order = (isset($_POST['order']) ? $_POST['order'] : "");
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
$limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
$limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
$draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

$sql = "SELECT A.id as user_id,A.email,A.picture,
IF(A.name = '', '', CONCAT('คุณ',A.name,' ',A.surname)) as fullname,
IF(B.level = 9,'ผู้ดูแลระบบ','ผู้ใช้งาน') as level_name,B.level as level_id,
IF(B.level = 1,'primary','success') as level_color,
IF(B.status = 1,'รายละเอียด','ระงับการใช้งาน') as status_name,B.status as status_id,
IF(B.status = 1,'success','danger') as status_color
FROM user_detail A
LEFT JOIN user_login B
ON A.id = B.user_id ";

if ($status === 2) {
  $sql .= " WHERE B.level = 9 ";
} elseif ($status === 3) {
  $sql .= " WHERE B.level = 1 ";
} elseif ($status === 4) {
  $sql .= " WHERE B.status = 2 ";
} else {
  $sql .= " WHERE A.id != '' ";
}

if ($keyword) {
  $sql .= " AND (A.name LIKE '%{$keyword}%' OR A.surname LIKE '%{$keyword}%' OR A.email LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY B.status ASC, A.id ASC ";
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
  $level = "<span class='badge text-bg-{$row['level_color']} fw-lighter'>{$row['level_name']}</span>";
  $status = "<a href='/users/view/{$row['user_id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  if (!empty($row['picture'])) :
    $image = "<img src='/assets/img/profile/{$row['picture']}' class='img-fluid img-profile mx-auto d-block shadow'>";
  else :
    $image = "<img src='/assets/img/profile/no-img.png' class='img-fluid img-profile mx-auto d-block shadow'>";
  endif;
  $data[] = [
    "0" => $status,
    "1" => $image,
    "2" => $row['fullname'],
    "3" => $row['email'],
    "4" => $level,
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);
