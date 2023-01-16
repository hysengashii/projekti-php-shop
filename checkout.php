
<?php include './include/header.php' ?>

<?php
 $_SESSION['page'] = 'Checkout';


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['order_btn'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'nr'. $_POST['nr'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');
 
    $cart_total = 0;
    $cart_products[] = '';
 
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
       while($cart_item = mysqli_fetch_assoc($cart_query)){
          $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
          $sub_total = ($cart_item['price'] * $cart_item['quantity']);
          $cart_total += $sub_total;
       }
    }
 
    $total_products = implode(', ',$cart_products);
 
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
 
    if($cart_total == 0){
       $message[] = 'your cart is empty';
    }else{
       if(mysqli_num_rows($order_query) > 0){
          $message[] = 'order already placed!'; 
       }else{
          mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
          $message[] = 'order placed successfully!';
          mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
       }
    }
    
 }

?>



<section class="container color">
   <div class="card p-4 text-center color">
      
      <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p><b>Product name: </b><?php echo $fetch_cart['name']; ?> <span>(<?php echo $fetch_cart['price'].'Euro'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="total"><b> Total :</b> <span><?php echo $grand_total; ?>Euro</span> </div>
      
   </div>
</section>

<section class="container">
   <form action="" method="post">
      <h3 class="text-center my-3">Place your order</h3>
      <div class="form-outline mb-4 form-control">
         <div class="form-outline mb-4 ">
            <span><b>Your name :</b></span>
            <input type="text" class="border-bottom" name="name" required placeholder="enter your name">
         </div>
         <div class="form-outline mb-4">
            <span><b>Your number :</b></span>
            <input type="number" class="border-bottom" name="number" required placeholder="enter your number">
         </div>
         <div class="form-outline mb-4 ">
            <span><b>Your email :</b></span>
            <input type="email" class="border-bottom" name="email" required placeholder="enter your email">
         </div>
         <div class="form-outline mb-4 ">
            <span><b>Payment method :</b></span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
            </select>
         </div>
         <div class="inputBox  mb-4">
            <span>Address</b></span>
            <input type="text" class="border-bottom" name="street" required placeholder="enter address">
         </div>
         <div class="form-outline mb-4 ">
            <span><b>Addres Number</b></span>
            <input type="number" class="border-bottom" min="0" name="nr" required placeholder="addres number">
         </div>
         <div class="form-outline mb-4 ">
            <span><b>City :</b></span>
            <input type="text" class="border-bottom" name="city" required placeholder="Prishtine">
         </div>
         <div class="form-outline mb-4">
            <span><b>Country :</b></span>
            <input type="text" class="border-bottom" name="country" required placeholder="Kosove">
         </div>
         <div class="form-outline mb-4">
            <span><b>Pin code :</b></span>
            <input type="number" class="border-bottom" min="0" name="pin_code" required placeholder="10000">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>







<?php include './include/footer.php' ?>
