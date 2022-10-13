<?php

use app\classes\Request;

$page = "helpdesk";
$group = "service";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : "");
$request_id = (isset($param[0]) ? $param[0] : "");

$Request = new Request();
$row = $Request->request_fetch([$request_id]);
$uploads = $Request->upload_fetch([$request_id]);
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
          <form action="/helpdesk/request/approve" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row">
              <div class="col-xl-6">
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หัวข้อบริการ</label>
                  <div class="col-xl-8 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['service_name'] ?></span>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปัญหาที่พบ</label>
                  <div class="col-xl-8 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['sub_name'] ?></span>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ผู้ใช้บริการ</label>
                  <div class="col-xl-8 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['user_name'] ?></span>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เบอร์ติดต่อ</label>
                  <div class="col-xl-8 col-md-6">
                    <span class="form-control form-control-sm"><?php echo $row['contact'] ?></span>
                  </div>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="row mb-2" style="display: none;">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
                  <div class="col-xl-8 col-md-8">
                    <input type="text" class="form-control form-control-sm" name="request_id" value="<?php echo $row['request_id'] ?>" readonly>
                  </div>
                </div>

                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">Ticket ID</label>
                  <div class="col-xl-8 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['gen_id'] ?></span>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                  <div class="col-xl-8 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['created'] ?></span>
                  </div>
                </div>
              </div>
            </div>

            <?php if ($row['hardware'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อุปกรณ์</label>
                <div class="col-xl-6 col-md-8">
                  <span class="form-control form-control-sm"><?php echo $row['hardware_name'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['calendar1'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                <div class="col-xl-3 col-md-6">
                  <span class="form-control form-control-sm"><?php echo $row['date1'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['calendar2'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                <div class="col-xl-5 col-md-7">
                  <span class="form-control form-control-sm"><?php echo $row['date2'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียด</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" readonly><?php echo $row['text'] ?></textarea>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ไฟล์แนบ</label>
              <div class="col-xl-8 col-md-8">
                <table class="table table-sm">
                  <tbody>
                    <?php foreach ($uploads as $key => $upload) : $key++; ?>
                      <tr>
                        <td>
                          <a href="/views/helpdesk/assets/upload/<?php echo $upload['name'] ?>" target="_blank">
                            <?php echo $row['gen_id'] . "_" . $key ?>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
                  <input class="form-check-input" type="radio" name="status" id="inactive" value="7" required>
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
              <div class="col-xl-4 col-md-4 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-4 col-md-4 mb-2">
                <a href="/helpdesk" class="btn btn-danger btn-sm w-100">
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
    if (status === 7) {
      $(".div_remark").show();
      $("textarea[name='remark']").prop("required", true);
    } else {
      $(".div_remark").hide();
      $("textarea[name='remark']").prop("required", false);
    }
  });
</script>