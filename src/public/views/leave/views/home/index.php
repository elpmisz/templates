<?php

use app\classes\Authorize;
use app\classes\Request;

$page = "leave";
$group = "users";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$Request = new Request();
$Authorize = new Authorize();

$approver = $Authorize->count([2, $user_id]);
$approve_count = $Request->approve_count();
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ประวัติการลา</h4>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>
            <?php if ($user['level'] === 9) : ?>
              <div class="col-xl-3 col-md-6 mb-2">
                <a href="/leave/manage" class="btn btn-primary btn-sm w-100">
                  <i class="fa fa-bars pe-2"></i>จัดการระบบ
                </a>
              </div>
            <?php endif; ?>

            <div class="col-xl-3 col-md-6">
              <select class="form-select form-select-sm filter_year" data-placeholder="-- เลือก --">
                <option value="">-- เลือก --</option>
                <?php
                $years = range(2022, date("Y"));
                foreach ($years as $year) {
                  echo "<option value='{$year}'>{$year}</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-xl-3 col-md-6 <?php echo ($user['level'] === 9 ? "" : "offset-xl-3") ?> mb-2">
              <a href="/leave/request" class="btn btn-danger btn-sm w-100">
                <i class="fa fa-plus pe-2"></i>ขอใช้บริการ
              </a>
            </div>
          </div>

          <div class="row justify-content-center my-3">
            <div class="col-xl-8">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm w-100 shadow">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="40%">ประเภทการลา <?php echo $user_id ?></th>
                      <th width="10%">สิทธิ์วันลา</th>
                      <th width="10%">สิทธิ์ที่ใช้</th>
                      <th width="10%">สิทธิ์คงเหลือ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $services = $Request->service_read();
                    foreach ($services as $key => $service) :
                      $key++;
                      $used = $Request->service_used([$user_id, $service['id'], date("Y")]);
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $key ?></td>
                        <td><?php echo $service['name'] ?></td>
                        <td class="text-center text-primary"><?php echo $service['day'] ?></td>
                        <td class="text-center text-danger"><?php echo $used ?></td>
                        <td class="text-center text-success"><?php echo ($service['day'] - $used) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <?php if ($approver > 0 && $approve_count > 0) : ?>
            <div class="card shadow mb-2">
              <div class="card-header">
                <h5 class="text-center">รายการที่รออนุมัติ</h5>
              </div>

              <div class="card-body">
                <div class="row my-3">
                  <div class="col-xl-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover table-sm approve w-100">
                        <thead>
                          <tr>
                            <th width="10%">#</th>
                            <th width="10%">ประเภท</th>
                            <th width="20%">วันที่ลา</th>
                            <th width="10%">จำนวนวันลา</th>
                            <th width="30%">เหตุผล</th>
                            <th width="20%">วันที่ใช้บริการ</th>
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
              <h5 class="text-center">รายการที่ใช้บริการ</h5>
            </div>

            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm data w-100">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="10%">ประเภท</th>
                          <th width="20%">วันที่ลา</th>
                          <th width="10%">จำนวนวันลา</th>
                          <th width="30%">เหตุผล</th>
                          <th width="20%">วันที่ใช้บริการ</th>
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
  $(".data").DataTable({
    serverSide: true,
    scrollX: true,
    searching: true,
    order: [],
    ajax: {
      url: "/leave/datarequest",
      type: "POST",
    },
    columnDefs: [{
      targets: [0, 1, 2, 3, 5],
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

  $(".approve").DataTable({
    serverSide: true,
    scrollX: true,
    searching: true,
    order: [],
    ajax: {
      url: "/leave/dataapprove",
      type: "POST",
    },
    columnDefs: [{
      targets: [0, 1, 2, 3, 5],
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

  $(".filter_year").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
    });
  });
</script>