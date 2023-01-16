
<?php  include 'admin_header.php'  ?>

<?php
 $_SESSION['page'] = 'Products';
include '../config.php';


$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:../login.php');
}

if(isset($_POST['add_product'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder ='uploaded_img/'.$image;

    $select_product_name = mysqli_query($conn, "SELECT name from `products` where name='$name'") or die ('query failed');

    if(mysqli_num_rows($select_product_name) > 0){
    $message[] = 'product name alredy added';
    }else{
        $add_product_query = mysqli_query($conn, "INSERT INTO `products` (name,price,image) values('$name', '$price', '$image')") or die('query failed');
        
        if($add_product_query){
            if($image_size > 2000000){
                $message[] = 'image size is too large';
            }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[]= 'product added succesfully!';}
        }else{
            $message[]= 'product could not be added!';
        }
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);

    unlink('uploaded_img/'.$fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}
 
if(isset($_POST['update_product'])){
    $update_old_image ='';
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    
    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');
    
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
    
    if(!empty($update_image)){
        if($update_image_size > 2000000){
            $message[] = 'image file size is too large';
        }else{
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/'.$update_old_image);
        }
    }
    
    header('location:admin_products.php');
    
    }

?>





<!-- product CRUD  -->
<div class="container w-20 mb-5">
<h1 class="text-center my-5">Shop Productt</h1>
<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <input type="name" class="form-control" name="name" placeholder="Enter Product Name">
  </div>
  <div class="form-group">
    <input type="number"  name="price" min="0" class="form-control" placeholder="Enter Product Price">
  </div>
  <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" require>
  <div class="form-group">
    <input type="submit" value="Add product" name="add_product" class="btn btn-primary my-4">
  </div>
</form>
</div>
<section class="container  my-5">
    <?php
    if(isset($_GET['update'])){
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * from `products` where id = '$update_id'") or die ('query failed');
        if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
    ?>
    
    <form action="" method="post" enctype="multipart/form-data" class="form-control">
        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
        <input type="hidden" name="update_old_id" value="<?php echo $fetch_update['image']; ?>">
        <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" require placeholder="enter product name">
        <input type="text" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" require placeholder="enter product price">
        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="update" name="update_product" class="btn btn-primary">
        <input type="reset" value="cancel"  id="close-update" class="btn btn-danger">
    </form>
    <?php
            }
        }
    }else{

    }
    ?>
</section>
<section class="show-products ">
    <div class="container ">
        <div class="row">
                        <?php
                        $select_products= mysqli_query($conn, "SELECT * from `products`") or die ('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                            while($fetch_products = mysqli_fetch_assoc($select_products)){
                        ?>
                        
                <div class="box col-sm-6 col-md-3 col-lg-3 mb-4 text-center">
                    <div class="card">
                        <div class="cart-body p-4">
                       
                        <div class="">
                            <img src="uploaded_img/<?php echo $fetch_products['image'] ?>" alt="">
                            <div class="name"><?php echo $fetch_products['name']; ?></div>
                            <div class="price"><?php echo $fetch_products['price']; ?>€</div>
                            <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="btn btn-primary">update</a>
                            <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm ('delete this product')">Delete</a>
                        </div>
                        </div>
                    </div>
                </div>
                
                        <?php 
                            }
                        }else{
                            echo '<p class="empty"> no product added yet!</p>';

                        }
                        ?>
                        
            
        </div>

    </div>
</section>




