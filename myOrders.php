<?php
// Start the session
session_start();

if (!isset($_SESSION['user_id'])) {
  // User is not logged in, redirect to login page
  header("Location: login.html");
  exit(); // Stop further execution
}

// Database configuration
include_once 'connect.php';

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Retrieve the orders for the logged-in customer
$sql = "SELECT * FROM orders WHERE user_id = '$userID' ORDER BY placed_on DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<style>
        .box {
            padding: 20px 30px;
background: #fff;
box-shadow: 0.5rem 1rem rgba(0,0,0,.1);
border:.1rem solid rgba(0,0,0, .3);
border-radius: 5px;
text-align: center;
flex: 1 1 30rem;
position:relative;
cursor: pointer;
        }

        .box img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }
       

      
    </style>
      <!-- basic -->
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>FOODZ©</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style6.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
   <!-- awesome fontfamily -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"  />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css">
     <!-- Javascript files-->
     <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/account.js"></script>
    <!-- awesome fontfamily -->

</head>
<body class="main-layout blog_page">

 <!-- loader  -->
 <div class="loader_bg">
        <div class="loader"><img src="images/pizza.gif" alt="" /></div>
    </div>

    <div class="wrapper">
        <!-- end loader -->
        <div class="sidebar">
    <nav id="sidebar">
        <div id="dismiss">
            <i class="fa fa-arrow-right"></i>
        </div>
       <br>
        <div class="cart">
            <h2 class="cart-title">Your Cart</h2>
            <div class="cart-content">
                <div id="cart-items"> <!-- Cart items container -->
                    <!-- Cart items will be added dynamically here -->
                </div>
                <div class="total">
                    <div class="total-title">Total</div>
                    <div class="total-price">$0</div>
                </div>
                <button type="button" class="btn-buy" id="buyNowButton" onclick="buyNow()">Buy Now</button>

            </div>
        </div>
    </nav>
</div>


        <div id="content">
            <!-- header -->
            <header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="full">
                                <a class="logo" href=""><h1> FOODZ.</h1></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="full">
                                <div class="right_header_info">
                                    <ul>
                                        <li>
                                        <form action="" class="searchBar">
                                             <input id="searchInputy" type="text" placeholder="Search order by date .." name="q">
                                            <button id="searchButtony" type="button"><img src="images/search.png" alt="#"></button>
                                         </form>         

                                        </li>
                                        <li class="dinone">
                                            <div class="dropdown">
                                                <a href=""><img src="images/log.png" width="30" height="30"/></a> 
                                                <div class="dropdown-content">
                                                    <a href="settingsCustomer.php">Settings</a>
                                                    <a href="logout.php">Sign Out</a>
                                                </div>
                                            </div>  
                                        </li>
                                        <li class="cartis"><a href="myOrders.php" ><img src="images/order.png" alt="#" ></a> </li>
                                        <li>
                                            <button type="button" id="sidebarCollapse">
                                                <i class="cartis"><img src="images/add-cart.png" alt="#"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
       
            <div class="blog">
                        
            <h3 style="color:grey; margin:40px ;" >My previous orders : </h3>
        <div class="container">
            <div class="box-container">
                <?php
                // Check if any orders are found
                if (mysqli_num_rows($result) > 0) {
                    $currentMonth = '';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $orderID = $row['order_id'];
                        $method = $row['method'];
                        $totalProducts = $row['total_products'];
                        $totalPrice = $row['total_price'];
                        $placedOn = $row['placed_on'];

                        // Retrieve the restaurant image using the restaurant ID
                        $restaurantID = $row['restaurant_id'];
                        $restaurantImageSQL = "SELECT rest_img FROM restaurant WHERE restaurant_id = '$restaurantID'";
                        $restaurantImageResult = mysqli_query($conn, $restaurantImageSQL);
                        $restaurantImageRow = mysqli_fetch_assoc($restaurantImageResult);
                        $restaurantImage = $restaurantImageRow['rest_img'];

                        $placedOnMonth = date('F Y', strtotime($placedOn));
                        if ($placedOnMonth !== $currentMonth) {
                            echo '<h2 style="   
                                font-size: 16px;
                                font-weight: bold;
                                margin-bottom: 10px;
                                
                            ">' . $placedOnMonth . '</h2>';
                           
                            $currentMonth = $placedOnMonth;
                        }
                ?>
                       <div class="box">
                            <img src="<?php echo $restaurantImage; ?>" alt="Restaurant Image">
                            <h3>Order made on: <br> <span style="color:blue;"><?php echo $placedOn; ?></span></h3>
                            <p>Total Products: <?php echo $totalProducts; ?></p>
                            <p style="color:<?php echo ($row['orders_status'] == "waiting" || $row['orders_status'] == "accepted") ? 'green' : 'black'; ?>">
    Order Status: <?php echo $row['orders_status']; ?>
</p>

                            <h4 style="color:red; font-weight:bold;">Total Price: <?php echo $totalPrice; ?> dzd.</h4>
                        </div>
                <?php
                    }
                } else {
                    echo "No orders found.";
                }
                ?>
            </div>
        </div>
    </div>
    <footer>
                <div class="copyright">
                    <div class="container">
                        <p><a href="home.html"><img src="images/FOODZ-2.png" width="100" height="100" alt="#"/></a>FOODZ© 2023 All Rights Reserved.</p>
                    </div>
                </div>
            </footer>
</body>
</html>
