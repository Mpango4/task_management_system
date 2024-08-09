<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_department"><i class="fa fa-plus"></i> Add New Department</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Department Name</th>
                        <th>Department Leader</th>
                        <th>Description</th>
                        <th>Total Users</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT d.*, 
                                        (SELECT CONCAT(u.firstname, ' ', u.lastname) 
                                         FROM users u 
                                         WHERE u.department_id = d.id AND u.type = 2 
                                         LIMIT 1) as department_leader, 
                                        COUNT(u.id) as total_users 
                                        FROM departments d 
                                        LEFT JOIN users u ON d.id = u.department_id
                                        GROUP BY d.id");
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['department_name']) ?></b></td>
                        <td><b><?php echo ucwords($row['department_leader']) ?></b></td>
                        <td><?php echo $row['description'] ?></td>
                        <td class="text-center"><b><?php echo $row['total_users'] ?></b></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view_department" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./index.php?page=edit_department&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_department" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>   
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#list').dataTable();
        $('.view_department').click(function(){
            uni_modal("<i class='fa fa-id-card'></i> Department Details", "view_department.php?id=" + $(this).attr('data-id'));
        });
        $('.delete_department').click(function(){
            _conf("Are you sure to delete this department?", "delete_department", [$(this).attr('data-id')]);
        });
    });

    function delete_department(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_department',
            method: 'POST',
            data: {id: id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Department successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
