<?php

$page = "leave";
$group = "users";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">จัดการระบบลา</h4>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="/leave/authorize" class="btn btn-warning btn-sm w-100">
                <i class="fa fa-file-alt pe-2"></i>สิทธิ์
              </a>
            </div>
            <div class="col-xl-3 col-md-6 offset-xl-3 mb-2">
              <a href="/leave/service" class="btn btn-danger btn-sm w-100">
                <i class="fa fa-file-alt pe-2"></i>ประเภทการลา
              </a>
            </div>
          </div>

          <div class="row my-3">
            <div class="col-xl-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm manage w-100">
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

      <div class="row justify-content-center my-3">
        <div class="col-xl-3 col-md-6 mb-2">
          <a href="/leave" class="btn btn-danger btn-sm w-100">
            <i class="fa fa-arrow-left pe-2"></i>กลับหน้าหลัก
          </a>
        </div>
      </div>

    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../../../includes/footer.php");
?>