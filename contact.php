
<?php include './include/header.php' ?>

<?php
 $_SESSION['page'] = 'Contact';


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
 
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');
 
    if(mysqli_num_rows($select_message) > 0){
       $message[] = 'message sent already!';
    }else{
       mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
       $message[] = 'message sent successfully!';
    }
 
 }

?>

<section class="container w-25 mt-5" >

   <form action="" method="post" class="card p-3">
      <h3>Sent Message!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="form-control my-2">
      <input type="email" name="email" required placeholder="enter your email" class="form-control my-2">
      <input type="number" name="number" required placeholder="enter your number" class="form-control my-2">
      <textarea name="message" class="form-control" placeholder="enter your message" id="" cols="5" rows="3"></textarea>
      <input type="submit" value="send message" name="send" class="btn btn-primary my-2">
   </form>

</section>








<?php include './include/footer.php' ?>

