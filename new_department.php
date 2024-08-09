<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
            </div>
            <form id="manage_department">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-12 border-right">
                        <div class="form-group">
                            <label for="" class="control-label">Department Name</label>
                            <input type="text" name="department_name" class="form-control form-control-sm" required value="<?php echo isset($department_name) ? $department_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Description</label>
                            <textarea name="description" class="form-control form-control-sm" rows="5" required><?php echo isset($description) ? $description : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href = 'index.php?page=department_list'">Cancel</button>
                </div>
            </form>
            <div id="msg"></div> <!-- Display message here -->
        </div>
    </div>
</div>
<style>
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#manage_department').submit(function(e){
            e.preventDefault();
            $('input, textarea').removeClass("border-danger");
            start_load();
            $('#msg').html('');
            
            // Create FormData object from form
            var formData = new FormData($(this)[0]);

            $.ajax({
                //url: 'ajax.php?action=save_department',
                url: 'save_department.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(resp){
                    if (resp == 1) {
                        alert_toast('Data successfully saved.', "success");
                        setTimeout(function(){
                            location.replace('index.php?page=department_list');
                        }, 750);
                    } else if (resp == -2) {
                        $('#msg').html("<div class='alert alert-danger'>Department name already exists.</div>");
                        $('[name="department_name"]').addClass("border-danger");
                        end_load();
                    } else {
                        $('#msg').html("<div class='alert alert-danger'>Failed to save department data.</div>");
                        end_load();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#msg').html("<div class='alert alert-danger'>Error: " + xhr.responseText + "</div>");
                    end_load();
                }
            });
        });
    });
</script>
