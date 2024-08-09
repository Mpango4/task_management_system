<?php 
session_start();
include('./db_connect.php');
ob_start();

// Fetch and store system settings in session
$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach($system as $k => $v){
    $_SESSION['system'][$k] = $v;
}
ob_end_flush();

// Redirect to home if already logged in
if(isset($_SESSION['login_id'])) {
    header("location:index.php?page=home");
    exit();
}

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            background: url('kasulu.png') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
        }
        .left {
            padding: 40px;
            flex: 1;
        }
        .left h2 {
            margin-bottom: 20px;
            color: #555;
        }
        .left input[type="email"], .left input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .left button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .left button:hover {
            background-color: #8bb48d;
        }
        .left a {
            display: block;
            margin-top: 10px;
            color: #999;
            text-decoration: none;
        }
        .right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FFF;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            background-color: #18af22;
            text-align: center;
        }
        .right p {
            font-size: 16px;
            font-weight: normal;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h2>Login to your account</h2>
            <form id="login-form">
                <input type="email" name="email" placeholder="12348@gmail.com" required>
                <input type="password" name="password" placeholder="••••••" required>
                <button type="submit">Login</button>
                <a href="#">Forget password?</a>
            </form>
        </div>
        <div class="right">
            KASULU TOWN COUNCIL (KTC) <br>
            TASK MANAGEMENT SYSTEM (KTMS)
            <p>Shall be fair, open, truthful, honest and conduct in such a manner that will protect the Council’s integrity.</p>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_load(); // Ensure start_load() function is defined
            if($(this).find('.alert-danger').length > 0)
                $(this).find('.alert-danger').remove();
            
            $.ajax({
                url: 'ajax.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                error: function(err){
                    console.log(err);
                    end_load(); // Ensure end_load() function is defined
                },
                success: function(resp){
                    if(resp == 1){
                        location.href = 'index.php?page=home';
                    } else if(resp == 3){
                        $('#login-form').prepend('<div class="alert alert-danger">Your account is inactive. Please contact the administrator.</div>');
                        end_load(); // Ensure end_load() function is defined
                    } else {
                        $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                        end_load(); // Ensure end_load() function is defined
                    }
                }
            });
        });
    });

    function start_load(){
        // Example: Show a loading spinner or overlay
        $('body').append('<div id="overlay"><div class="spinner"></div></div>');
    }

    function end_load(){
        // Example: Hide the loading spinner or overlay
        $('#overlay').remove();
    }
</script>
</body>
</html>
<?php include 'footer.php'; ?>
