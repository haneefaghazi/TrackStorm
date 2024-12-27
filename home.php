<?php include('db_connect.php') ?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
  $twhere = " ";
?>
<!-- Info boxes -->
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4>Welcome, <span style="font-weight: bolder;"><?php echo $_SESSION['login_name'] ?></span> !</h4>
      <p>Progress reports and details are showcased here, select the options on the sidebar for more details</p>
    </div>
  </div>
</div>
<hr>
<?php
$where = "";
if ($_SESSION['login_type'] == 2) {
  $where = " where manager_id = '{$_SESSION['login_id']}' ";
} elseif ($_SESSION['login_type'] == 3) {
  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
$where2 = "";
if ($_SESSION['login_type'] == 2) {
  $where2 = " where p.manager_id = '{$_SESSION['login_id']}' ";
} elseif ($_SESSION['login_type'] == 3) {
  $where2 = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
?>
<div class="row">
  <!-- Project Progress Section -->
  <div class="col-md-8">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <b>Progress Report</b>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <colgroup>
              <col width="5%">
              <col width="30%">
              <col width="35%">
              <col width="15%">
              <col width="15%">
            </colgroup>
            <thead>
              <th>No.</th>
              <th>Project</th>
              <th>Progress</th>
              <th>Status</th>
              <th></th>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
              $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
              while ($row = $qry->fetch_assoc()) :
                $prog = 0;
                $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                $prog = $prog > 0 ? number_format($prog, 2) : $prog;
                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])) :
                  if ($prod > 0 || $cprog > 0)
                    $row['status'] = 2;
                  else
                    $row['status'] = 1;
                elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])) :
                  $row['status'] = 4;
                endif;
              ?>
                <tr>
                  <td><?php echo $i++ ?></td>
                  <td>
                    <a><?php echo ucwords($row['name']) ?></a><br>
                    <small>Due: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?></small>
                  </td>
                  <td class="project_progress">
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $prog ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                      </div>
                    </div>
                    <small><?php echo $prog ?>% Complete</small>
                  </td>
                  <td class="project-state">
                    <?php
                    $badge_class = "";
                    switch ($stat[$row['status']]) {
                      case 'Pending':
                        $badge_class = 'badge-secondary';
                        break;
                      case 'Started':
                        $badge_class = 'badge-primary';
                        break;
                      case 'On-Progress':
                        $badge_class = 'badge-info';
                        break;
                      case 'On-Hold':
                        $badge_class = 'badge-warning';
                        break;
                      case 'Over Due':
                        $badge_class = 'badge-danger';
                        break;
                      case 'Done':
                        $badge_class = 'badge-success';
                        break;
                    }
                    echo "<span class='badge {$badge_class}'>{$stat[$row['status']]}</span>";
                    ?>
                  </td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>">
                      <i class="fas fa-folder"></i> View
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Projects and Tasks Section -->
  <div class="col-md-4">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-12">
        <div class="small-box bg-dark shadow-sm border">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT * FROM project_list $where")->num_rows; ?></h3>
            <p>Total Projects</p>
          </div>
          <div class="icon">
            <i class="fa fa-industry"></i>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-12">
        <div class="small-box bg-secondary shadow-sm border">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
            <p>Total Tasks</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>