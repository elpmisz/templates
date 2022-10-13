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
          <form action="/helpdesk/request/update" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
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
                <?php if ($row['approver'] === 0) : ?>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เบอร์ติดต่อ</label>
                    <div class="col-xl-8 col-md-6">
                      <input type="text" class="form-control form-control-sm is-valid" name="contact" value="<?php echo $row['contact'] ?>">
                      <div class="invalid-feedback">
                        กรุณากรอกช่องนี้
                      </div>
                    </div>
                  </div>
                <?php else : ?>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เบอร์ติดต่อ</label>
                    <div class="col-xl-8 col-md-6">
                      <span class="form-control form-control-sm"><?php echo $row['contact'] ?></span>
                    </div>
                  </div>
                <?php endif; ?>
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


            <?php if ($row['approver'] === 0) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end"></label>
                <div class="col-xl-8 col-md-8">
                  <span class="text-danger"><?php echo $row['suggestion'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['hardware'] === 1) : ?>
              <?php if ($row['approver'] === 0) : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อุปกรณ์</label>
                  <div class="col-xl-6 col-md-8">
                    <select class="form-select form-select-sm hardware" name="hardware" data-placeholder="-- อุปกรณ์คอมพิวเตอร์ --"></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกช่องนี้.
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อุปกรณ์</label>
                  <div class="col-xl-6 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['hardware_name'] ?></span>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($row['calendar1'] === 1) : ?>
              <?php if ($row['approver'] === 0) : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                  <div class="col-xl-3 col-md-6">
                    <input type="text" class="form-control form-control-sm is-valid calendar1" name="date1" value="<?php echo $row['date1'] ?>">
                    <div class="invalid-feedback">
                      กรุณาเลือก วันที่.
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                  <div class="col-xl-3 col-md-6">
                    <span class="form-control form-control-sm"><?php echo $row['date1'] ?></span>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($row['calendar2'] === 1) : ?>
              <?php if ($row['approver'] === 0) : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                  <div class="col-xl-5 col-md-7">
                    <input type="text" class="form-control form-control-sm is-valid calendar2" name="date2" value="<?php echo $row['date2'] ?>">
                    <div class="invalid-feedback">
                      กรุณาเลือก วันที่.
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                  <div class="col-xl-5 col-md-7">
                    <span class="form-control form-control-sm"><?php echo $row['date2'] ?></span>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($row['approver'] === 0) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียด</label>
                <div class="col-xl-5 col-md-7">
                  <textarea class="form-control form-control-sm is-valid" rows="3" name="text" required><?php echo $row['text'] ?></textarea>
                  <div class="invalid-feedback">
                    กรุณากรอกช่องนี้.
                  </div>
                </div>
              </div>
            <?php else : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียด</label>
                <div class="col-xl-5 col-md-7">
                  <textarea class="form-control form-control-sm" rows="3" readonly><?php echo $row['text'] ?></textarea>
                </div>
              </div>
            <?php endif; ?>


            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ไฟล์แนบ</label>
              <div class="col-xl-8 col-md-8">
                <table class="table table-sm">
                  <tbody>
                    <?php foreach ($uploads as $key => $upload) : $key++; ?>
                      <tr>
                        <?php if ($row['approver'] === 0) : ?>
                          <td width="50px">
                            <a href="javascript:void(0)" class="badge text-bg-danger fw-lighter upload_delete" id="<?php echo $upload['id'] ?>">ลบ</a>
                          </td>
                        <?php endif; ?>
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

              <?php if ($row['approver'] === 0) : ?>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end"></label>
                  <div class="col-sm-6">
                    <span class="text-danger">เฉพาะไฟล์เอกสาร WORD, EXCEL, PDF หรือไฟล์รูปภาพ PNG และ JPG เท่านั้น</span>
                  </div>
                </div>
                <div class="col-xl-4 offset-xl-4 col-md-4 offset-md-4">
                  <table class="table table-sm">
                    <tbody>
                      <tr class="tr_file">
                        <td>
                          <button type="button" class="btn btn-sm btn-success increase">+</button>
                          <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                        </td>
                        <td>
                          <input type="file" class="form-control form-control-sm is-valid file" name="file[]">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          <?php endif; ?>



          <div class="row justify-content-center">
            <?php if ($row['approver'] === 0) : ?>
              <div class="col-xl-4 col-md-4 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
            <?php endif; ?>
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

  let selected = new Option(<?php echo "'{$row['hardware_name']}', '{$row['hardware_id']}'" ?>, true, true);
  $(".hardware").append(selected).trigger("change");

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

  $(document).on("click", ".upload_delete", function() {
    let upload = $(this).prop("id");
    alert(upload)
  });
</script>