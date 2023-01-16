
<?php include './include/header.php' ?>

<?php
 $_SESSION['page'] = 'Search';



$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

?>




<section class="container">

   <div class="row">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
?>
    <div class="col-sm-4 col-md-3 col-lg-3 mb-4">
        
    <form action="" method="post" class="box">
        <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_product['name']; ?></div>
        <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
        <input type="number"  class="qty" name="product_quantity" min="1" value="1">
        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
        <input type="submit" class="btn" value="add to cart" name="add_to_cart">
    </form>
            
   
    </div>
    <?php
                }
            }else{
                echo '<p class="card w-25 p-2 text-center mx-auto">no result found!</p>';
            }
        }else{
            echo '<p class="card w-25 p-2 text-center mx-auto">search something!</p>';
        }
    ?>
   </div>
</section>





<?php include './include/footer.php' ?>
