<?php include('db_connect.php') ?>
<?php
$twhere = "";
if($_SESSION['login_type'] != 1) {
    $twhere = " WHERE is_deleted = 'no' ";
}
?>
<!-- Info boxes -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            Welcome <?php echo $_SESSION['login_name'] ?>!
        </div>
    </div>
</div>
<hr>
<?php 
$where = "";
$where2 = "";

// Define where clauses based on user type
if ($_SESSION['login_type'] == 2) {
    $where = " WHERE is_deleted = 'no' AND manager_id = '{$_SESSION['login_id']}' ";
    $where2 = " WHERE p.is_deleted = 'no' AND p.manager_id = '{$_SESSION['login_id']}' ";
} elseif ($_SESSION['login_type'] == 3) {
    $where = " WHERE is_deleted = 'no' AND CONCAT('[', REPLACE(user_ids, ',', '],['), ']') LIKE '%[{$_SESSION['login_id']}]%' ";
    $where2 = " WHERE p.is_deleted = 'no' AND CONCAT('[', REPLACE(p.user_ids, ',', '],['), ']') LIKE '%[{$_SESSION['login_id']}]%' ";
} else {
    // Admin sees all projects including those marked as deleted
    $where = ""; // No additional conditions for Admin
    $where2 = " WHERE p.manager_id IS NOT NULL "; // Admin sees all tasks including those marked as deleted
}
?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Project Progress</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover" id="projectTable">
                        <colgroup>
                            <col width="5%">
                            <col width="30%">
                            <col width="35%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <th>#</th>
                            <th>Project</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Completed");
                            $qry = $conn->query("SELECT * FROM project_list $where ORDER BY name ASC");
                            while ($row = $qry->fetch_assoc()):
                                $prog = 0;
                                $tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']}")->num_rows;
                                $cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']} AND status = 3")->num_rows;
                                $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                                $prog = $prog > 0 ? number_format($prog, 2) : $prog;
                                $prod = $conn->query("SELECT * FROM user_productivity WHERE project_id = {$row['id']}")->num_rows;
                                if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                                    if ($prod > 0 || $cprog > 0)
                                        $row['status'] = 2;
                                    else
                                        $row['status'] = 1;
                                elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                                    $row['status'] = 4;
                                endif;
                            ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td>
                                    <a href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" 
                                    <?php if ($_SESSION['login_type'] != 1 && $row['status'] == 3) echo 'class="on-hold-project"'; ?>>
                                        <?php echo ucwords($row['name']) ?>
                                    </a>
                                    <br>
                                    <small>Due: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?></small>
                                </td>

                                <td class="project_progress">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $prog ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                                        </div>
                                    </div>
                                    <small><?php echo $prog ?>% Complete</small>
                                </td>
                                <td class="project-state">
                                    <?php
                                    if ($stat[$row['status']] == 'Pending') {
                                        echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                                    } elseif ($stat[$row['status']] == 'Started') {
                                        echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                                    } elseif ($stat[$row['status']] == 'On-Progress') {
                                        echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                                    } elseif ($stat[$row['status']] == 'On-Hold') {
                                        echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                                    } elseif ($stat[$row['status']] == 'Over Due') {
                                        echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                                    } elseif ($stat[$row['status']] == 'Completed') {
                                        echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($_SESSION['login_type'] != 1 && $row['status'] == 3): ?>
                                        <button class="btn btn-primary btn-sm" disabled>
                                            <i class="fas fa-folder"></i>
                                            View
                                        </button>
                                    <?php else: ?>
                                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>">
                                            <i class="fas fa-folder"></i>
                                            View
                                        </a>
                                    <?php endif; ?>
                                </td>

                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM project_list $where")->num_rows; ?></h3>
                        <p>Total Projects</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT t.*, p.name as pname, p.start_date, p.status as pstatus, p.end_date, p.id as pid FROM task_list t INNER JOIN project_list p ON p.id = t.project_id $where2")->num_rows; ?></h3>
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

<style>
    .on-hold-project {
        cursor: not-allowed;
    }
</style>

<script>
    $(document).ready(function(){
        $('#projectTable').dataTable();

        // Handle click event for non-admin users trying to view an On-Hold project
        $('#projectTable').on('click', '.on-hold-project', function(event){
            event.preventDefault();
            alert("This project is on-hold and waiting for admin to un-hold it. Thank you.");
        });
    });
</script>
