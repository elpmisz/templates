<?php

use app\classes\Request;

$page = "machine";
$group = "system";

include_once(__DIR__ . "/../../../../includes/header.php");
include_once(__DIR__ . "/../../../../includes/sidebar.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : "");
$machine_id = (isset($param[0]) ? $param[0] : "");

$Request = new Request();
$row = $Request->machine_fetch([$machine_id]);
$items = $Request->item_fetch_id([$machine_id]);
$softwares = $Request->software_fetch_id([$machine_id]);
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
          <form action="/machine/update" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row justify-content-center div_show mb-2">
              <div class="col-sm-2">
                <img src="" class="rounded img-fluid show-image" alt="show-image">
              </div>
            </div>
            <div class="row justify-content-center mb-2">
              <div class="col-sm-2">
                <?php if (!empty($row['picture'])) : ?>
                  <img src="/views/machine/assets/img/machine/<?php echo $row['picture'] ?>" class="rounded img-fluid" alt="machine-image">
                <?php else : ?>
                  <img src="/views/machine/assets/img/machine/no-img.png" class="rounded img-fluid" alt="no-image">
                <?php endif; ?>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-sm-4 col-form-label text-xl-end">รูปอุปกรณ์</label>
              <div class="col-sm-4">
                <input type="file" class="form-control form-control-sm" name="picture" accept="image/*">
              </div>
            </div>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัสอุปกรณ์</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['machine_id'] ?>" readonly>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่ออุปกรณ์</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $row['machine_name'] ?>" required>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-xl-6 col-md-6">
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ยี่ห้อ</label>
                  <div class="col-xl-6 col-md-8">
                    <select class="form-select brand" name="brand_id" data-placeholder="-- เลือก --" required></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รุ่น</label>
                  <div class="col-xl-6 col-md-8">
                    <select class="form-select form-select-sm model" name="model_id" data-placeholder="-- เลือก --"></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">Serial Number</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm" name="serial" value="<?php echo $row['serial'] ?>">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">Asset Code</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm" name="asset" value="<?php echo $row['asset'] ?>">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-6 col-md-6">
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ประเภท</label>
                  <div class="col-xl-6 col-md-8">
                    <span class="form-control form-control-sm"><?php echo $row['type_name'] ?></span>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานที่</label>
                  <div class="col-xl-6 col-md-8">
                    <select class="form-select location" name="location_id" data-placeholder="-- เลือก --" required></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่ซื้อ</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm purchase" name="purchase" value="<?php echo $row['purchase'] ?>">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่รับประกัน</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm expire" name="expire" value="<?php echo $row['expire'] ?>">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php if (COUNT($items) > 0) : ?>
              <div class="row mb-2">
                <?php foreach ($items as $item) : ?>
                  <div class="col-xl-6 col-md-6">
                    <div class="row mb-2">
                      <label class="col-xl-4 col-md-4 col-form-label text-xl-end"><?php echo $item['subject_name'] ?></label>
                      <div class="col-xl-6 col-md-8">
                        <input type="hidden" class="form-control form-control-sm" name="item_id[]" value="<?php echo $item['id'] ?>">
                        <input type="text" class="form-control form-control-sm" name="item_text[]" value="<?php echo $item['item_text'] ?>">
                        <div class="invalid-feedback">
                          กรุณากรอกช่องนี้.
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($row['software'] === 1) : ?>
              <div class="row justify-content-center mb-2">
                <div class="col-sm-10">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="30%">โปรแกรม</th>
                          <th width="30%">หมายเหตุ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($softwares as $software) : ?>
                          <tr>
                            <td class="text-center">
                              <a href="javascript:void(0)" class="badge text-bg-danger fw-lighter software_delete" id="<?php echo $software['id'] ?>">ลบ</a>
                            </td>
                            <td><?php echo $software['software_name'] ?></td>
                            <td>
                              <input type="hidden" class="form-control form-control-sm" name="software_id[]" value="<?php echo $software['id'] ?>" readonly>
                              <input type="text" class="form-control form-control-sm" name="software_remark[]" value="<?php echo $software['remark'] ?>">
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        <tr class="tr_software">
                          <td class="text-center">
                            <button type="button" class="btn btn-sm btn-success increase">+</button>
                            <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                          </td>
                          <td>
                            <select class="form-select form-select-sm software" name="_software_id[]" data-placeholder="-- เลือก --"></select>
                          </td>
                          <td><input type="text" class="form-control form-control-sm" name="_remark[]"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียดเพิ่มเติม</label>
              <div class="col-xl-6 col-md-6">
                <textarea class="form-control form-control-sm" name="text" rows="4"><?php echo $row['text'] ?></textarea>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานะ</label>
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

            <div class="row justify-content-center">
              <div class="col-xl-4 col-md-6 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-4 col-md-6 mb-2">
                <a href="/machine" class="btn btn-danger btn-sm w-100">
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
  $(".div_show").hide();
  $(document).on("change", "input[name='picture']", function() {
    let file = $(this).val();
    let size = this.files[0].size / (1024 * 1024);
    size = size.toFixed(2);
    let extension = file.split('.').pop().toLowerCase();
    let allow = ["png", "jpg", "jpeg"];
    let url = URL.createObjectURL(event.target.files[0]);

    if (size > 5) {
      Swal.fire({
        icon: "error",
        title: "เฉพาะไฟล์ ขนาดไม่เกิน 5 Mb.",
      })
      $(this).val("");
    }

    if (allow.indexOf(extension) === -1) {
      Swal.fire({
        icon: "error",
        title: "เฉพาะไฟล์รูปภาพ PNG และ JPG เท่านั้น",
      })
      $(this).val("");
      $(".div_show").hide();
    } else {
      $(".div_show").show();
      $(".show-image").prop("src", url);
      URL.revokeObjectURL($(".show-image").prop("src", url));
    }
  });

  $(".type").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      allowClear: true,
      ajax: {
        url: "/machine/type",
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

  $(".location").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/machine/location",
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

  $(".brand").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/machine/brand",
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

  $(".model").prop("disabled", true);
  $(document).on("change", ".brand", function() {
    $(".model").empty();
    let brand = parseInt($(this).val());

    if (brand) {
      $(".model").prop("disabled", false);
      $(".model").prop("required", true);
      $(".brand").each(function() {
        $(".model").select2({
          containerCssClass: "select2--small",
          dropdownCssClass: "select2--small",
          dropdownParent: $(".model").parent(),
          width: "100%",
          allowClear: true,
          ajax: {
            url: "/machine/model",
            method: 'POST',
            dataType: 'json',
            data: function(params) {
              return {
                keyword: params.term,
                brand: brand
              }
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
    } else {
      $(".model").prop("disabled", true);
      $(".model").prop("required", false);
      $(".model").empty();
    }
  });

  $(".purchase, .expire").on("keydown paste", function(e) {
    e.preventDefault();
  });

  $(".purchase").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoUpdateInput: false,
    locale: {
      "format": "DD/MM/YYYY",
      "daysOfWeek": [
        "อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"
      ],
      "monthNames": [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
      ]
    },
  }, function(input) {
    $(".purchase").val(input.format("DD/MM/YYYY"));
  });

  $(".expire").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoUpdateInput: false,
    locale: {
      "format": "DD/MM/YYYY",
      "daysOfWeek": [
        "อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"
      ],
      "monthNames": [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
      ]
    },
  }, function(input) {
    $(".expire").val(input.format("DD/MM/YYYY"));
  });

  $(".software").each(function() {
    $(this).select2({
      containerCssClass: "select2--small",
      dropdownCssClass: "select2--small",
      dropdownParent: $(this).parent(),
      width: "100%",
      allowClear: true,
      ajax: {
        url: "/machine/software",
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

  $(".decrease").hide();
  $(document).on("click", ".increase", function() {
    $(".software").select2("destroy");
    let row = $(".tr_software:last");
    let clone = row.clone();
    clone.find("input, select").val("");
    clone.find(".increase").hide();
    clone.find(".decrease").show();
    clone.find(".decrease").on("click", function() {
      $(this).closest("tr").remove();
    });
    row.after(clone);
    clone.show();

    $(".software").each(function() {
      $(this).select2({
        containerCssClass: "select2--small",
        dropdownCssClass: "select2--small",
        dropdownParent: $(this).parent(),
        width: "100%",
        allowClear: true,
        ajax: {
          url: "/machine/software",
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
  });

  let brand_selected = new Option(<?php echo "'{$row['brand_name']}', '{$row['brand_id']}'" ?>, true, true);
  $(".brand").append(brand_selected).trigger("change");

  let model_selected = new Option(<?php echo "'{$row['model_name']}', '{$row['model_id']}'" ?>, true, true);
  $(".model").append(model_selected).trigger("change");

  let location_selected = new Option(<?php echo "'{$row['location_name']}', '{$row['location_id']}'" ?>, true, true);
  $(".location").append(location_selected).trigger("change");

  $(document).on('click', '.software_delete', function(e) {
    let item = $(this).prop('id');
    e.preventDefault();
    Swal.fire({
      title: "ยืนยันที่จะทำรายการ?",
      text: "ลบข้อมูล!",
      icon: "error",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ปิด",
    }).then((result) => {
      if (result.value) {
        window.location.href = "/machine/softwaredelete/" + item;
      } else {
        return false;
      }
    })
  });
</script>