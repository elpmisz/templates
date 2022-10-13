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
          <h4 class="text-center">จัดการรายการตรวจสอบ</h4>
        </div>
        <div class="card-body">
          <div class="row my-3">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_report">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>

            <div class="col-xl-3 col-md-6 offset-xl-3 mb-2">
              <select class="form-select form-select-sm filter_topic" data-placeholder="-- หัวข้อ --"></select>
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
                      <th width="70%">ชื่อ</th>
                      <th width="20%">หัวข้ออ้างอิง</th>
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
        <form action="/helpdesk/checklist/add" method="POST" class="needs-validation" novalidate>
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
                    <input class="form-check-input type" type="radio" name="type" id="_topic" value="1" required>
                    <label class="form-check-label text-primary" for="_topic">หลัก</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input type" type="radio" name="type" id="_sub" value="2" required>
                    <label class="form-check-label text-success" for="_sub">ย่อย</label>
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

<div class="modal fade form_view" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto">รายละเอียด</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="/helpdesk/checklist/update" method="POST" class="needs-validation" novalidate>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
              <div class="col-xl-6 col-md-6">
                <input type="text" class="form-control form-control-sm" name="id" id="id" readonly>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่อ</label>
              <div class="col-xl-6 col-md-6">
                <input type="text" class="form-control form-control-sm" name="name" id="name" required>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หัวข้อ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input _type" type="radio" name="type" id="__topic" value="1" required>
                  <label class="form-check-label text-primary" for="__topic">หลัก</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input _type" type="radio" name="type" id="__sub" value="2" required>
                  <label class="form-check-label text-success" for="__sub">ย่อย</label>
                </div>
              </div>
            </div>
            <div id="div_sub">
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อ้างอิง</label>
                <div class="col-xl-6 col-md-6">
                  <select class="form-select form-select-sm" name="topic" id="topic" data-placeholder="-- หัวข้อ --"></select>
                  <div class="invalid-feedback">
                    กรุณาเลือกข้อมูล.
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานะ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="status" id="active" value="1">
                  <label class="form-check-label text-success" for="active">
                    <i class="fa fa-check-circle pe-2"></i>ใช้งาน
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="inactive" value="2">
                  <label class="form-check-label text-danger" for="inactive">
                    <i class="fa fa-times-circle pe-2"></i>ระงับการใช้งาน
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
      url: "/helpdesk/checklist/data",
      type: "POST",
    },
    columnDefs: [{
      targets: [0, 2],
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


  $(".div_sub, #div_sub").hide();
  $(document).on("click", ".type, ._type", function() {
    let type = parseInt($(this).val());
    if (type === 2) {
      $(".div_sub, #div_sub").show();
      $(".topic, #topic").prop("required", true);
    } else {
      $(".div_sub, #div_sub").hide();
      $(".topic").prop("required", false);
      $(".topic, #topic").empty();
    }
  });

  $(".filter_topic").each(function() {
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

  $(".topic").each(function() {
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

  $("#topic").each(function() {
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

  $(document).on("click", ".btn_view", function() {
    $(".form_view").modal("show");
    let checklist = $(this).prop("id");
    if (checklist) {
      $.ajax({
        url: '/helpdesk/checklist/view',
        method: 'POST',
        data: {
          checklist: checklist
        },
        dataType: 'json',
        success: function(data) {
          console.log(data)
          $("#id").val(data.id);
          $("#name").val(data.name);
          let type = parseInt(data.type_id);
          (type === 1 ? $("#__topic").prop("checked", true) : $("#__topic").prop("checked", false));
          (type === 2 ? $("#__sub").prop("checked", true) : $("#__sub").prop("checked", false));
          if (type === 2) {
            $("#div_sub").show();
            $("#topic").prop("required", true);
            let selected = new Option(data.topic_name, data.topic_id, true, true);
            $("#topic").append(selected).trigger("change");
          } else {
            $("#div_sub").hide();
            $("#topic").prop("required", false);
          }
          let status = parseInt(data.status);
          (status === 1 ? $("#active").prop("checked", true) : $("#active").prop("checked", false));
          (status === 2 ? $("#inactive").prop("checked", true) : $("#inactive").prop("checked", false));
        }
      });
    }
  });

  $(document).on("hidden.bs.modal", ".form_add", function() {
    $(this).find("form").trigger("reset");
    $(this).find("select").empty();
  });
</script>