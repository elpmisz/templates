<?php

use app\classes\Authorize;
use app\classes\Request;

$page = "helpdesk";
$group = "service";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$Request = new Request();
$Authorize = new Authorize();

$process = $Authorize->count([1, $user_id]);
$approve = $Authorize->count([2, $user_id]);
$checker = $Authorize->count([3, $user_id]);
$approve_count = $Request->approve_count();
$process_count = $Request->process_count();
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ระบบแจ้งปัญหาการใช้งาน</h4>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>
            <?php if ($user['level'] === 9 || $process > 0) : ?>
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="/helpdesk/manage" class="btn btn-primary btn-sm w-100">
                <i class="fa fa-bars pe-2"></i>จัดการระบบ
              </a>
            </div>
            <?php endif; ?>

            <div
              class="col-xl-3 col-md-6 <?php echo ($user['level'] === 9 || $process > 0 ? "offset-xl-3" : "offset-xl-6") ?> mb-2">
              <a href="/helpdesk/request" class="btn btn-danger btn-sm w-100">
                <i class="fa fa-plus pe-2"></i>ขอใช้บริการ
              </a>
            </div>
          </div>

          <?php if (($approve > 0 || $checker > 0) && $approve_count > 0) : ?>
          <div class="card shadow mb-2">
            <div class="card-header">
              <h5 class="text-center">รายการรออนุมัติ</h5>
            </div>

            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm w-100 approve">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="10%">รหัส</th>
                          <th width="20%">รายละเอียด</th>
                          <th width="10%">บริการ</th>
                          <th width="10%">ผู้ใช้บริการ</th>
                          <th width="10%">วันที่แจ้ง</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if ($process > 0 && $process_count > 0) : ?>
          <div class="card shadow mb-2">
            <div class="card-header">
              <h5 class="text-center">รายการกำลังดำเนินการ</h5>
            </div>

            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm w-100 process">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="10%">รหัส</th>
                          <th width="20%">รายละเอียด</th>
                          <th width="10%">บริการ</th>
                          <th width="10%">ผู้ใช้บริการ</th>
                          <th width="10%">วันที่แจ้ง</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <div class="card shadow mb-2">
            <div class="card-header">
              <h5 class="text-center">รายการแจ้งปัญหาการใช้งาน</h5>
            </div>
            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm w-100 request">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="10%">รหัส</th>
                          <th width="20%">รายละเอียด</th>
                          <th width="10%">บริการ</th>
                          <th width="10%">วันที่แจ้ง</th>
                          <th width="10%">กำหนดเสร็จ</th>
                          <th width="10%">ผู้รับผิดชอบ</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../../../includes/footer.php");
?>
<script>
$(".approve").DataTable({
  serverSide: true,
  scrollX: true,
  searching: true,
  order: [],
  ajax: {
    url: "/helpdesk/dataapprove",
    type: "POST",
  },
  columnDefs: [{
    targets: [0, 1, 3, 4, 5],
    className: "text-center",
  }],
  oLanguage: {
    sLengthMenu: "แสดง _MENU_ ลำดับ ต่อหน้า",
    sZeroRecords: "ไม่พบข้อมูลที่ค้นหา",
    sInfo: "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
    sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 ลำดับ",
    sInfoFiltered: "(จากทั้งหมด _MAX_ ลำดับ)",
    sSearch: "ค้นหา :",
    oPaginate: {
      sFirst: "หน้าแรก",
      sLast: "หน้าสุดท้าย",
      sNext: "ถัดไป",
      sPrevious: "ก่อนหน้า"
    }
  }
});

$(".process").DataTable({
  serverSide: true,
  scrollX: true,
  searching: true,
  order: [],
  ajax: {
    url: "/helpdesk/dataprocess",
    type: "POST",
  },
  columnDefs: [{
    targets: [0, 1, 3, 4, 5],
    className: "text-center",
  }],
  oLanguage: {
    sLengthMenu: "แสดง _MENU_ ลำดับ ต่อหน้า",
    sZeroRecords: "ไม่พบข้อมูลที่ค้นหา",
    sInfo: "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
    sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 ลำดับ",
    sInfoFiltered: "(จากทั้งหมด _MAX_ ลำดับ)",
    sSearch: "ค้นหา :",
    oPaginate: {
      sFirst: "หน้าแรก",
      sLast: "หน้าสุดท้าย",
      sNext: "ถัดไป",
      sPrevious: "ก่อนหน้า"
    }
  }
});

$(".request").DataTable({
  serverSide: true,
  scrollX: true,
  searching: true,
  order: [],
  ajax: {
    url: "/helpdesk/datarequest",
    type: "POST",
  },
  columnDefs: [{
    targets: [0, 1, 3, 4, 5],
    className: "text-center",
  }],
  oLanguage: {
    sLengthMenu: "แสดง _MENU_ ลำดับ ต่อหน้า",
    sZeroRecords: "ไม่พบข้อมูลที่ค้นหา",
    sInfo: "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
    sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 ลำดับ",
    sInfoFiltered: "(จากทั้งหมด _MAX_ ลำดับ)",
    sSearch: "ค้นหา :",
    oPaginate: {
      sFirst: "หน้าแรก",
      sLast: "หน้าสุดท้าย",
      sNext: "ถัดไป",
      sPrevious: "ก่อนหน้า"
    }
  }
});
</script>