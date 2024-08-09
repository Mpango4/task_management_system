<?php
include('auth_session.php');

if (isset($_SESSION['login_id'])) {
    if(isset($_POST['key'])){
        include '../../db_connect.php';

        $key = "%" . $_POST['key'] . "%";

        $sql = "SELECT * FROM users
                WHERE firstname LIKE ? OR lastname LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $key, $key);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){ 
            while ($user = $result->fetch_assoc()) {
                if ($user['id'] != $_SESSION['login_id']) {
?>
                    <li class="list-group-item">
                    <a href="./index.php?page=chats&user=<?= $user['firstname'] ?>"


                           class="d-flex justify-content-between align-items-center p-2">
                            <div class="d-flex align-items-center">
                                <h3 class="fs-xs m-2"><?= $user['firstname'] ?></h3>
                            </div>
                        </a>
                    </li>
<?php
                }
            }
        } else {
?>
            <div class="alert alert-info text-center">
                <i class="fa fa-user-times d-block fs-big"></i>
                The user "<?= htmlspecialchars($_POST['key']) ?>" is not found.
            </div>
<?php
        }
    }
}
?>
