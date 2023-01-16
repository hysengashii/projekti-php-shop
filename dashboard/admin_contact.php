
<?php  include 'admin_header.php'  ?>
<?php

$_SESSION['page'] = 'Contact';

include '../config.php';


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:../login.php');
};

if(isset($_GET['delete'])){
    $delete_id= $_GET['delete'];
    mysqli_query($conn, "DELETE from `message` where id = '$delete_id' ") or die('query failed');
    header('location:admin_contact.php');
}

?>



 <section class="container my-5 ">
    <div class="row">
        <?php
            $select_message = mysqli_query($conn, "SELECT * from `message`") or die('query failed');
            if(mysqli_num_rows($select_message) > 0){
                while($fetch_message= mysqli_fetch_assoc($select_message)){
        ?>
            <div class="col-sm-4 col-md-3 col-lg-3 mb-4 text-center">
                <p><b>Name: </b><span><?php echo $fetch_message['name'];?></span></p>
                <p><b>Number: </b><span><?php echo $fetch_message['number'];?></span></p>
                <p><b>Email: </b><span><?php echo $fetch_message['email'];?></span></p>
                <p><b>Message: </b><span><?php echo $fetch_message['message'];?></span></p>
                <a href="admin_contact.php?delete=<?php echo $fetch_message['id'];?>"  onclick="return confirm('delete this message?');" class="btn btn-danger">Delete</a>
            </div>
        <?php
            };
        }else{
            echo '<p class="empty">you have no message</p>';
        }
        ?>

    </div>
 </section>




