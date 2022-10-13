<?php

$page = "users";
$group = "system";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");

$param = (isset($params) ? explode("/", $params) : "");
$id = (!empty($param[0]) ? $param[0] : "");

$row = $Users->user_fetch_id([$id]);
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">รายละเอียด</h4>
        </div>
        <div class="card-body">
          <form action="/users/adminupdate" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
              <div class="col-xl-4 col-md-6">
                <input type="email" class="form-control form-control-sm" name="user_id" value="<?php echo $row['user_id'] ?>" readonly>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row justify-content-center div_show mb-2">
              <div class="col-sm-2">
                <img src="" class="rounded img-fluid show-image" alt="show-image">
              </div>
            </div>
            <div class="row justify-content-center mb-2">
              <div class="col-sm-2">
                <?php if (!empty($row['picture'])) : ?>
                  <img src="/assets/img/profile/<?php echo $row['picture'] ?>" class="rounded img-fluid" alt="profile-image">
                <?php else : ?>
                  <img src="/assets/img/profile/no-img.png" class="rounded img-fluid" alt="no-image">
                <?php endif; ?>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-sm-4 col-form-label text-xl-end">เปลี่ยนรูปประจำตัว</label>
              <div class="col-sm-4">
                <input type="file" class="form-control form-control-sm" name="picture" accept="image/*">
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อีเมล</label>
              <div class="col-xl-4 col-md-6">
                <input type="email" class="form-control form-control-sm" name="email" value="<?php echo $row['email'] ?>" required>
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่อ - นามสกุล</label>
              <div class="col-xl-6 col-md-8">
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $row['name'] ?>" required>
                  <input type="text" class="form-control form-control-sm" name="surname" value="<?php echo $row['surname'] ?>" required>
                  <div class="invalid-feedback">
                    กรุณากรอกช่องนี้.
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ติดต่อ</label>
              <div class="col-xl-4 col-md-6">
                <input type="text" class="form-control form-control-sm" name="contact" value="<?php echo $row['contact'] ?>">
                <div class="invalid-feedback">
                  กรุณากรอกช่องนี้.
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ระดับ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="level" id="user" value="1" <?php echo (intval($row['level']) === 1 ? "checked" : "") ?>>
                  <label class="form-check-label text-primary" for="user">
                    <i class="fa fa-user pe-2"></i>ผู้ใช้งาน
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="level" id="admin" value="9" <?php echo (intval($row['level']) === 9 ? "checked" : "") ?>>
                  <label class="form-check-label text-success" for="admin">
                    <i class="fa fa-user-secret pe-2"></i>ผู้ดูแลระบบ
                  </label>
                </div>
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

            <div class="row justify-content-center mb-2">
              <div class="col-xl-3 col-md-6">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-3 col-md-6">
                <a href="/users" class="btn btn-danger btn-sm w-100">
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
include_once(__DIR__ . "/../../includes/footer.php");
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
</script>