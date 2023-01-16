<?php  include './config.php';
session_start();
$page = (isset($_SESSION['page'])) ? ucfirst($_SESSION['page']) : 'Homee';

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($message)){
    foreach($message as $message){
        echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
          ';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $page ?> / MobilShop</title>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootsrap link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<header class="container-fluid">
   
<nav class="navbar navbar-expand-lg navbar-light ">
  <div class="container">
    <a class="navbar-brand" href="home.php">Mobil Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Orders.php">Orders</a>
        </li>
        <li class="nav-item dropdown ml-auto">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['user_name'];  ?>
            </a>
            <div class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">User: <span> <b><?php echo $_SESSION['user_name'];   ?></span></b></a>
            <a class="dropdown-item" href="#">Email: <span><b><?php echo $_SESSION['user_email'];   ?></span></b> </a>
            <a href="logout.php" class="btn btn-danger mx-5 mt-3">Logout</a>
            </div>
        </li>
        
        </ul>
    </div>

        <div class="icons">
        <?php
                $select_cart_number = mysqli_query($conn, "SELECT * from `cart` where user_id= '$user_id'") or die ('query failed');
                $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
                    <section class="search-form container mb-4 ">
                    <form action="../search_page.php" method="post" class="form-inline mt-4 ">
                        <input href="../search_page.php" class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Search</button>
                        <a href="cart.php" class="px-2"> <i class="fa fa-cart-plus " style="font-size: 1.8em;" aria-hidden="true"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
            
                    </form>
                    </section>
                    
        </div>
  </div>

    <div class="flex">
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a> </p>
    </div>
</nav>

</header>