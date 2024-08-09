<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
            </div>
            <form action="" id="manage_user">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label for="" class="control-label">First Name</label>
                            <input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Department</label>
                            <select name="department_id" id="department_id" class="custom-select custom-select-sm">
                                <option value="">Select Department</option>
                                <?php 
                                $qry = $conn->query("SELECT * FROM departments");
                                while($row = $qry->fetch_assoc()):
                                ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['department_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <?php if ($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 2): ?>
                        <div class="form-group">
                            <label for="" class="control-label">User Role</label>
                            <select name="type" id="type" class="custom-select custom-select-sm">
                                <?php if ($_SESSION['login_type'] == 1): ?>
                                <option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Hod</option>
                                <?php endif; ?>
                                <option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Employee</option>
                            </select>
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="type" value="3">
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="" class="control-label">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar : '' ?>" alt="Avatar" id="cimg" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
                            <small id="msg"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? "required" : '' ?> onkeyup="validatePassword()">
                            <small><i><?php echo isset($id) ? "Leave this blank if you don't want to change your password" : '' ?></i></small>
                            <small id="password_hint" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label class="label control-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($id) ? 'required' : '' ?> onkeyup="validatePassword()">
                            <small id="pass_match" data-status=''></small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2">Save</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100%;
    }
</style>

<script>
    function validatePassword() {
        var pass = $('[name="password"]').val();
        var cpass = $('[name="cpass"]').val();
        var passHint = $('#password_hint');
        var passMatch = $('#pass_match');
        var regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (pass == '' || cpass == '') {
            passMatch.attr('data-status', '');
            passHint.html('');
        } else {
            if (pass.length < 8) {
                passHint.html('<i class="text-danger">Password must be at least 8 characters long.</i>');
                passMatch.attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
            } else if (!regex.test(pass)) {
                passHint.html('<i class="text-danger">Password must contain at least one letter, one number, and one special character.</i>');
                passMatch.attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
            } else {
                passHint.html('<i class="text-success">Password meets the criteria.</i>');
                if (pass == cpass) {
                    passMatch.attr('data-status', '1').html('<i class="text-success">Password Matched.</i>');
                } else {
                    passMatch.attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
                }
            }
        }
    }

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage_user').submit(function(e) {
        e.preventDefault();
        $('input').removeClass("border-danger");
        start_load();
        $('#msg').html('');
        if ($('[name="password"]').val() != '' && $('[name="cpass"]').val() != '') {
            if ($('#pass_match').attr('data-status') != 1) {
                if ($("[name='password']").val() != '') {
                    $('[name="password"],[name="cpass"]').addClass("border-danger");
                    end_load();
                    return false;
                }
            }
        }
        $.ajax({
            url: 'ajax.php?action=save_user',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Data successfully saved.', "success");
                    setTimeout(function() {
                        location.replace('index.php?page=user_list')
                    }, 750)
                } else if (resp == 2) {
                    $('#msg').html("<div class='alert alert-danger'>Email already exists.</div>");
                    $('[name="email"]').addClass("border-danger");
                    end_load();
                }
            }
        })
    })
</script>
