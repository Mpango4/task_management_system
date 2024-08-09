<?php include 'db_connect.php' ?>
<div class="col-md-12">
    <div class="card card-outline card-success">
        <div class="col-md-12">    
            <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
        </div>
        <div class="card-header">
            <b>Project Progress</b>
            <div class="card-tools">
                <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" id="printable">
                <table class="table m-0 table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Project</th>
                        <th>Task Details</th> <!-- New column for task details -->
                        <th>Total Tasks</th> <!-- Updated column for total tasks -->
                        <th>Completed Task</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Department</th> <!-- New column for department -->
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "completed");
                    $where = "";
                    if ($_SESSION['login_type'] == 2) {
                        $where = " WHERE manager_id = '{$_SESSION['login_id']}' ";
                    } elseif ($_SESSION['login_type'] == 4) {
                        $where = " WHERE CONCAT('[', REPLACE(user_ids, ',', '],['), ']') LIKE '%[{$_SESSION['login_id']}]%' ";
                    }
                    $qry = $conn->query("
                        SELECT p.*, CONCAT(u.firstname, ' ', u.lastname) as pm_name, d.department_name as pm_department 
                        FROM project_list p
                        LEFT JOIN users u ON p.manager_id = u.id
                        LEFT JOIN departments d ON u.department_id = d.id
                        $where
                        ORDER BY p.name ASC
                    ");
                    while ($row = $qry->fetch_assoc()):
                        $tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']}")->num_rows;
                        $cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']} AND status = 3")->num_rows;
                        $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                        $prog = $prog > 0 ? number_format($prog, 2) : $prog;

                        // Fetch tasks for the current project
                        $tasks_qry = $conn->query("SELECT task FROM task_list WHERE project_id = {$row['id']}");
                        $tasks = [];
                        while ($task_row = $tasks_qry->fetch_assoc()) {
                            $tasks[] = $task_row['task'];
                        }
                        $tasks_list = '<ul>';
                        foreach ($tasks as $task) {
                            $tasks_list .= '<li>' . htmlspecialchars($task) . '</li>';
                        }
                        $tasks_list .= '</ul>';
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td>
                            <a>
                                <?php echo ucwords($row['name']) ?>
                            </a>
                            <br>
                            <small>
                                Due: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <?php echo $tasks_list; ?>
                        </td> <!-- New column for task details -->
                        <td class="text-center">
                            <?php echo number_format($tprog) ?>
                        </td> <!-- Updated column for total tasks -->
                        <td class="text-center">
                            <?php echo number_format($cprog) ?>
                        </td>
                        <td class="project_progress">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $prog ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                                </div>
                            </div>
                            <small>
                                <?php echo $prog ?>% Complete
                            </small>
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
                            } elseif ($stat[$row['status']] == 'completed') {
                                echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo ucwords($row['pm_department']) ?>
                        </td> <!-- New column for department -->
                    </tr>    
                    <?php endwhile; ?>
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#print').click(function(){
        start_load()
        var _h = $('head').clone()
        var _p = $('#printable').clone()
        var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date('F d, Y') ?>)</b></p>"
        _p.prepend(_d)
        _p.prepend(_h)
        var nw = window.open("", "", "width=900,height=600")
        nw.document.write(_p.html())
        nw.document.close()
        nw.print()
        setTimeout(function(){
            nw.close()
            end_load()
        }, 750)
    })
</script>
