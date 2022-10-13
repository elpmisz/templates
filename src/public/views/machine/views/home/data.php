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

$column = ["A.id", "A.id", "A.name", "A.email", "B.level", "B.status"];

$status = (isset($_POST['status']) ? intval($_POST['status']) : "");

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : "");
$order = (isset($_POST['order']) ? $_POST['order'] : "");
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
$limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
$limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
$draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

$sql = "SELECT A.id as machine_id,A.name as machine_name,A.picture,A.status,
A.type_id,B.name as type_name,
A.location_id,C.name as location_name,
A.brand_id,D.name as brand_name,
A.model_id,E.name as model_name,
IF(A.status = 1,'รายละเอียด','ระงับการใช้งาน') as status_name,
IF(A.status = 1,'success','danger') as status_color
FROM machine_request A
LEFT JOIN machine_type B
ON A.type_id = B.id 
LEFT JOIN machine_location C
ON A.location_id = C.id
LEFT JOIN machine_brand D
ON A.brand_id = D.id
LEFT JOIN machine_brand E
ON A.model_id = E.id ";

if ($status === 2) {
  $sql .= " WHERE A.type_id IN (1) ";
} elseif ($status === 3) {
  $sql .= " WHERE A.type_id NOT IN (1) ";
} elseif ($status === 4) {
  $sql .= " WHERE B.status = 2 ";
} else {
  $sql .= " WHERE A.id != '' ";
}

if ($keyword) {
  $sql .= " AND (A.name LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.status ASC, A.id ASC ";
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

  $status = "<a href='/machine/view/{$row['machine_id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  if (!empty($row['picture'])) :
    $image = "<img src='/views/machine/assets/img/machine/{$row['picture']}' class='img-fluid img-computer mx-auto d-block shadow'>";
  else :
    $image = "<img src='/views/machine/assets/img/machine/no-img.png' class='img-fluid img-computer mx-auto d-block shadow'>";
  endif;
  $data[] = [
    "0" => $status,
    "1" => $image,
    "2" => $row['machine_name'],
    "3" => $row['type_name'],
    "4" => $row['location_name'],
    "5" => $row['brand_name'],
    "6" => $row['model_name'],
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);
