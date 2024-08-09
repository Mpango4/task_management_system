<?php
include 'db_connect.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT s.*, d.department_name FROM stakeholders s LEFT JOIN departments d ON s.department_id = d.id WHERE s.id = ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <p><b>Company Name: </b><?php echo ucwords($company_name) ?></p>
            <p><b>Address: </b><?php echo $address ?></p>
            <p><b>Location: </b><?php echo $location ?></p>
            <p><b>Email: </b><?php echo $email ?></p>
            <p><b>Phone: </b><?php echo $phone ?></p>
            <p><b>Department: </b><?php echo $department_name ?></p>
        </div>
    </div>
</div>
