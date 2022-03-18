<?php
require_once ('init.php');
require_once('functions.php');
require_once('classes/Database.php');

session_start();


//INIT GLOBAL VARIABLES
Globals::$database = new Database();
Globals::$today = date("Y-m-d H:i:s");
Globals::$subjectEventTypes = array('exercise', 'lecture', 'activity', 'test', 'exam');

//INIT VARIABLES
$username = "";
$email = "";
$name = "";
$second_name = "";
$errors = array();

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header('location: login.php');
}

if (isset($_SESSION['user'])) {
    Globals::$user = Globals::$database->getUser_ID($_SESSION['user']);
    Globals::$person = Globals::$database->getPerson_ID($_SESSION['user']);
} else if (Globals::$path != "login") {
    header('location: login.php');

}


// REGISTER USER
if (isset($_POST['method']) && $_POST['method'] === 'reg') {
    // receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_1 = $_POST['password1'];
    $password_2 = $_POST['password2'];
    $name = $_POST['name'];
    $second_name = $_POST['second_name'];
    $accepted = $_POST['accept'];


    if (empty($username)) {
        $errors[] = "Username is required!";
    }

    if (empty($name)) {
        $errors[] = "Name is required!";
    }

    if (empty($second_name)) {
        $errors[] = "Second name is required!";
    }

    if (empty($email)) {
        $errors[] = "Email is required!";
    }
    if (empty($password_1)) {
        $errors[] = "Password is required!";
    }
    if (empty($password_2)) {
        $errors[] = "Repeat password is required!";
    }

    $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

    if (password_verify($password_1, $hash)) {
        $errors[] = "Password has wrong characters!";
    }

    if (strlen($password_1) < 8) {
        $errors[] = "Password is too short!";
    }

    if ($password_1 != $password_2) {
        $errors[] = "Password does not match!";
    }

    if ($password_1 != true) {
        $errors[] = "You need to agree to terms!";
    }

    $user_check_query = "SELECT * FROM user WHERE name='$username'";
    $result = Globals::$database->getResult($user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if (strcasecmp($user['name'], $username) == 0) {
            $errors[] = "Username already exist!";
        }
    }

    $user_check_query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = Globals::$database->getResult($user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if (strcasecmp($user['email'], $email) === 0) {
            $errors[] = "Email already exist!";
        }
    }

    $success = false;
    if (count($errors) === 0) {
        $password = sha1($password_1);

        $query = "INSERT INTO user (name, password, email, accepted)
  			  VALUES('$username','$password', '$email', 0)";
        $result = Globals::$database->getResult($query);
        $query = "SELECT MAX(id_user) as id FROM user";
        $result2 = Globals::$database->getResult($query);
        $id = $result2->fetch_assoc()['id'];
        $query = "INSERT INTO person (id_person, id_user, name, second_name)
  			  VALUES('$id','$id', '$name', '$second_name')";
        $result3 = Globals::$database->getResult($query);
        if ($row = (mysqli_fetch_assoc($result) && $row = mysqli_fetch_assoc($result3))) {
            $errors[] = "You are successfully registered!";
            $success = true;

        } else {
            $errors[] = "Server Error!";
        }

    }
    echo "I am here";
    if (!$success) {
        foreach ($errors as $error) {
            ?>
            <div id="errors" class="m-2 alert alert-danger" role="alert">
                <?php
                echo $error;
                ?>
            </div>
            <?php
        }
    } else {
        foreach ($errors as $error) {
            ?>
            <div id="errors" class="m-2 alert alert-success" role="alert">
                <?php
                echo $error;
                ?>
            </div>
            <?php
        }
    }
}

// LOGIN USER
if (isset($_POST['log_user'])) {
    $username = mysqli_real_escape_string(Globals::$database->db, $_POST['name']);
    $password = mysqli_real_escape_string(Globals::$database->db, $_POST['password']);

    if (empty($username)) {
        $errors[] = "Username or email is required!";
    }
    if (empty($password)) {
        $errors[] = "Password is required!";
    }

    if (count($errors) === 0) {
        $password = sha1($password);
        $query = "SELECT * FROM user WHERE (name='$username' OR email='$username')  AND password='$password'";
        $result = Globals::$database->getResult($query);
        $accepted = 0;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id_user = $row["id_user"];
                $accepted = $row['accepted'];
            }
            if ($accepted === 0) {
                $errors[] = "This account is waiting to be accepted!";
                return;
            }


        } else {
            $errors[] = "Wrong username or password";
            return;
        }


        $_SESSION['user'] = $id_user;
        $_SESSION['success'] = "Successfully sign in!";
        header('location: index.php?page=dashboard');


        $errors[] = "You are already logged in on other device";
        exit;

    }

}
?>
