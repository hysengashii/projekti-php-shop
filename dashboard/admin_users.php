
<?php  include 'admin_header.php'  ?>
<?php
    $_SESSION['page'] = 'Users';

include '../config.php';



$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:../login.php');
}

if(isset($_GET['delete'])){
    $delete_id= $_GET['delete'];
    mysqli_query($conn, "DELETE from `users` where id = '$delete_id' ") or die('query failed');
    header('location:admin_users.php');
}

?>


<section class="container mt-5">

    <div class="row">
        <?php
            $select_users = mysqli_query($conn, "SELECT * from `users`") or die('query failed');
            while($fetch_users= mysqli_fetch_assoc($select_users)){
        ?>

            <div class="box col-sm-5 col-md-4 col-lg-3 mb-4 text-center">
                <div class="card">
                        <div class="cart-body p-4">
                            <p><b>Username: </b><span><?php echo $fetch_users['name'];?></span></p>
                            <p><b>Email: </b><span><?php echo $fetch_users['email'];?></span></p>
                            <p><b>User type : </b><span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
                            <a href="admin_users.php?delete=<?php echo $fetch_users['id'];?>"  onclick="return confirm('delete this user?');" class="btn btn-danger">Delete</a>
                        </div>
                </div>
            </div>
        <?php
            };
        ?>
        </div>
            </div>
    </div>
</section>






