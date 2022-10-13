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
          <h4 class="text-center">เพิ่ม</h4>
        </div>
        <div class="card-body">
          <form action="/leave/request/add" method="POST" class="needs-validation" enctype="multipart/form-data"
            novalidate>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ประเภทการลา</label>
              <div class="col-xl-4 col-md-6">
                <select class="form-select form-select-sm service" name="service_id"
                  data-placeholder="-- หัวข้อบริการ --" required></select>
                <div class="invalid-feedback">
                  กรุณาเลือกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่ลา</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm calendar" name="date" value="" required>
                <div class="invalid-feedback">
                  กรุณาเลือก วันที่.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สิทธิ์การลา (คงเหลือ)</label>
              <div class="col-xl-2 col-md-4">
                <div class="input-group input-group-sm mb-3">
                  <input type="number" class="form-control form-control-sm text-center used" readonly>
                  <span class="input-group-text">วัน</span>
                </div>
              </div>
            </div>
            <div class="row mb-2 div_warning">
              <label class="offset-xl-4 col-form-label text-danger">สิทธิ์การลาไม่พอใช้</label>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระยะเวลา</label>
              <div class="col-xl-2 col-md-4">
                <div class="input-group input-group-sm mb-3">
                  <input type="number" class="form-control form-control-sm text-center calc" readonly>
                  <span class="input-group-text">วัน</span>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เหตุผลการลา</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" name="text" required></textarea>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ไฟล์แนบ</label>
              <div class="col-xl-4 col-md-6">
                <table class="table table-sm">
                  <tbody>
                    <tr class="tr_file">
                      <td>
                        <button type="button" class="btn btn-sm btn-success increase">+</button>
                        <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                      </td>
                      <td>
                        <input type="file" class="form-control form-control-sm file" name="file[]">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end"></label>
              <div class="col-sm-6">
                <span class="text-danger">เฉพาะไฟล์เอกสาร WORD, EXCEL, PDF หรือไฟล์รูปภาพ PNG และ JPG เท่านั้น</span>
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
$(".div_warning").hide();
$(".service").each(function() {
  $(this).select2({
    containerCssClass: "select2--small",
    dropdownCssClass: "select2--small",
    dropdownParent: $(this).parent(),
    width: "100%",
    allowClear: true,
    ajax: {
      url: "/leave/request/service",
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

$(document).on("change", ".service", function() {
  let service = parseInt($(this).val());
  if (service) {
    $(".calendar, .used, .calc").val("");
  }
});

$(".calendar").on("keydown", function(e) {
  e.preventDefault();
});

$(".calendar").daterangepicker({
  autoUpdateInput: false,
  showDropdowns: true,
  startDate: moment(),
  endDate: moment().add(1, 'days'),
  locale: {
    "format": "DD/MM/YYYY",
    "applyLabel": "ยืนยัน",
    "cancelLabel": "ยกเลิก",
    "daysOfWeek": [
      "อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"
    ],
    "monthNames": [
      "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
      "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ]
  },
  "applyButtonClasses": "btn-success",
  "cancelClass": "btn-danger"
});

$(".calendar").on("apply.daterangepicker", function(ev, picker) {
  $(this).val(picker.startDate.format("DD/MM/YYYY") + ' - ' + picker.endDate.format("DD/MM/YYYY"));

  let service = $(".service").val();
  let date = $(this).val();
  date = date.split("-").map(elm => elm.trim());
  let start = new Date(date[0].split("/").reverse().join("-"));
  start = new Date(start.getUTCFullYear(), start.getUTCMonth(), start.getUTCDate(), start.getUTCHours(), start
    .getUTCMinutes(), start.getUTCSeconds());
  let end = new Date(date[1].split("/").reverse().join("-"));
  end = new Date(end.getUTCFullYear(), end.getUTCMonth(), end.getUTCDate(), end.getUTCHours(), end.getUTCMinutes(),
    end.getUTCSeconds());
  let diff = new Date(end.getTime() - start.getTime());
  diff = Math.round(diff / (1000 * 60 * 60 * 24));
  $(".calc").val(diff + 1);


  if (service) {
    $.ajax({
      url: '/leave/request/used',
      method: 'POST',
      data: {
        service: service
      },
      dataType: 'json',
      success: function(data) {
        let used = parseInt(data);
        $(".used").val(used);
        if (used < parseInt(diff + 1)) {
          $(".btn_submit").prop("disabled", true);
          $(".div_warning").show();
        } else {
          $(".btn_submit").prop("disabled", false);
          $(".div_warning").hide();
        }
      }
    });
  }
});

$(".calendar").on("cancel.daterangepicker", function(ev, picker) {
  $(this).val("");
});


$(".decrease").hide();
$(".increase").on("click", function() {
  let row = $(".tr_file:last");
  let clone = row.clone();
  clone.find("input, select").val("");
  clone.find(".increase").hide();
  clone.find(".decrease").show();
  clone.find(".decrease").on("click", function() {
    $(this).closest("tr").remove();
  });
  row.after(clone);
  clone.show();
});

$(document).on("change", ".file", function() {
  let size = $(this)[0].files[0].size / (1024 * 1024);
  let extension = $(this).val().split('.').pop().toLowerCase();
  let allow = ["doc", "docx", "xls", "xlsx", "pdf", "png", "jpg", "jpeg"];
  size = size.toFixed(2);
  if (size > 5) {
    Swal.fire({
      icon: "error",
      title: "เฉพาะไฟล์ ขนาดไม่เกิน 5 Mb.",
    })
    $(this).val("");
  }

  if (!allow.includes(extension)) {
    Swal.fire({
      icon: "error",
      title: "เฉพาะไฟล์เอกสาร WORD, EXCEL, PDF หรือไฟล์รูปภาพ PNG และ JPG เท่านั้น",
    })
    $(this).val("");
  }
});
</script>