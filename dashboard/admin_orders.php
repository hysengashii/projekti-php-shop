<?php  include 'admin_header.php'  ?>

<?php

$_SESSION['page'] = 'orders';
include '../config.php';



$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:../login.php');
}

if(isset($_POST['update_order'])){
    $order_update_id = $_POST['order_id'];
    $update_status = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status ='$update_status' where id ='$order_update_id'") or die('query failed');
    $message[] = 'Payment status has been updated';   
}

if(isset($_GET['delete'])){
    $delete_id= $_GET['delete'];
    mysqli_query($conn, "DELETE from `orders` where id = '$delete_id' ") or die('query failed');
    header('location:admin_orders.php');
}


?>



<section class="orders my-5">
<h1 class="text-center">Placed Orders</h1>
    <div class="container ">
        <div class="row">
                            <?php
                            $select_orders = mysqli_query($conn, "SELECT * from `orders`") or die ('qyert failed');
                            if(mysqli_num_rows ($select_orders) > 0){
                                while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                            ?>
                                
                <div class="box col-sm-4 col-md-3 col-lg-3 mb-4 text-center">
                    <div class="card">
                            <div class="cart-body p-4">
                                <p>User id: <span><?php echo $fetch_orders['user_id']  ?></span></p>
                                <p>Placed on: <span><?php echo $fetch_orders['placed_on']  ?></span></p>
                                <p>Name: <span><?php echo $fetch_orders['name']  ?></span></p>
                                <p>Number: <span><?php echo $fetch_orders['number']  ?></span></p>
                                <p>Email: <span><?php echo $fetch_orders['email']  ?></span></p>
                                <p>Address: <span><?php echo $fetch_orders['address']  ?></span></p>
                                <p>Total products: <span><?php echo $fetch_orders['total_products']  ?></span></p>
                                <p>Total price: <span><?php echo $fetch_orders['total_price']  ?></span></p>
                                <p>Payment method: <span><?php echo $fetch_orders['method']  ?></span></p>

                                <form action="" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                    <select name="update_payment" class="form-control my-2">
                                        <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                                        <option value="pending">pending</option>
                                        <option value="completed">completed</option>
                                    </select>
                                    <input type="submit" value="update" name="update_order" class="btn btn-primary">
                                    <a href="admin_orders.php?delete=<?php echo $fetch_orders['id'];?>"  onclick="return confirm('delete this order?');" class="btn btn-danger">Delete</a>
                                </form>
                
                            </div>
                    </div>
                </div>
            <?php

                }
                }else{
                    echo '<p class="empty">no orders placed yet</p>';
                }
            ?>
        </div>
    </div>

</section>








<!-- admin js -->
<script src="js/admin_script.js"></script>
<!-- bootsrap js link -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</body>
</html>