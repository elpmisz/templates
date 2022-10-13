<?php

$page = "users";
$group = "system";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");

$count = $Users->user_count();

if ($user['level'] === 1) {
  header("Location: /error");
}
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ข้อมูลผู้ใช้งาน</h4>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-success shadow py-2 count" id="1">
                <div class="card-body">
                  <h3 class="text-end"><?php echo $count['total'] ?></h3>
                  <h5 class="text-end">ผู้ใช้งานทั้งหมด</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-warning shadow py-2 count" id="2">
                <div class="card-body">
                  <h3 class="text-end"><?php echo $count['admin_active'] ?></h3>
                  <h5 class="text-end">ผู้ดูแลระบบ</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-primary shadow py-2 count" id="3">
                <div class="card-body">
                  <h3 class="text-end"><?php echo $count['user_active'] ?></h3>
                  <h5 class="text-end">ผู้ใช้งานทั่วไป</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-danger shadow py-2 count" id="4">
                <div class="card-body">
                  <h3 class="text-end"><?php echo "{$count['inactive']} / {$count['total']}" ?></h3>
                  <h5 class="text-end">ระงับใช้งาน</h5>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>

            <div class="col-xl-3 col-md-6 offset-xl-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-danger btn-sm w-100 btn_add">
                <i class="fa fa-plus pe-2"></i>เพิ่ม
              </a>
            </div>
          </div>

          <div class="row my-3">
            <div class="col-xl-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm data w-100">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="10%">รูป</th>
                      <th width="20%">ชื่อ - นามสกุล</th>
                      <th width="20%">อีเมล</th>
                      <th width="10%">สิทธิ์</th>
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
</main>

<div class="modal fade form_add" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto">เพิ่ม</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="/users/add" method="POST" class="needs-validation" novalidate>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อีเมล</label>
              <div class="col-xl-4 col-md-6">
                <input type="email" class="form-control form-control-sm" name="email" required>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่อ - นามสกุล</label>
              <div class="col-xl-8 col-md-8">
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm" name="name" required>
                  <input type="text" class="form-control form-control-sm" name="surname" required>
                  <div class="invalid-feedback">
                    กรุณากรอกช่องนี้.
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระดับ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input level" type="radio" name="level" id="user" value="1">
                  <label class="form-check-label" for="user">
                    <i class="fa fa-user pe-2"></i>ผู้ใช้งาน
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input level" type="radio" name="level" id="admin" value="9">
                  <label class="form-check-label" for="admin">
                    <i class="fa fa-user-secret pe-2"></i>ผู้ดูแลระบบ
                  </label>
                </div>
              </div>
            </div>

            <div class="row justify-content-center mb-2">
              <div class="col-xl-3 col-md-6 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fa fa-check pe-2"></i> ยืนยัน
                </button>
              </div>
              <div class="col-xl-3 col-md-6 mb-2">
                <a href="javascript:void(0)" class="btn btn-danger btn-sm w-100 btn_close" data-bs-dismiss="modal">
                  <i class="fa fa-times pe-2"></i> ปิด
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>
<script>
  filter_data();

  function filter_data(status) {
    let data = $(".data").DataTable({
      serverSide: true,
      scrollX: true,
      searching: true,
      order: [],
      ajax: {
        url: "/users/data",
        type: "POST",
        data: {
          status: status
        }
      },
      columnDefs: [{
        targets: [0, 4],
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
  }

  $(document).on("click", ".count", function() {
    let status = $(this).prop("id");
    if (status) {
      $(".data").DataTable().destroy();
      filter_data(status);
    } else {
      $(".data").DataTable().destroy();
      filter_data();
    }
  })

  $(document).on("click", ".btn_add", function() {
    $(".form_add").modal("show");
    $(".level").prop("required", true);
  });

  $(document).on("hidden.bs.modal", ".form_add", function() {
    $(this).find("form").trigger("reset");
    $(this).find("select").empty();
  });
</script>