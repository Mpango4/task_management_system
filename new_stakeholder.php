<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
            </div>
            <form action="" id="manage_stakeholder">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <input type="hidden" name="action" value="save_stakeholder">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label for="" class="control-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control form-control-sm" required value="<?php echo isset($company_name) ? $company_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Address</label>
                            <input type="text" name="address" class="form-control form-control-sm" required value="<?php echo isset($address) ? $address : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Location</label>
                            <input type="text" name="location" class="form-control form-control-sm" required value="<?php echo isset($location) ? $location : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Department</label>
                            <select name="department_id" id="department_id" class="custom-select custom-select-sm">
                                <option value="">Select Department</option>
                                <?php 
                                $qry = $conn->query("SELECT * FROM departments WHERE department_name != 'PLANNING'");
                                while($row = $qry->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['department_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
                            <small id="msg"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone</label>
                            <input type="text" class="form-control form-control-sm" name="phone" required value="<?php echo isset($phone) ? $phone : '' ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2">Save</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=stakeholders_list'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#manage_stakeholder').submit(function(e){
    e.preventDefault();
    $('input').removeClass("border-danger");
    start_load();
    $('#msg').html('');

    $.ajax({
        url: 'save_stakeholder.php',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp){
            resp = JSON.parse(resp);
            if(resp.status == "success"){
                alert_toast(resp.message, "success");
                setTimeout(function(){
                    location.replace('index.php?page=stakeholders_list');
                }, 750);
            } else {
                $('#msg').html("<div class='alert alert-danger'>" + resp.message + "</div>");
                end_load();
            }
        }
    });
});
</script>