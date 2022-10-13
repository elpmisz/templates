<?php
$page = "machine";
$group = "system";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ข้อมูลประเภทอุปกรณ์</h4>
        </div>
        <div class="card-body">
          <div class="row my-3">
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
                      <th width="90%">ชื่อ</th>
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
        <a href="/machine" class="btn btn-danger btn-sm w-100">
          <i class="fa fa-arrow-left pe-2"></i>กลับหน้าหลัก
        </a>
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
          <form action="/machine/type/add" method="POST" class="needs-validation" novalidate>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่อ</label>
              <div class="col-xl-6 col-md-6">
                <input type="text" class="form-control form-control-sm" name="name" required>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="30%">หัวข้อ</th>
                      <th width="20%">ประเภท</th>
                      <th width="30%">ข้อมูลตัวเลือก</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="tr_text">
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success increase">+</button>
                        <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm subject" name="subject[]">
                        <div class="invalid-feedback">
                          กรุณากรอกข้อมูล.
                        </div>
                      </td>
                      <td>
                        <select class="form-select type" name="type[]" data-placeholder="-- เลือก --">
                          <option value="">-- เลือก --</option>
                          <?php
                          $data = ["ตัวหนังสือ", "ตัวเลข", "ตัวเลือก"];
                          foreach ($data as $key => $value) {
                            $key++;
                            echo "<option value ='{$key}'>{$value}</option>";
                          }
                          ?>
                        </select>
                        <div class="invalid-feedback">
                          กรุณาเลือกข้อมูล.
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm text" name="text[]">
                        <div class="invalid-feedback">
                          กรุณากรอกข้อมูล.
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เลือกโปรแกรม</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="software" id="yes" value="1" required>
                  <label class="form-check-label text-success" for="yes">มี
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="software" id="no" value="2" required>
                  <label class="form-check-label text-danger" for="no">ไม่มี
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
      url: "/machine/type/data",
      type: "POST",
    },
    columnDefs: [{
      targets: [0],
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

  $(".type").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true
    });
  });

  $(".decrease").hide();
  $(document).on("click", ".increase", function() {
    $(".type").select2("destroy");
    let row = $(".tr_text:last");
    let clone = row.clone();
    clone.find("input, select").val('');
    clone.find(".increase").hide();
    clone.find(".decrease").show();
    clone.find(".decrease").on('click', function() {
      $(this).closest("tr").remove();
    });
    row.after(clone);
    clone.show();

    $(".type").each(function() {
      $(this).select2({
        containerCssClass: "select2--small",
        dropdownCssClass: "select2--small",
        dropdownParent: $(this).parent(),
        width: "100%",
        allowClear: true
      });
    });

  });

  $(document).on("blur", ".subject", function() {
    let subject = $(this).val();
    if (subject) {
      $(".type").prop("required", true);
    } else {
      $(".type").prop("required", false);
    }
  });

  $(document).on("change", ".type", function() {
    let type = parseInt($(this).val());
    let row = $(this).closest('tr');
    if (type === 3) {
      row.find(".text").prop("required", true);
    } else {
      row.find(".text").prop("required", false);
    }
  });

  $(document).on("hidden.bs.modal", ".form_add", function() {
    $(this).find("form").trigger("reset");
    $(this).find("select").empty();
  });
</script>