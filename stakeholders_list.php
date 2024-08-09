<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="col-md-12">    
            <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
        </div>
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_stakeholder"><i class="fa fa-plus"></i> Add New Stakeholder</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th> <!-- Added column for department -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT s.*, d.department_name FROM stakeholders s LEFT JOIN departments d ON s.department_id = d.id ORDER BY s.company_name ASC");
                    while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['company_name']) ?></b></td>
                        <td><b><?php echo $row['address'] ?></b></td>
                        <td><b><?php echo $row['location'] ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
                        <td><b><?php echo $row['phone'] ?></b></td>
                        <td><b><?php echo ucwords($row['department_name']) ?></b></td> <!-- Display department -->
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              Action
                            </button>
                            <div class="dropdown-menu" >
                              <a class="dropdown-item view_stakeholder" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="./index.php?page=edit_stakeholder&id=<?php echo $row['id'] ?>">Edit</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item delete_stakeholder" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
        $('.view_stakeholder').click(function(){
            uni_modal("<i class='fa fa-id-card'></i> Stakeholder Details","view_stakeholder.php?id="+$(this).attr('data-id'));
        });
        $('.delete_stakeholder').click(function(){
            _conf("Are you sure to delete this stakeholder?","delete_stakeholder",[$(this).attr('data-id')]);
        });
    });

    function delete_stakeholder(id){
        start_load();
        $.ajax({
            url: 'delete_stakeholder.php',
            method: 'POST',
            data: {
                action: 'delete_stakeholder',
                id: id
            },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("An error occurred", 'danger');
                    end_load();
                }
            }
        });
    }
</script>
