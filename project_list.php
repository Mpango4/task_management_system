<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="col-md-12">    
            <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
        </div>
        <div class="card-header">
            <?php if($_SESSION['login_type'] != 3): ?>
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Add New project</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <table class="table table-hover table-condensed" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="30%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <?php if($_SESSION['login_type'] == 1): // Admin ?>
                    <col width="10%">
                    <?php endif; ?>
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Project</th>
                        <th>Date Started</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <?php if($_SESSION['login_type'] == 1): // Admin ?>
                        <th>Is Deleted</th>
                        <?php endif; ?>
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Completed");
                    $where = "";

                    // Update the status of overdue projects
                    $update_status_query = "UPDATE project_list SET status = 4 WHERE status = 0 AND end_date < CURDATE()";
                    $conn->query($update_status_query);

                    if ($_SESSION['login_type'] == 2) {
                        $where = " WHERE is_deleted = 'no' AND manager_id = '{$_SESSION['login_id']}' ";
                    } elseif ($_SESSION['login_type'] == 3) {
                        $where = " WHERE is_deleted = 'no' AND CONCAT('[', REPLACE(user_ids, ',', '],['), ']') LIKE '%[{$_SESSION['login_id']}]%' ";
                    }

                    $qry = $conn->query("SELECT * FROM project_list $where ORDER BY name ASC");
                    while ($row = $qry->fetch_assoc()):
                        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                        $desc = strtr(html_entity_decode($row['description']), $trans);
                        $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

                        $tprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']}")->num_rows;
                        $cprog = $conn->query("SELECT * FROM task_list WHERE project_id = {$row['id']} AND status = 3")->num_rows;
                        $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                        $prog = $prog > 0 ? number_format($prog, 2) : $prog;
                        $prod = $conn->query("SELECT * FROM user_productivity WHERE project_id = {$row['id']}")->num_rows;

                        // Update project status based on progress
                        if ($prog == 100) {
                            $row['status'] = 5; // Completed
                            $update_completed_status_query = "UPDATE project_list SET status = 5 WHERE id = {$row['id']}";
                            $conn->query($update_completed_status_query);
                        } elseif ($prog > 0 && $prog < 100) {
                            $row['status'] = 2; // On-Progress
                            $update_on_progress_status_query = "UPDATE project_list SET status = 2 WHERE id = {$row['id']}";
                            $conn->query($update_on_progress_status_query);
                        }

                        if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                            if ($prod > 0 || $cprog > 0) {
                                $row['status'] = 2;
                            } else {
                                $row['status'] = 1;
                            }
                        elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                            $row['status'] = 4;
                        endif;
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td>
                            <p><b><?php echo ucwords($row['name']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
                        <td><b><?php echo date("M d, Y", strtotime($row['start_date'])) ?></b></td>
                        <td><b><?php echo date("M d, Y", strtotime($row['end_date'])) ?></b></td>
                        <td class="text-center">
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
                        <?php if($_SESSION['login_type'] == 1): // Admin ?>
                        <td class="text-center">
                            <?php echo $row['is_deleted'] ?>
                        </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <?php if ($row['status'] == 3 && $_SESSION['login_type'] != 1): // On-Hold and not Admin ?>
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info">
                                <i class="fa fa-lock"></i> Actions Disabled
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <?php if ($_SESSION['login_type'] != 3): ?>
                                <?php if ($stat[$row['status']] != 'Over Due' || $_SESSION['login_type'] != 2): ?>
                                <a class="dropdown-item" href="./index.php?page=edit_project&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <?php endif; ?>
                                <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
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
    // $(document).ready(function(){
    //     $('#list').dataTable()

    //     $('.delete_project').click(function(){
    //         const projectId = $(this).attr('data-id');
    //         const projectStatus = $(this).closest('tr').find('td:nth-child(5) .badge').text();

    //         if (projectStatus === 'On-Hold') {
    //             alert("You stoped this project un-hold it. Thank you..");
    //         } else {
    //             _conf("Are you sure to delete this project?", "delete_project", [projectId]);
    //         }
    //     });

    //     $('.view_project').click(function(){
    //         const projectStatus = $(this).closest('tr').find('td:nth-child(5) .badge').text();

    //         if (projectStatus === 'On-Hold') {
    //             alert("You stoped this project un-hold it. Thank you.");
    //             return false; // Prevent the default action
    //         }
    //     });

    //     $('.dropdown-item').click(function(){
    //         const projectStatus = $(this).closest('tr').find('td:nth-child(5) .badge').text();

    //         if ($(this).hasClass('delete_project') && projectStatus === 'On-Hold') {
    //             alert("You stoped this project un-hold it. Thank you.");
    //             return false; // Prevent the default action
    //         }

    //         if ($(this).hasClass('view_project') && projectStatus === 'On-Hold') {
    //             alert("You stoped this project un-hold it. Thank you.");
    //             return false; // Prevent the default action
    //         }
    //     });
    // });

    function delete_project($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_project',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
