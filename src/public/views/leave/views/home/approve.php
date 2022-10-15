<?php

use app\classes\Request;

use function Complex\ln;

$page = "leave";
$group = "users";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : "");
$request = (isset($param[0]) ? $param[0] : "");

$Request = new Request();
$row = $Request->fetch([$request]);
$remain = $Request->service_remain([$row['service_id']], [$row['user_id'], $row['service_id'], date("Y")]);
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">รายละเอียด</h4>
        </div>
        <div class="card-body">
          <form action="/leave/request/approve" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="request" value="<?php echo $row['id'] ?>" readonly>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ประเภทการลา</label>
              <div class="col-xl-4 col-md-6">
                <input type="hidden" class="form-control form-control-sm service" value="<?php echo $row['service_id'] ?>" readonly>
                <span class="form-control form-control-sm"><?php echo $row['service_name'] ?></span>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่ลา</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" value="<?php echo $row['date'] ?>" readonly>
                <div class="invalid-feedback">
                  กรุณาเลือก วันที่.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สิทธิ์การลา (คงเหลือ)</label>
              <div class="col-xl-2 col-md-4">
                <div class="input-group input-group-sm mb-3">
                  <input type="number" class="form-control form-control-sm text-center used" value="<?php echo $remain ?>" readonly>
                  <span class="input-group-text">วัน</span>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระยะเวลา</label>
              <div class="col-xl-2 col-md-4">
                <div class="input-group input-group-sm mb-3">
                  <input type="number" class="form-control form-control-sm text-center calc" value="<?php echo $row['diff'] ?>" readonly>
                  <span class="input-group-text">วัน</span>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เหตุผลการลา</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" readonly><?php echo $row['text'] ?></textarea>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ไฟล์แนบ</label>
              <div class="col-xl-4 col-md-6">
                <table class="table table-sm"></table>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end"></label>
              <div class="col-sm-6">
                <span class="text-danger">กรุณาเลือกผลการอนุมัติ</span>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานะ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="status" id="active" value="2" required>
                  <label class="form-check-label text-success" for="active">
                    <i class="fa fa-check-circle pe-2"></i>ผ่านอนุมัติ
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="inactive" value="3" required>
                  <label class="form-check-label text-danger" for="inactive">
                    <i class="fa fa-times-circle pe-2"></i>ไม่ผ่านอนุมัติ
                  </label>
                </div>
              </div>
            </div>
            <div class="row div_remark mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เหตุผล</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" name="remark"></textarea>
                <div class="invalid-feedback">
                  กรุณาระบุเหตุผล
                </div>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-xl-4 col-md-6 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100 btn_submit">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-4 col-md-6 mb-2">
                <a href="/leave" class="btn btn-danger btn-sm w-100">
                  <i class="fa fa-arrow-left pe-2"></i>กลับหน้าหลัก
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../../../includes/footer.php");
?>
<script>
  $(".div_remark").hide();
  $(document).on("click", "input[name='status']", function() {
    let status = parseInt($(this).val());
    if (status === 3) {
      $(".div_remark").show();
      $("textarea[name='remark']").prop("required", true);
    } else {
      $(".div_remark").hide();
      $("textarea[name='remark']").prop("required", false);
    }
  });
</script>