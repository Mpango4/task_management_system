<?php include 'db_connect.php'; ?>
<div class="col-lg-12">

    <div class="card card-outline card-success">
        <div class="col-md-12">    
            <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
        </div>
        <div class="card-header">
            <?php if($_SESSION['login_type'] != 2): ?>
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Add New Project</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-hover table-condensed table-responsive" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%"> <!-- New column for department -->
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>FROM</th>
                        <th>Project Started</th>
                        <th>Project Due Date</th>
                        <th>Project Status</th>
                        <th>Task Status</th>
                        <th>Action</th>
                        <!-- New column header -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $where = "";

                    if ($_SESSION['login_type'] == 2) {
                        $where = " WHERE user_id = '{$_SESSION['login_id']}' ";
                    }

                    $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "completed");
                    $qry = $conn->query("
                        SELECT t.*, p.name as pname, p.start_date, p.status as pstatus, p.end_date, p.id as pid, 
                        CONCAT(u.firstname, ' ', u.lastname) as pm_name, d.department_name as pm_department
                        FROM task_list t
                        INNER JOIN project_list p ON p.id = t.project_id
                        LEFT JOIN users u ON p.manager_id = u.id
                        LEFT JOIN departments d ON u.department_id = d.id
                        $where
                        ORDER BY p.name ASC
                    ");
                    while ($row = $qry->fetch_assoc()):
                        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                        $desc = strtr(html_entity_decode($row['description']), $trans);
                        $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
                        $tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['pid']}")->num_rows;
                        $cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['pid']} AND status = 3")->num_rows;
                        $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                        $prog = $prog > 0 ? number_format($prog, 2) : $prog;
                        $prod = $conn->query("SELECT * FROM user_productivity WHERE project_id = {$row['pid']}")->num_rows;
                        if ($row['pstatus'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                            if ($prod > 0 || $cprog > 0)
                                $row['pstatus'] = 2;
                            else
                                $row['pstatus'] = 1;
                        elseif ($row['pstatus'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                            $row['pstatus'] = 4;
                        endif;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td>
                            <p><b><?php echo ucwords($row['pname']) ?></b></p>
                        </td>
                        <td>
                            <p><b><?php echo ucwords($row['task']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
                        <td>
                            <?php echo ucwords($row['pm_department']) ?>: Dep
                        </td> <!-- New column data -->
                        <td><b><?php echo date("M d, Y", strtotime($row['start_date'])) ?></b></td>
                        <td><b><?php echo date("M d, Y", strtotime($row['end_date'])) ?></b></td>
                        <td class="text-center">
                            <?php
                              if ($stat[$row['pstatus']] == 'Pending') {
                              	echo "<span class='badge badge-secondary'>{$stat[$row['pstatus']]}</span>";
                              } elseif ($stat[$row['pstatus']] == 'Started') {
                              	echo "<span class='badge badge-primary'>{$stat[$row['pstatus']]}</span>";
                              } elseif ($stat[$row['pstatus']] == 'On-Progress') {
                              	echo "<span class='badge badge-info'>{$stat[$row['pstatus']]}</span>";
                              } elseif ($stat[$row['pstatus']] == 'On-Hold') {
                              	echo "<span class='badge badge-warning'>{$stat[$row['pstatus']]}</span>";
                              } elseif ($stat[$row['pstatus']] == 'Over Due') {
                              	echo "<span class='badge badge-danger'>{$stat[$row['pstatus']]}</span>";
                              } elseif ($stat[$row['pstatus']] == 'completed') {
                              	echo "<span class='badge badge-success'>{$stat[$row['pstatus']]}</span>";
                              }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if ($row['status'] == 1) {
                                echo "<span class='badge badge-secondary'>Pending</span>";
                            } elseif ($row['status'] == 2) {
                                echo "<span class='badge badge-primary'>On-Progress</span>";
                            } elseif ($row['status'] == 3) {
                                echo "<span class='badge badge-success'>completed</span>";
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">View</a> 
                                <a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Edit</a>
                                <a class="dropdown-item new_productivity" data-pid='<?php echo $row['pid'] ?>' data-tid='<?php echo $row['id'] ?>' data-task='<?php echo ucwords($row['task']) ?>' href="javascript:void(0)">Add Productivity</a>
                            </div>
                        </td>
                       
                    </tr>    
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    table p {
        margin: unset !important;
    }
    table td {
        vertical-align: middle !important;
    }
</style>
<script>
    $(document).ready(function(){
        $('#list').dataTable();
        $('.new_productivity').click(function(){
            uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"manage_progress.php?pid="+$(this).attr('data-pid')+"&tid="+$(this).attr('data-tid'),'large');
        });
        $('.view_task').click(function(){
            uni_modal("Task Details","view_task.php?id="+$(this).attr('data-id'),"mid-large");
        });
    });

    function delete_project($id){
        start_load();
        $.ajax({
            url:'ajax.php?action=delete_project',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted",'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
 