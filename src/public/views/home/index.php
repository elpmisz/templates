<?php
$page = "index";
$group = "";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-body">
          <div class="row">
            <div class="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<div class="modal fade" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center d-block">
        <div class="modal-title text-bold h5"></div>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <div class="col-xl-3">
          <button type="button" class="btn btn-sm btn-danger w-100" data-bs-dismiss="modal">
            <i class="fa fa-times pe-2"></i> ปิด
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>
<script>
$(".calendar").fullCalendar({
  header: {
    left: "prev,next today",
    center: "title",
    right: "month,agendaWeek,agendaDay",
  },
  height: 600,
  lang: "th",
  googleCalendarApiKey: "AIzaSyAevjGgx2sSiGz0aI4uKT2E_vJcYa1JV7g",
  eventSources: [{
    googleCalendarId: "th.th#holiday@group.v.calendar.google.com",
    color: "#C70039"
  }],
  fixedWeekCount: false,
  eventLimit: 3,
  timeFormat: "H:mm",
  eventClick: function(event, element, view) {
    $(".modal-title").html(event.title);
    $(".modal-body").html(event.description);
    $(".modal").modal("show");
    if (event.url) {
      return false;
    }
  }
});
</script>