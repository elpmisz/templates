<?php

use app\classes\Type;

$page = "machine";
$group = "system";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : "");
$type_id = (isset($param[0]) ? $param[0] : "");

$Type = new Type();

$row = $Type->type_fetch([$type_id]);
$items = $Type->item_fetch_id([$type_id]);
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
          <form action="/machine/type/update" method="POST" class="needs-validation" novalidate>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-3 col-md-4 col-form-label text-xl-end">รหัส</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm request" name="request" value="<?php echo $row['id'] ?>" readonly>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-3 col-md-4 col-form-label text-xl-end">ชื่อ</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $row['name'] ?>" required>
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
                    <?php foreach ($items as $item) : ?>
                      <tr>
                        <td class="text-center">
                          <a href="javascript:void(0)" class="badge text-bg-danger btn_delete fw-lighter" id="<?php echo $item['id'] ?>">ลบ</a>
                          <input type="hidden" class="form-control form-control-sm" name="item[]" value="<?php echo $item['id'] ?>">
                        </td>
                        <td>
                          <input type="text" class="form-control form-control-sm subject" name="subject[]" value="<?php echo $item['subject'] ?>">
                        </td>
                        <td>
                          <select class="form-select type" name="type[]" data-placeholder="-- เลือก --">
                            <option value="">-- เลือก --</option>
                            <?php
                            $data = ["ตัวหนังสือ", "ตัวเลข", "ตัวเลือก"];
                            foreach ($data as $key => $value) {
                              $key++;
                              echo "<option value ='{$key}' " . ($key === $item['type'] ? "selected" : "") . ">{$value}</option>";
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">
                            กรุณาเลือกข้อมูล.
                          </div>
                        </td>
                        <td>
                          <input type="text" class="form-control form-control-sm text" name="text[]" value="<?php echo $item['text'] ?>">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="tr_text">
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success increase">+</button>
                        <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm subject" name="_subject[]">
                        <div class="invalid-feedback">
                          กรุณากรอกข้อมูล.
                        </div>
                      </td>
                      <td>
                        <select class="form-select type" name="_type[]" data-placeholder="-- เลือก --">
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
                        <input type="text" class="form-control form-control-sm text" name="_text[]">
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
              <label class="col-xl-3 col-md-3 col-form-label text-xl-end">เลือกโปรแกรม</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="software" id="yes" value="1" <?php echo ($row['software'] === 1 ? "checked" : "") ?> required>
                  <label class="form-check-label text-success" for="yes">มี
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="software" id="no" value="2" <?php echo ($row['software'] === 2 ? "checked" : "") ?> required>
                  <label class="form-check-label text-danger" for="no">ไม่มี
                  </label>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-3 col-md-3 col-form-label text-xl-end">สถานะ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="status" id="active" value="1" <?php echo (intval($row['status']) === 1 ? "checked" : "") ?>>
                  <label class="form-check-label text-success" for="active">
                    <i class="fa fa-check-circle pe-2"></i>ใช้งาน
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="inactive" value="2" <?php echo (intval($row['status']) === 2 ? "checked" : "") ?>>
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
                <a href="/machine/type" class="btn btn-danger btn-sm w-100">
                  <i class="fa fa-arrow-left pe-2"></i> กลับหน้าประเภทอุปกรณ์
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
    let row = $(this).closest('tr');
    if (subject) {
      row.find(".type").prop("required", true);
    } else {
      row.find(".type").prop("required", false);
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

  $(document).on("click", ".btn_delete", function(e) {
    let item = $(this).prop('id');
    let request = $(".request").val();
    e.preventDefault();
    Swal.fire({
      title: "ยืนยันที่จะทำรายการ, ลบ?",
      icon: "error",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.value) {
        window.location.href = "/machine/type/itemdelete/" + item + "/" + request;
      } else {
        return false;
      }
    })
  });
</script>