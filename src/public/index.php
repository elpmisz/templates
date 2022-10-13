<?php
require_once(__DIR__ . "/vendor/autoload.php");
$Router = new AltoRouter();

$Router->map("GET", "/", function () {
  require(__DIR__ . "/views/home/login.php");
});
$Router->map("GET", "/home", function () {
  require(__DIR__ . "/views/home/index.php");
});
$Router->map("GET", "/error", function () {
  require(__DIR__ . "/views/home/error.php");
});
$Router->map("GET", "/login", function () {
  require(__DIR__ . "/views/home/login.php");
});
$Router->map("GET", "/register", function () {
  require(__DIR__ . "/views/home/register.php");
});
$Router->map("GET", "/forget", function () {
  require(__DIR__ . "/views/home/forget.php");
});
$Router->map("GET", "/logout", function () {
  require(__DIR__ . "/views/home/logout.php");
});
$Router->map("POST", "/auth/[**:params]", function ($params) {
  require(__DIR__ . "/views/home/action.php");
});

$Router->map("GET", "/system", function () {
  require(__DIR__ . "/views/systems/index.php");
});
$Router->map("POST", "/system/[**:params]", function ($params) {
  require(__DIR__ . "/views/systems/action.php");
});

$Router->map("GET", "/users", function () {
  require(__DIR__ . "/views/users/index.php");
});
$Router->map("POST", "/users/data", function () {
  require(__DIR__ . "/views/users/data.php");
});
$Router->map("GET", "/users/profile", function () {
  require(__DIR__ . "/views/users/profile.php");
});
$Router->map("GET", "/users/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/users/view.php");
});
$Router->map("POST", "/users/[**:params]", function ($params) {
  require(__DIR__ . "/views/users/action.php");
});

$Router->map("GET", "/machine/software", function () {
  require(__DIR__ . "/views/machine/views/software/index.php");
});
$Router->map("POST", "/machine/software/data", function () {
  require(__DIR__ . "/views/machine/views/software/data.php");
});
$Router->map("POST", "/machine/software/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/software/action.php");
});

$Router->map("GET", "/machine/location", function () {
  require(__DIR__ . "/views/machine/views/location/index.php");
});
$Router->map("POST", "/machine/location/data", function () {
  require(__DIR__ . "/views/machine/views/location/data.php");
});
$Router->map("POST", "/machine/location/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/location/action.php");
});

$Router->map("GET", "/machine/type", function () {
  require(__DIR__ . "/views/machine/views/type/index.php");
});
$Router->map("POST", "/machine/type/data", function () {
  require(__DIR__ . "/views/machine/views/type/data.php");
});
$Router->map("GET", "/machine/type/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/type/view.php");
});
$Router->map("POST", "/machine/type/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/type/action.php");
});
$Router->map("GET", "/machine/type/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/type/action.php");
});

$Router->map("GET", "/machine/brand", function () {
  require(__DIR__ . "/views/machine/views/brand/index.php");
});
$Router->map("POST", "/machine/brand/data", function () {
  require(__DIR__ . "/views/machine/views/brand/data.php");
});
$Router->map("POST", "/machine/brand/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/brand/action.php");
});

$Router->map("GET", "/machine", function () {
  require(__DIR__ . "/views/machine/views/home/index.php");
});
$Router->map("GET", "/machine/request", function () {
  require(__DIR__ . "/views/machine/views/home/request.php");
});
$Router->map("POST", "/machine/data", function () {
  require(__DIR__ . "/views/machine/views/home/data.php");
});
$Router->map("GET", "/machine/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/home/view.php");
});
$Router->map("POST", "/machine/[**:params]", function ($params) {
  require(__DIR__ . "/views/machine/views/home/action.php");
});

$Router->map("GET", "/helpdesk/authorize", function () {
  require(__DIR__ . "/views/helpdesk/views/authorize/index.php");
});
$Router->map("POST", "/helpdesk/authorize/data", function () {
  require(__DIR__ . "/views/helpdesk/views/authorize/data.php");
});
$Router->map("POST", "/helpdesk/authorize/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/authorize/action.php");
});
$Router->map("GET", "/helpdesk/authorize/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/authorize/action.php");
});

$Router->map("GET", "/helpdesk/service", function () {
  require(__DIR__ . "/views/helpdesk/views/service/index.php");
});
$Router->map("POST", "/helpdesk/service/data", function () {
  require(__DIR__ . "/views/helpdesk/views/service/data.php");
});
$Router->map("GET", "/helpdesk/service/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/service/view.php");
});
$Router->map("POST", "/helpdesk/service/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/service/action.php");
});

$Router->map("GET", "/helpdesk/checklist", function () {
  require(__DIR__ . "/views/helpdesk/views/checklist/index.php");
});
$Router->map("POST", "/helpdesk/checklist/data", function () {
  require(__DIR__ . "/views/helpdesk/views/checklist/data.php");
});
$Router->map("POST", "/helpdesk/checklist/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/checklist/action.php");
});

$Router->map("GET", "/helpdesk", function () {
  require(__DIR__ . "/views/helpdesk/views/home/index.php");
});
$Router->map("POST", "/helpdesk/datarequest", function () {
  require(__DIR__ . "/views/helpdesk/views/home/data_request.php");
});
$Router->map("POST", "/helpdesk/dataapprove", function () {
  require(__DIR__ . "/views/helpdesk/views/home/data_approve.php");
});
$Router->map("POST", "/helpdesk/dataprocess", function () {
  require(__DIR__ . "/views/helpdesk/views/home/data_process.php");
});
$Router->map("POST", "/helpdesk/datamanage", function () {
  require(__DIR__ . "/views/helpdesk/views/home/data_manage.php");
});
$Router->map("GET", "/helpdesk/manage", function () {
  require(__DIR__ . "/views/helpdesk/views/home/manage.php");
});
$Router->map("GET", "/helpdesk/request", function () {
  require(__DIR__ . "/views/helpdesk/views/home/request.php");
});
$Router->map("GET", "/helpdesk/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/home/view.php");
});
$Router->map("GET", "/helpdesk/approve/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/home/approve.php");
});
$Router->map("GET", "/helpdesk/process/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/home/process.php");
});
$Router->map("GET", "/helpdesk/complete/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/home/complete.php");
});
$Router->map("POST", "/helpdesk/request/[**:params]", function ($params) {
  require(__DIR__ . "/views/helpdesk/views/home/action.php");
});

$Router->map("GET", "/leave/authorize", function () {
  require(__DIR__ . "/views/leave/views/authorize/index.php");
});
$Router->map("POST", "/leave/authorize/data", function () {
  require(__DIR__ . "/views/leave/views/authorize/data.php");
});
$Router->map("POST", "/leave/authorize/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/authorize/action.php");
});
$Router->map("GET", "/leave/authorize/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/authorize/action.php");
});

$Router->map("GET", "/leave/service", function () {
  require(__DIR__ . "/views/leave/views/service/index.php");
});
$Router->map("POST", "/leave/service/data", function () {
  require(__DIR__ . "/views/leave/views/service/data.php");
});
$Router->map("POST", "/leave/service/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/service/action.php");
});

$Router->map("GET", "/leave", function () {
  require(__DIR__ . "/views/leave/views/home/index.php");
});
$Router->map("POST", "/leave/datarequest", function () {
  require(__DIR__ . "/views/leave/views/home/data_request.php");
});
$Router->map("POST", "/leave/dataapprove", function () {
  require(__DIR__ . "/views/leave/views/home/data_approve.php");
});
$Router->map("GET", "/leave/manage", function () {
  require(__DIR__ . "/views/leave/views/home/manage.php");
});
$Router->map("GET", "/leave/request", function () {
  require(__DIR__ . "/views/leave/views/home/request.php");
});
$Router->map("GET", "/leave/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/home/view.php");
});
$Router->map("GET", "/leave/approve/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/home/approve.php");
});
$Router->map("GET", "/leave/complete/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/home/complete.php");
});
$Router->map("POST", "/leave/request/[**:params]", function ($params) {
  require(__DIR__ . "/views/leave/views/home/action.php");
});

$match = $Router->match();

if (is_array($match) && is_callable($match['target'])) {
  call_user_func_array($match['target'], $match['params']);
} else {
  header("HTTP/1.1 404 Not Found");
  require __DIR__ . "/views/home/error.php";
}