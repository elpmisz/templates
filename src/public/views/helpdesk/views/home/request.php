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
          <h4 class="text-center">เพิ่ม</h4>
        </div>
        <div class="card-body">
          <form action="/helpdesk/request/add" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หัวข้อบริการ</label>
              <div class="col-xl-4 col-md-6">
                <select class="form-select form-select-sm service" name="service_id" data-placeholder="-- หัวข้อบริการ --" required></select>
                <div class="invalid-feedback">
                  กรุณาเลือกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2 div_sub">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปัญหาที่พบ</label>
              <div class="col-xl-4 col-md-6">
                <select class="form-select form-select-sm sub" name="sub_id" data-placeholder="-- หัวข้อบริการ --"></select>
                <div class="invalid-feedback">
                  กรุณาเลือกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2 div_suggestion">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end"></label>
              <div class="col-xl-4 col-md-6">
                <span class="text-danger suggestion"></span>
              </div>
            </div>
            <div class="row mb-2 div_hardware">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อุปกรณ์</label>
              <div class="col-xl-6 col-md-8">
                <select class="form-select form-select-sm hardware" name="hardware" data-placeholder="-- อุปกรณ์คอมพิวเตอร์ --"></select>
                <div class="invalid-feedback">
                  กรุณาเลือกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2 div_calendar1">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
              <div class="col-xl-3 col-md-6">
                <input type="text" class="form-control form-control-sm calendar1" name="date1">
                <div class="invalid-feedback">
                  กรุณาเลือก วันที่.
                </div>
              </div>
            </div>
            <div class="row mb-2 div_calendar2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
              <div class="col-xl-5 col-md-7">
                <input type="text" class="form-control form-control-sm calendar2" name="date2">
                <div class="invalid-feedback">
                  กรุณาเลือก วันที่.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียด</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" name="text" required></textarea>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ผู้ใช้บริการ</label>
              <div class="col-xl-3 col-md-6">
                <input type="text" class="form-control form-control-sm" value="<?php echo $user['fullname'] ?>" readonly>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เบอร์ติดต่อ</label>
              <div class="col-xl-3 col-md-6">
                <input type="text" class="form-control form-control-sm" name="contact" value="<?php echo $user['contact'] ?>">
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้
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
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-4 col-md-6 mb-2">
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
  $(".service").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/helpdesk/request/service",
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

  $(".hardware").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/helpdesk/request/hardware",
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

  $(".calendar1, .calendar2").on("keydown", function(e) {
    e.preventDefault();
  });

  $(".calendar1").daterangepicker({
    // autoUpdateInput: false,
    singleDatePicker: true,
    showDropdowns: true,
    // minDate: moment(),
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

  $(".calendar2").daterangepicker({
    // autoUpdateInput: false,
    // singleDatePicker: true,
    showDropdowns: true,
    // minDate: moment(),
    timePicker: true,
    timePicker24Hour: true,
    startDate: moment(),
    endDate: moment().add(1, 'days'),
    locale: {
      "format": "DD/MM/YYYY, HH:mm น.",
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

  $(".div_sub").hide();
  $(document).on("change", ".service", function() {
    let service = $(this).val();
    $(".sub").empty();
    $(".div_suggestion, .div_hardware, .div_calendar1, .div_calendar2").hide();

    if (service) {
      $(".div_sub").show();
      $(".sub").each(function() {
        $(this).select2({
          containerCssClass: "select2--small",
          dropdownCssClass: "select2--small",
          dropdownParent: $(this).parent(),
          width: "100%",
          allowClear: true,
          ajax: {
            url: "/helpdesk/request/sub",
            method: 'POST',
            dataType: 'json',
            data: function(params) {
              return {
                q: params.term,
                service: service
              };
            },
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
      $(".sub").prop("required", true);
    } else {
      $(".div_sub, .div_suggestion, .div_hardware, .div_calendar1, .div_calendar2").hide();
      $(".sub").prop("required", false);
    }
  });

  $(".div_suggestion, .div_hardware, .div_calendar1, .div_calendar2").hide();
  $(document).on("change", ".sub", function() {
    let sub = $(this).val();
    $(".hardware").empty();
    $(".calendar1, .calendar2").val("");

    if (sub) {
      $.ajax({
        url: '/helpdesk/request/condition',
        method: 'POST',
        data: {
          sub: sub
        },
        dataType: 'json',
        success: function(data) {
          let suggestion = data.suggestion;
          let hardware = parseInt(data.hardware);
          let calendar1 = parseInt(data.calendar1);
          let calendar2 = parseInt(data.calendar2);

          if (suggestion) {
            $(".div_suggestion").show();
            $(".suggestion").text(suggestion);
          }

          if (hardware === 1) {
            $(".div_hardware").show();
            $(".hardware").prop("required", true);
          } else {
            $(".div_hardware").hide();
            $(".hardware").prop("required", false);
          }

          if (calendar1 === 1) {
            $(".div_calendar1").show();
            $(".calendar1").prop("required", true);
          } else {
            $(".div_calendar1").hide();
            $(".calendar1").prop("required", false);
          }

          if (calendar2 === 1) {
            $(".div_calendar2").show();
            $(".calendar2").prop("required", true);
          } else {
            $(".div_calendar2").hide();
            $(".calendar2").prop("required", false);
          }
        }
      });
    }
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