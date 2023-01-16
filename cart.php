<?php  include './include/header.php' ;

$_SESSION['page'] = 'Cart';
include 'config.php';


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
 }
 
 if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
 }

?>



<section class="shopping-cart container">

   <h1 class="text-center">Products</h1>

   <div class="row">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="col-sm-3 col-md-5 col-lg-2 text-center m-4">
         <div class="card p-1">
      
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times float-right" onclick="return confirm('delete this from cart?');"></a>
         <img src="./dashboard/uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name my-1"><b>Phone:</b><?php echo $fetch_cart['name']; ?></div>
         <div class="price"><b>Price</b><?php echo $fetch_cart['price']; ?>€</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" class="w-25 butoni text-center" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" class="btn btn-warning" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="total my-1" ><b>Total :</b> <span><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>€</span> </div>
         </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty card p-2 ">Your cart is empty</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="btn btn-danger  <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="d-flex flex-column mt-5 form-control w-50 form-totali">
      <div class=" totali text-center m-2">
        <p>grand total : <span><?php echo $grand_total; ?>€</span></p>
      </div>
      <div class="d-flex justify-content-center">
         <a href="shop.php" class="btn btn-primary mx-1">continue shopping</a>
         <a href="checkout.php" class="btn btn-warning"<?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

</section>






<?php include './include/footer.php' ?>



