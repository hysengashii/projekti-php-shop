<?php  include 'admin_header.php'  ?>
<?php
    $_SESSION['page'] = 'Home';

include '../config.php';


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:../login.php');
}


?>


<!-- admin dashboard -->
<section class="dashboard">

<h1 class="container text-center mt-5">Dashboard</h1>


<div class="container mt-4">
  <div class="row">
    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">

            <?php
            $total_pendings = 0;
            $select_pending= mysqli_query($conn, "SELECT total_price from `orders` where payment_status = 'pending'") or die ('query failed');
            if(mysqli_num_rows($select_pending) > 0){
                while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                    $total_price = $fetch_pendings['total_price'];
                    $total_pendings += $total_price ;
                    };
            };
            ?>
            <h3><?php echo  $total_pendings; ?>€</h3>
            <p>Pending price</p>
            </div>
            </div>
  </div>


    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">

            <?php
            $total_completed = 0;
            $select_completed= mysqli_query($conn, "SELECT total_price from `orders` where payment_status = 'completed'") or die ('query failed');
            if(mysqli_num_rows($select_completed) > 0){
                while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                    $total_price = $fetch_completed['total_price'];
                    $total_completed += $total_price;
                    };
            };
            ?>
        <h3><?php echo  $total_completed; ?>€</h3>
        <p>Completed payments</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">
        <?php
            $select_orders = mysqli_query($conn, "Select * from `orders`") or die ('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
        ?>
        <h3><?php echo  $number_of_orders; ?></h3>
        <p>Order placed</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">
        <?php
            $select_products = mysqli_query($conn, "Select * from `products`") or die ('query failed');
            $number_of_products = mysqli_num_rows($select_products);
        ?>
        <h3><?php echo  $number_of_products; ?></h3>
        <p>Products added</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">
        <?php
            $select_users = mysqli_query($conn, "Select * from `users` where user_type ='user'") or die ('query failed');
            $number_of_users = mysqli_num_rows($select_users);
        ?>
        <h3><?php echo  $number_of_users; ?></h3>
        <p>Normal Users</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">
        <?php
            $select_admins = mysqli_query($conn, "Select * from `users` where user_type ='admin'") or die ('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
        ?>
        <h3><?php echo  $number_of_admins; ?></h3>
        <p> Admin users</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4">
        <?php
            $select_account = mysqli_query($conn, "Select * from `users` ") or die ('query failed');
            $number_of_account = mysqli_num_rows($select_account);
        ?>
        <h3><?php echo  $number_of_account; ?></h3>
        <p> Total users</p>
        </div>
        </div>
    </div>

    <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
        <div class="card">
            <div class="cart-body p-4 p-3">
            <?php
                $select_messages = mysqli_query($conn, "Select * from `message`") or die ('query failed');
                $number_of_messages = mysqli_num_rows($select_messages);
            ?>
        <h3><?php echo  $number_of_messages; ?></h3>
        <p>New messages</p>
        </div>
        </div>
    </div>

    

    </div>
</div>
</section>





