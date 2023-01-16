
<?php require('./include/header.php');

 $_SESSION['page'] = 'About';

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

include './include/footer.php';
