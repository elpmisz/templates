<?php

use app\classes\Service;

$page = "helpdesk";
$group = "service";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : "");
$service = (isset($param[0]) ? $param[0] : "");

$Services = new Service();

$row = $Services->fetch([$service]);

$checklists = $Services->checklists_fetch([$service]);
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
          <form action="/helpdesk/service/update" method="POST" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-sm-12">
                <div class="row mb-2" style="display: none;">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['id'] ?>" readonly>
                    <div class="invalid-feedback">
                      กรุณากรอก ข้อมูล.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">บริการ</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $row['name'] ?>" required>
                    <div class="invalid-feedback">
                      กรุณากรอก ข้อมูล.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หัวข้อ</label>
                  <div class="col-xl-8 col-md-8">
                    <div class="form-check form-check-inline pt-2">
                      <input class="form-check-input type" type="radio" name="type" id="topic" value="1" <?php echo ($row['type_id'] === 1 ? "checked" : "") ?>>
                      <label class="form-check-label text-primary" for="topic">หลัก</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input type" type="radio" name="type" id="sub" value="2" <?php echo ($row['type_id'] === 2 ? "checked" : "") ?>>
                      <label class="form-check-label text-success" for="sub">ย่อย</label>
                    </div>
                  </div>
                </div>

                <div class="div_sub">
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อ้างอิง</label>
                    <div class="col-xl-4 col-md-6">
                      <select class="form-select form-select-sm topic" name="topic" data-placeholder="-- หัวข้อ --"></select>
                      <div class="invalid-feedback">
                        กรุณาเลือกข้อมูล.
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">คำแนะนำ</label>
                    <div class="col-xl-6 col-md-8">
                      <textarea class="form-control form-control-sm" name="suggestion" rows="3"><?php echo $row['suggestion'] ?></textarea>
                      <div class="invalid-feedback">
                        กรุณากรอก ข้อมูล.
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระยะเวลา (SLA)</label>
                    <div class="col-xl-2 col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <input type="number" class="form-control form-control-sm text-center" name="period" value="<?php echo $row['period'] ?>">
                        <span class="input-group-text">วัน</span>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เลือกอุปกรณ์</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="hardware" id="hw-1" value="1" <?php echo ($row['hardware'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="hw-1">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="hardware" id="hw-2" value="2" <?php echo ($row['hardware'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="hw-2">ไม่มี</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">การอนุมัติ</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="approve" id="ap-1" value="1" <?php echo ($row['approve'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="ap-1">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="approve" id="ap-2" value="2" <?php echo ($row['approve'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="ap-2">ไม่มี</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปฏิทินเดี่ยว</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="calendar1" id="calendar-1" value="1" <?php echo ($row['calendar1'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="calendar-1">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="calendar1" id="calendar-2" value="2" <?php echo ($row['calendar1'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="calendar-2">ไม่มี</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ปฏิทินคู่</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="calendar2" id="calendar-3" value="1" <?php echo ($row['calendar2'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="calendar-3">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="calendar2" id="calendar-4" value="2" <?php echo ($row['calendar2'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="calendar-4">ไม่มี</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายการตรวจสอบ</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input checklist" type="radio" name="checklist" id="checklist-1" value="1" <?php echo ($row['checklist'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="checklist-1">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input checklist" type="radio" name="checklist" id="checklist-2" value="2" <?php echo ($row['checklist'] === 2 ? "checked" : "") ?>>
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
                        <input class="form-check-input" type="radio" name="checker" id="checker-1" value="1" <?php echo ($row['checker'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-primary" for="checker-1">มี</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="checker" id="checker-2" value="2" <?php echo ($row['checker'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="checker-2">ไม่มี</label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานะ</label>
                    <div class="col-xl-8 col-md-8">
                      <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1" <?php echo ($row['status'] === 1 ? "checked" : "") ?>>
                        <label class="form-check-label text-success" for="active">
                          <i class="fa fa-check-circle pe-2"></i>ใช้งาน
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="inactive" value="2" <?php echo ($row['status'] === 2 ? "checked" : "") ?>>
                        <label class="form-check-label text-danger" for="inactive">
                          <i class="fa fa-times-circle pe-2"></i>ระงับการใช้งาน
                        </label>
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
                <a href="/helpdesk/service" class="btn btn-danger btn-sm w-100">
                  <i class="fa fa-arrow-left pe-2"></i> กลับหน้าจัดการ
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

  $(document).ready(function() {
    let type = parseInt($(".type:checked").val());
    if (type === 2) {
      $(".div_sub").show();
      $(".topic").prop("required", true);

      let selected = new Option(<?php echo "'{$row['topic_name']}', '{$row['topic_id']}'" ?>, true, true);
      $(".topic").append(selected).trigger("change");
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

  $(document).ready(function() {
    let checklist = parseInt($(".checklist:checked").val());
    if (checklist === 1) {
      $(".div_checklists").show();
      $(".checklists").prop("required", true);

      const checklists = <?php echo json_encode($checklists) ?>;
      checklists.forEach(function(e) {
        let selected = new Option(e.name, e.id, true, true);
        $(".checklists").append(selected).trigger("change");
      });
    } else {
      $(".div_checklists").hide();
      $(".checklists").prop("required", false);
    }
  });
</script>