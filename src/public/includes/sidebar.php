<?php
$page = (!empty($page) ? $page : "");
$group = (!empty($group) ? $group : "");
?>
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php echo ($page === "index" ? "" : "collapsed") ?>" href="/home">
        <i class="fa fa-house"></i> <span>หน้าหลัก</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($group === "users" ? "" : "collapsed") ?>" data-bs-target="#users"
        data-bs-toggle="collapse" href="#">
        <i class="fa fa-user"></i> <span>ข้อมูลส่วนตัว</span>
        <i class="fa fa-chevron-down ms-auto"></i>
      </a>
      <ul id="users" class="nav-content <?php echo ($group === "users" ? "show" : "collapse") ?>">
        <li>
          <a class="nav-link <?php echo ($page === "profile" ? "active" : "collapsed") ?>" href="/users/profile">
            <i class="fa fa-circle"></i> <span>ประวัติส่วนตัว</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?php echo ($page === "leave" ? "active" : "collapsed") ?>" href="/leave">
            <i class="fa fa-circle"></i> <span>ประวัติการลา</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo ($group === "service" ? "" : "collapsed") ?>" data-bs-target="#service"
        data-bs-toggle="collapse" href="#">
        <i class="fa fa-list"></i> <span>บริการ</span>
        <?php
        $helpdesk_approve_auth = $Query->helpdesk_approve_auth([$user_id]);
        $helpdesk_process_auth = $Query->helpdesk_process_auth([$user_id]);
        $helpdesk_check_auth = $Query->helpdesk_check_auth([$user_id]);
        $helpdesk_approve_count = ($helpdesk_approve_auth > 0 ? $Query->helpdesk_approve_count() : 0);
        $helpdesk_process_count = ($helpdesk_process_auth > 0 ? $Query->helpdesk_process_count() : 0);
        $helpdesk_check_count = ($helpdesk_check_auth > 0 ? $Query->helpdesk_check_count() : 0);
        $helpdesk_total = $helpdesk_approve_count + $helpdesk_process_count + $helpdesk_check_count;
        if ($helpdesk_total > 0) :
          echo ($helpdesk_total === 0 ? ""
            : "<span class='badge rounded-pill text-bg-danger ms-2'>{$helpdesk_total}</span>");
        endif;
        ?>
        <i class="fa fa-chevron-down ms-auto"></i>
      </a>
      <ul id="service" class="nav-content <?php echo ($group === "service" ? "show" : "collapse") ?>">
        <li>
          <a class="nav-link <?php echo ($page === "helpdesk" ? "active" : "collapsed") ?>" href="/helpdesk">
            <i class="fa fa-circle"></i> <span>แจ้งปัญหาการใช้งาน</span>
            <?php
            if ($helpdesk_total > 0) :
              echo ($helpdesk_total === 0 ? "" :
                "<span class='badge rounded-pill text-bg-danger ms-2'>{$helpdesk_total}</span>");
            endif;
            ?>
          </a>
        </li>
      </ul>
    </li>

    <?php if ($user['level'] === 9) : ?>
    <li class="nav-item">
      <a class="nav-link <?php echo ($group === "system" ? "" : "collapsed") ?>" data-bs-target="#system"
        data-bs-toggle="collapse" href="#">
        <i class="fa fa-file-lines"></i> <span>ตั้งค่าระบบ</span>
        <i class="fa fa-chevron-down ms-auto"></i>
      </a>
      <ul id="system" class="nav-content <?php echo ($group === "system" ? "show" : "collapse") ?> ">
        <li>
          <a class="nav-link <?php echo ($page === "users" ? "active" : "collapsed") ?>" href="/users">
            <i class="fa fa-circle"></i> <span>ข้อมูลผู้ใช้งาน</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?php echo ($page === "machine" ? "active" : "collapsed") ?>" href="/machine">
            <i class="fa fa-circle"></i> <span>ข้อมูลอุปกรณ์คอมพิวเตอร์</span>
          </a>
        </li>
        <li>
          <a class="nav-link <?php echo ($page === "system" ? "active" : "collapsed") ?>" href="/system">
            <i class="fa fa-circle"></i> <span>ข้อมูลระบบ</span>
          </a>
        </li>
      </ul>
    </li>
    <?php endif; ?>
  </ul>
</aside>