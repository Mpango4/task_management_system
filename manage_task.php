<?php 
session_start();
$department_id = $_SESSION['login_department_id'];
$department_name = $_SESSION['login_department'];
$login_type = $_SESSION['login_type']; // Assuming you have this in session

include 'db_connect.php';

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>

<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" value="<?php echo isset($task) ? $task : '' ?>" <?php echo $login_type == 3 ? 'readonly' : 'required' ?>>
		</div>
		
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="" cols="30" rows="10" class="summernote form-control" <?php echo $login_type == 3 ? 'readonly' : '' ?>>
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		
		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Pending</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>On-Progress</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Completed</option>
			</select>
		</div>

		<div class="form-group">
			<label for="">Task Performer</label>
			<select name="user_id" id="user_id" class="custom-select custom-select-sm" <?php echo $login_type == 3 ? 'disabled' : '' ?>>
				<option value="" disabled selected>Select user</option>
				<?php
				$users  = $conn->query("SELECT u.*, CONCAT(u.firstname, ' ', u.lastname) as name, d.department_name 
				FROM users u 
				LEFT JOIN departments d ON u.department_id = d.id 
				WHERE u.id != '{$_SESSION['login_id']}' 
				AND u.department_id = $department_id 
				ORDER BY CONCAT(u.firstname, ' ', u.lastname) ASC");


				while($row = $users->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($user_id) && $user_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				[ 'style', [ 'style' ] ],
				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				[ 'fontname', [ 'fontname' ] ],
				[ 'fontsize', [ 'fontsize' ] ],
				[ 'color', [ 'color' ] ],
				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				[ 'table', [ 'table' ] ],
				[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
			]
		});
		
		<?php if($login_type == 3): ?>
			$('.summernote').summernote('disable');
		<?php endif; ?>
	});
    
	$('#manage-task').submit(function(e){
		e.preventDefault();
		start_load();
		$.ajax({
			url:'ajax.php?action=save_task',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload();
					},1500);
				}
			}
		});
	});
</script>
