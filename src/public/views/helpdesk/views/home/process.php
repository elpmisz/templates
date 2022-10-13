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
$checklists = $Request->request_checklist([$row['sub_id']]);
$processes = $Request->process_fetch([$request_id]);
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
          <form action="/helpdesk/request/process" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
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
                <div class="row mb-2">
                  <label class="col-xl-4 col-md-4 col-form-label text-xl-end">เบอร์ติดต่อ</label>
                  <div class="col-xl-8 col-md-6">
                    <span class="form-control form-control-sm"><?php echo $row['contact'] ?></span>
                  </div>
                </div>
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

            <?php if ($row['hardware'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">อุปกรณ์</label>
                <div class="col-xl-6 col-md-8">
                  <span class="form-control form-control-sm"><?php echo $row['hardware_name'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['calendar1'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                <div class="col-xl-3 col-md-6">
                  <span class="form-control form-control-sm"><?php echo $row['date1'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['calendar2'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่</label>
                <div class="col-xl-5 col-md-7">
                  <span class="form-control form-control-sm"><?php echo $row['date2'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายละเอียด</label>
              <div class="col-xl-5 col-md-7">
                <textarea class="form-control form-control-sm" rows="3" readonly><?php echo $row['text'] ?></textarea>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">ไฟล์แนบ</label>
              <div class="col-xl-8 col-md-8">
                <table class="table table-sm">
                  <tbody>
                    <?php foreach ($uploads as $key => $upload) : $key++; ?>
                      <tr>
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
            </div>

            <?php if ($row['checklist'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายการตรวจสอบ</label>
                <div class="col-xl-4 col-md-4">
                  <table>
                    <tbody>
                      <?php foreach ($checklists as $checklist) : ?>
                        <tr>
                          <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn_checklist w-100" id="<?php echo $checklist['id'] ?>"><i class="fa fa-file-alt pe-2"></i><?php echo $checklist['name'] ?></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            <?php endif; ?>

            <?php if (in_array($row['request_status'], [2, 3, 4])) : ?>
              <div class="col-xl-4 col-md-4 mb-2">
                <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block btn_process">
                  <i class="fa fa-plus pe-2"></i>เพิ่มการดำเนินการ
                </a>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover">
                  <thead>
                    <tr>
                      <th width="10%">สถานะ</th>
                      <th width="10%">วันที่ดำเนินการ</th>
                      <th width="40%">การดำเนินการ</th>
                      <th width="10%">กำหนดแล้วเสร็จ</th>
                      <th width="10%">ผู้ดำเนินการ</th>
                      <th width="10%">หมายเหตุ</th>
                      <th width="10%">เอกสารแนบ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $process_count = COUNT($processes);
                    if ($process_count === 0) :
                      echo "<tr><td colspan='7' class='text-center'>-- ไม่พบข้อมูล --</td></tr>";
                    else :
                      foreach ($processes as $process) :
                    ?>
                        <tr>
                          <td><?php echo $process['status'] ?></td>
                          <td><?php echo $process['created'] ?></td>
                          <td><?php echo $process['text'] ?></td>
                          <td><?php echo $process['end'] ?></td>
                          <td><?php echo $process['user_id'] ?></td>
                          <td><?php echo $process['remark'] ?></td>
                          <td><?php echo $process['file'] ?></td>
                        </tr>
                    <?php
                      endforeach;
                    endif;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-xl-4 col-md-6 mb-2">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
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

<div class="modal fade form_checklist" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header mx-auto">
        <h5 class="modal-title">รายการตรวจสอบ</h5>
      </div>
      <div class="modal-body">
        <form action="/helpdesk/request/updatechecklist" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

          <div class="row mb-2" style="display: none;">
            <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รหัส</label>
            <div class="col-xl-6 col-md-6">
              <input type="text" class="form-control form-control-sm" name="request_id" value="<?php echo $row['request_id'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <div class="table-responsive">
              <table class="table table-bordered table-sm table_checklist"></table>
            </div>
          </div>

          <div class="form-group row justify-content-center">
            <div class="col-xl-3 col-md-6 mb-2">
              <button type="submit" class="btn btn-success btn-sm w-100">
                <i class="fa fa-check pe-2"></i>ยืนยัน
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

<?php
include_once(__DIR__ . "/../../../../includes/footer.php");
?>
<script>
  $(document).on("click", ".btn_checklist", function() {
    let service = $(this).prop("id");

    $.ajax({
      url: '/helpdesk/request/checklist',
      method: 'POST',
      data: {
        service: service
      },
      dataType: 'json',
      success: function(data) {
        console.log(data)
        if (data.length > 0) {
          $(".form_checklist").modal("show");
          let table = '<thead><tr><th width="40%">ชื่อ</th><th width="10%">ดำเนินการ</th><th width="50%">เพิ่มเติม</th></tr></thead>';
          table += '<tbody>';

          $.each(data, function(i, d) {
            table += '<tr>';
            table += '<td class="text-left"><input type="hidden" name="id[]" value="' + d.id + '">' + d.name + '</td>';
            table += '<td class="text-center"><input type="hidden" name="status[' + i + ']" value="0" /><input type="checkbox" name="status[' + i + ']" value="1"></td>';
            table += '<td class="text-left"><input type="text" class="form-control form-control-sm" name="text[]"></td>';
            table += '</tr>';
          });

          table += '</tbody>';

          $('.table_checklist').html(table);
        } else {
          $(".form_checklist").modal("hide");
        }
      }
    });
  });
</script>