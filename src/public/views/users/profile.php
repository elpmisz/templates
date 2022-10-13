<?php
$page = "profile";
$group = "users";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ประวัติส่วนตัว</h4>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-xl-3 mb-2">
              <div class="card shadow">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xl-12 text-center mb-3">
                      <img src="/assets/img/profile/<?php echo $user['picture'] ?>" alt="Profile"
                        class="img-fluid img-profile">
                    </div>
                    <div class="col-xl-12 mb-3">
                      <h4 class="text-center"><?php echo $user['fullname'] ?></h4>
                      <h4 class="text-center">Developer</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-9 mb-2">
              <nav>
                <div class="nav nav-pills mb-3">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button">รายละเอียด</button>
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button">เปลี่ยนรหัสผ่าน</button>
                </div>
              </nav>
              <div class="tab-content shadow">
                <div class="tab-pane fade show active" id="nav-home">
                  <div class="card shadow">
                    <div class="card-body">
                      <form action="/users/userupdate" method="POST" class="needs-validation"
                        enctype="multipart/form-data" novalidate>
                        <div class="row justify-content-center div_show mb-2">
                          <div class="col-sm-2">
                            <img src="" class="rounded img-fluid show-image" alt="show-image">
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
                            <input type="email" class="form-control form-control-sm"
                              value="<?php echo $user['email'] ?>" readonly>
                            <div class="invalid-feedback">
                              กรุณากรอกช่องนี้.
                            </div>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ชื่อ - นามสกุล</label>
                          <div class="col-xl-6 col-md-8">
                            <div class="input-group">
                              <input type="text" class="form-control form-control-sm" name="name"
                                value="<?php echo $user['name'] ?>" required>
                              <input type="text" class="form-control form-control-sm" name="surname"
                                value="<?php echo $user['surname'] ?>" required>
                              <div class="invalid-feedback">
                                กรุณากรอกช่องนี้.
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ติดต่อ</label>
                          <div class="col-xl-4 col-md-6">
                            <input type="text" class="form-control form-control-sm" name="contact"
                              value="<?php echo $user['contact'] ?>">
                            <div class="invalid-feedback">
                              กรุณากรอกช่องนี้.
                            </div>
                          </div>
                        </div>

                        <div class="row justify-content-center mb-2">
                          <div class="col-xl-3 col-md-6">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                              <i class="fas fa-check pe-2"></i>ยืนยัน
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-profile">
                  <div class="card shadow">
                    <div class="card-body">
                      <form action="/users/change" method="POST">
                        <div class="row mb-2">
                          <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัสผ่าน</label>
                          <div class="col-xl-4 col-md-6">
                            <input type="password" class="form-control form-control-sm" name="password" required>
                            <div class="invalid-feedback">
                              กรุณากรอกช่องนี้.
                            </div>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-xl-4 offset-xl-4 col-md-4 offset-md-4">
                            <span class="text-check"></span>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัสผ่านอีกครั้ง</label>
                          <div class="col-xl-4 col-md-6">
                            <input type="password" class="form-control form-control-sm" name="password2" required>
                            <div class="invalid-feedback">
                              กรุณากรอกช่องนี้.
                            </div>
                          </div>
                        </div>
                        <div class="row justify-content-center mb-2">
                          <div class="col-xl-3 col-md-6">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                              <i class="fas fa-check pe-2"></i>ยืนยัน
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>
<script>
$(".text-check").hide();
$(document).on("keyup", "input[name='password2']", function() {
  $(".text-check").show();
  let password = $("input[name='password']").val();
  let password2 = $("input[name='password2']").val();

  if (password !== password2) {
    $(".text-check").text("รหัสผ่านไม่ตรงกัน").removeClass("text-primary").addClass("text-danger");
    $("button[type='submit']").prop("disabled", true);
  } else {
    $(".text-check").text("รหัสผ่านตรงกัน").removeClass("text-danger").addClass("text-primary");
    $("button[type='submit']").prop("disabled", false);
  }
});

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