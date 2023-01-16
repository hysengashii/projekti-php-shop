
<?php include './include/header.php' ?>

<?php
 $_SESSION['page'] = 'Orders';


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}


?>



<section class="placed-orders">

   <h1 class="title text-center">Orders</h1>

   <div class="container">
    <div class="row">
      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
    <div class="card w-50 m-3 p-2 col-sm-5 col-md-12 col-lg-5">
        <ul>
         <p> <b>Date on :</b> <span ><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> <b>Name :</b> <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> <b>Number :</b> <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> <b>Email :</b> <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> <b>Address :</b> <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> <b>Payment method :</b> <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> <b>Your orders :</b> <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> <b>Total price :</b> <span><?php echo $fetch_orders['total_price']; ?> Euro</span> </p>
         <p> <b>Payment status :</b> <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
        </ul>
    </div>
      <?php
       }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>
   </div>
   </div>

</section>





<?php include './include/footer.php' ?>
