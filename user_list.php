<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="col-md-12">    
            <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
        </div>
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th> <!-- Added column for status -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $type = array('',"Admin","Hod","Employee","Project Manager");
                    $qry = $conn->query("SELECT u.*, CONCAT(u.firstname,' ',u.lastname) as name, d.department_name 
                     FROM users u 
                     LEFT JOIN departments d ON u.department_id = d.id 
                     WHERE u.id != '{$_SESSION['login_id']}' 
                     ORDER BY CONCAT(u.firstname,' ',u.lastname) ASC");

                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['name']) ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
                        <td><b><?php echo $type[$row['type']] ?></b></td>
                        <td><b><?php echo ucwords($row['department_name']) ?></b></td>
                        <td class="text-center">
                            <span class="badge <?php echo $row['status'] == 'active' ? 'badge-success' : 'badge-danger' ?> status-toggle" data-id="<?php echo $row['id'] ?>" data-status="<?php echo $row['status'] ?>">
                                <?php echo ucwords($row['status']) ?>
                            </span>
                        </td> <!-- Display status with badge -->
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              Action
                            </button>
                            <div class="dropdown-menu" >
                              <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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

        // Use event delegation to handle clicks for dynamic elements
        $(document).on('click', '.view_user', function(){
            uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).data('id'));
        });

        $(document).on('click', '.delete_user', function(){
            _conf("Are you sure to delete this user?", "delete_user", [$(this).data('id')]);
        });

        $(document).on('click', '.status-toggle', function(){
            let id = $(this).data('id');
            let currentStatus = $(this).data('status');
            let newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            updateStatus(id, newStatus, $(this));
        });
    });

    function updateStatus(id, status, element){
        start_load();
        $.ajax({
            url: 'ajax.php?action=update_status',
            method: 'POST',
            data: {id: id, status: status},
            success: function(resp){
                if(resp == 1){
                    element.data('status', status);
                    element.removeClass('badge-success badge-danger');
                    element.addClass(status === 'active' ? 'badge-success' : 'badge-danger');
                    element.text(status.charAt(0).toUpperCase() + status.slice(1));
                    alert_toast("Status successfully updated", 'success');
                } else {
                    alert_toast("An error occurred", 'danger');
                }
                end_load();
            }
        });
    }

    function delete_user(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_user',
            method: 'POST',
            data: {id: id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
