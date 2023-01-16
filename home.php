

<?php require('./include/header.php');

 $_SESSION['page'] = 'Home';



$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_number = mysqli_query($conn, "SELECT * from `cart` where name = '$product_name' and user_id = '$user_id'") or die ('query failed');

    if(mysqli_num_rows($check_cart_number)>0) {
        $message[] = 'alredy added to cart';
    }else{
        mysqli_query($conn, "INSERT into `cart`(user_id, name, price, quantity, image) values('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die ('query failed');
        $message[] = 'product added to cart';

    }
}

?>


<div class="text-center my-4">
    <h3>Home</h3>
</div>
<section class="container">
    <div class="row">

        <?php 
            $select_products = mysqli_query($conn, "SELECT * from `products`  ") or die ('query failed');
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_products= mysqli_fetch_assoc($select_products)){
        ?>
     <div class="box col-sm-4 col-md-4 col-lg-3 mb-4 text-center">
            <div class="card p-2">
            <form action="" method="post">
                        <img src="./dashboard/uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name my-2"><b>Product name: </b> <?php echo $fetch_products['name']; ?></div>
                        <div class="price  my-2"><b>Product price: </b> <?php echo $fetch_products['price']; ?>Euro</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="form-control">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="Add to cart" name="add_to_cart" class="btn btn-primary mt-2">
            </form>
            </div>
     </div>

        <?php
                }
            }else{
                echo '<p class="empty">no products added</p>';
            }
        ?>
    </div>
    <div class="box text-center">
        <a href="shop.php" class="btn btn-outline-secondary">Load more</a>
    </div>

</section>


<?php include './include/footer.php' ?>
