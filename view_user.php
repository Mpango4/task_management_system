<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$type_arr = array('',"Admin","Project Manager","Employee","Hod");
	$qry = $conn->query("SELECT u.*, concat(u.firstname,' ',u.lastname) as name, d.department_name FROM users u LEFT JOIN departments d ON u.department_id = d.id WHERE u.id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
		<div class="widget-user-header bg-dark">
			<h3 class="widget-user-username"><?php echo ucwords($name) ?></h3>
			<h5 class="widget-user-desc"><?php echo $email ?></h5>
		</div>
		<div class="widget-user-image">
			<?php if(empty($avatar) || (!empty($avatar) && !is_file('assets/uploads/'.$avatar))): ?>
			<span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px">
				<h4><?php echo strtoupper(substr($firstname, 0,1).substr($lastname, 0,1)) ?></h4>
			</span>
			<?php else: ?>
			<img class="img-circle elevation-2" src="assets/uploads/<?php echo $avatar ?>" alt="User Avatar"  style="width: 90px;height:90px;object-fit: cover">
			<?php endif ?>
		</div>
		<div class="card-footer">
			<div class="container-fluid">
				<dl>
					<dt>Role</dt>
					<dd><?php echo $type_arr[$type] ?></dd>
					<dt>Department</dt> <!-- Added Department -->
					<dd><?php echo ucwords($department_name) ?></dd> <!-- Display Department Name -->
				</dl>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
