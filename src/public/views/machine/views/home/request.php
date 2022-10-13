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
          <h4 class="text-center">เพิ่ม</h4>
        </div>
        <div class="card-body">
          <form action="/machine/add" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row justify-content-center div_show mb-2">
              <div class="col-sm-2">
                <img src="" class="rounded img-fluid show-image" alt="show-image">
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-sm-4 col-form-label text-xl-end">รูปอุปกรณ์</label>
              <div class="col-sm-4">
                <input type="file" class="form-control form-control-sm" name="picture" accept="image/*">
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่ออุปกรณ์</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="name" required>
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
                    <input type="text" class="form-control form-control-sm" name="serial">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">Asset Code</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm" name="asset">
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
                    <select class="form-select type" name="type_id" data-placeholder="-- เลือก --" required></select>
                    <div class="invalid-feedback">
                      กรุณาเลือกช่องนี้.
                    </div>
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
                    <input type="text" class="form-control form-control-sm purchase" name="purchase">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่รับประกัน</label>
                  <div class="col-xl-6 col-md-8">
                    <input type="text" class="form-control form-control-sm expire" name="expire">
                    <div class="invalid-feedback">
                      กรุณากรอกช่องนี้.
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-2 div_item"></div>

            <div class="row justify-content-center mb-2 div_software">
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
                      <tr class="tr_software">
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-success increase">+</button>
                          <button type="button" class="btn btn-sm btn-danger decrease">-</button>
                        </td>
                        <td>
                          <select class="form-select form-select-sm software" name="software_id[]" data-placeholder="-- เลือก --"></select>
                        </td>
                        <td><input type="text" class="form-control form-control-sm" name="remark[]"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียดเพิ่มเติม</label>
              <div class="col-xl-6 col-md-6">
                <textarea class="form-control form-control-sm" name="text" rows="4"></textarea>
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

  $(".div_software").hide();
  $(document).on("change", ".type", function() {
    let type = parseInt($(this).val());

    $.ajax({
      url: '/machine/itemcondition',
      method: 'POST',
      data: {
        type: type
      },
      dataType: 'json',
      success: (data) => {
        if (data.length > 0) {
          let item = ""
          data.forEach((d) => {
            item += "<div class='col-xl-6 col-md-6'>";
            item += "<div class='row mb-2'>";
            item += "<label class='col-xl-4 col-md-4 col-form-label text-xl-end'>" + d.subject + "</label>";
            item += "<div class='col-xl-6 col-md-8'>";
            item += "<input type='hidden' class='form-control form-control-sm' name='item_id[]' value='" + d.id + "'>";
            switch (d.type) {
              case 2:
                item += "<input type='number' class='form-control form-control-sm' name='item_text[]' min='0' step='0.01'>";
                break;
              case 3:
                let selected = d.text.split(",");
                let select = "";
                for (let i = 0; i < selected.length; i++) {
                  select += "<option value='" + i + "'>" + selected[i] + "</option>";
                }
                item += "<select class='form-select form-select-sm' name='item_text[]'><option value=''>-- เลือก --</option>" + select + "</select>";
                break;
              case 1:
                item += "<input type='text' class='form-control form-control-sm' name='item_text[]'>";
            }
            item += "</div>";
            item += "</div>";
            item += "</div>";
          });

          $(".div_item").html(item);
        } else {
          $(".div_item").empty();
        }
      }
    });

    $.ajax({
      url: '/machine/softwarecondition',
      method: 'POST',
      data: {
        type: type
      },
      dataType: 'json',
      success: (data) => {
        if (parseInt(data.software) === 1) {
          $(".div_software").show();
        } else {
          $(".div_software").hide();
        }
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
</script>