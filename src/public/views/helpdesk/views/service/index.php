<?php
$page = "helpdesk";
$group = "service";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">จัดการประเภทบริการ</h4>
        </div>
        <div class="card-body">
          <div class="row my-3">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>
            <div class="col-xl-3 col-md-6 offset-xl-3 mb-2">
              <select class="form-select form-select-sm topic" data-placeholder="-- หัวข้อ --"></select>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
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
                      <th width="20%">ชื่อ</th>
                      <th width="20%">หัวข้ออ้างอิง</th>
                      <th width="30%">คำแนะนำ</th>
                      <th width="10%">ระยะเวลา (วัน)</th>
                      <th width="10%">การอนุมัติ</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="row justify-content-center my-3">
      <div class="col-xl-3 col-md-6 mb-2">
        <a href="/helpdesk/manage" class="btn btn-danger btn-sm w-100">
          <i class="fa fa-arrow-left pe-2"></i>กลับหน้าจัดการ
        </a>
      </div>
    </div>
  </div>
</main>

<div class="modal fade form_add" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header mx-auto">
        <h5 class="modal-title">เพิ่ม</h5>
      </div>
      <div class="modal-body">
        <form action="/helpdesk/service/add" method="POST" class="needs-validation" novalidate>
          <div class="row">
            <div class="col-sm-12">
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">บริการ</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control form-control-sm" name="name" required>
                  <div class="invalid-feedback">
                    กรุณากรอก ข้อมูล.
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หัวข้อ</label>
                <div class="col-xl-8 col-md-8">
                  <div class="form-check form-check-inline pt-2">
                    <input class="form-check-input type" type="radio" name="type" id="topic" value="1">
                    <label class="form-check-label text-primary" for="topic">หลัก</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input type" type="radio" name="type" id="sub" value="2">
                    <label class="form-check-label text-success" for="sub">ย่อย</label>
                  </div>
                </div>
              </div>

              <div class="div_sub">
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อ้างอิง</label>
                  <div class="col-xl-6 col-md-6">
                    <select class="form-select form-select-sm topic" name="topic" data-placeholder="-- หัวข้อ --"></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกข้อมูล.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">คำแนะนำ</label>
                  <div class="col-xl-8 col-md-8">
                    <textarea class="form-control form-control-sm" name="suggestion" rows="3"></textarea>
                    <div class="invalid-feedback">
                      กรุณากรอก ข้อมูล.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระยะเวลา (SLA)</label>
                  <div class="col-xl-4 col-md-4">
                    <div class="input-group input-group-sm mb-3">
                      <input type="number" class="form-control form-control-sm text-center" name="period">
                      <span class="input-group-text">วัน</span>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เลือกอุปกรณ์</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input" type="radio" name="hardware" id="hw-1" value="1">
                      <label class="form-check-label text-primary" for="hw-1">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="hardware" id="hw-2" value="2">
                      <label class="form-check-label text-success" for="hw-2">ไม่มี</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">การอนุมัติ</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input" type="radio" name="approve" id="ap-1" value="1">
                      <label class="form-check-label text-primary" for="ap-1">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="approve" id="ap-2" value="2">
                      <label class="form-check-label text-success" for="ap-2">ไม่มี</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปฏิทินเดี่ยว</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input" type="radio" name="calendar1" id="calendar-1" value="1">
                      <label class="form-check-label text-primary" for="calendar-1">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="calendar1" id="calendar-2" value="2">
                      <label class="form-check-label text-success" for="calendar-2">ไม่มี</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปฏิทินคู่</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input" type="radio" name="calendar2" id="calendar-3" value="1">
                      <label class="form-check-label text-primary" for="calendar-3">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="calendar2" id="calendar-4" value="2">
                      <label class="form-check-label text-success" for="calendar-4">ไม่มี</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายการตรวจสอบ</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input checklist" type="radio" name="checklist" id="checklist-1" value="1">
                      <label class="form-check-label text-primary" for="checklist-1">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input checklist" type="radio" name="checklist" id="checklist-2" value="2">
                      <label class="form-check-label text-success" for="checklist-2">ไม่มี</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-2 div_checklists">
                  <div class="col-sm-6 offset-sm-4">
                    <select class="form-select form-select-sm checklists" name="checklists[]" multiple></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกข้อมูล.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">การตรวจสอบ</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input" type="radio" name="checker" id="checker-1" value="1">
                      <label class="form-check-label text-primary" for="checker-1">มี</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="checker" id="checker-2" value="2">
                      <label class="form-check-label text-success" for="checker-2">ไม่มี</label>
                    </div>
                  </div>
                </div>
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
              <a href="javascript:void(0)" class="btn btn-danger btn-sm w-100" data-bs-dismiss="modal">
                <i class="fa fa-times pe-2"></i> ปิด
              </a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

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
      url: "/helpdesk/service/data",
      type: "POST",
    },
    columnDefs: [{
      targets: [0, 2, 4, 5],
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

  $(document).on("click", ".btn_add", function() {
    $(".form_add").modal("show");
  });

  $(".div_sub").hide();
  $(document).on("click", ".type", function() {
    let type = parseInt($(this).val());
    if (type === 2) {
      $(".div_sub").show();
      $(".topic").prop("required", true);
    } else {
      $(".div_sub").hide();
      $(".topic").prop("required", false);
    }
  });

  $(".topic").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/helpdesk/service/topic",
        method: 'POST',
        dataType: 'json',
        delay: 100,
        processResults: function(data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });
  });

  $(".checklists").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/helpdesk/checklist/topic",
        method: 'POST',
        dataType: 'json',
        delay: 100,
        processResults: function(data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });
  });

  $(".div_checklists").hide();
  $(document).on("click", ".checklist", function() {
    let checklist = parseInt($(this).val());
    if (checklist === 1) {
      $(".div_checklists").show();
      $(".checklists").prop("required", true);
    } else {
      $(".div_checklists").hide();
      $(".checklists").prop("required", false);
    }
  });

  $(document).on("hidden.bs.modal", ".form_add", function() {
    $(this).find("form").trigger("reset");
    $(this).find("select").empty();
  });
</script>