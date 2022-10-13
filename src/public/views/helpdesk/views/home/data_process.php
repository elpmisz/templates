<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM helpdesk_request WHERE status = 1");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["A.id", "A.id", "A.name", "A.email", "B.level", "B.status"];

$status = (isset($_POST['status']) ? intval($_POST['status']) : "");

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : "");
$order = (isset($_POST['order']) ? $_POST['order'] : "");
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
$limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
$limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
$draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

$sql = "SELECT A.id AS request_id,A.text,B.name as service_name,
CONCAT('HD',YEAR(NOW()),LPAD(A.last, GREATEST(LENGTH(A.last), 4), '0')) AS gen_id,
DATE_FORMAT(A.created, '%d/%m/%Y, %H:%i น.') as created,
IF(A.user_id = '',NULL,CONCAT('คุณ',D.name,' ',D.surname)) as requset_user,
IF(C.user_id = '',NULL,CONCAT('คุณ',E.name,' ',E.surname)) as process_user,
IF(C.end = '',NULL,DATE_FORMAT(C.end, '%d/%m/%Y')) as end,
CASE
  WHEN A.status = 1 THEN 'danger'
  WHEN A.status = 2 THEN 'warning'
  WHEN A.status = 3 THEN 'primary'
  WHEN A.status = 4 THEN 'primary'
  WHEN A.status = 5 THEN 'danger'
  WHEN A.status = 6 THEN 'success'
  WHEN A.status = 7 THEN 'danger'
  ELSE NULL
END AS status_color,
CASE
  WHEN A.status = 1 THEN 'รออนุมัติ'
  WHEN A.status = 2 THEN 'รอรับเรื่อง'
  WHEN A.status = 3 THEN 'กำลังดำเนินการ'
  WHEN A.status = 4 THEN 'รออุปกรณ์ / อะไหล่'
  WHEN A.status = 5 THEN 'รอตรวจสอบ'
  WHEN A.status = 6 THEN 'ดำเนินการเรียบร้อย'
  WHEN A.status = 7 THEN 'รายการยกเลิก'
  ELSE NULL
END AS status_name
FROM helpdesk_request A
LEFT JOIN helpdesk_services B
ON A.sub_id = B.id
LEFT JOIN helpdesk_process C
ON A.id = C.request_id
LEFT JOIN user_detail D
ON A.user_id = D.id
LEFT JOIN user_detail E
ON C.user_id = E.id
WHERE A.status IN (2,3,4) ";

if ($keyword) {
  $sql .= " AND (A.text LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.id DESC ";
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
  $status = "<a href='/helpdesk/process/{$row['request_id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  $data[] = [
    "0" => $status,
    "1" => $row['gen_id'],
    "2" => $row['text'],
    "3" => $row['service_name'],
    "4" => $row['requset_user'],
    "5" => $row['created'],
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);
