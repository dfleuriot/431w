<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Everest - My Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />
<link rel= "stylesheet" type="text/css" href = "../css/header_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>
.btnUpdate {
  background: #34d976;
  background-image: -webkit-linear-gradient(top, #34d976, #004508);
  background-image: -moz-linear-gradient(top, #34d976, #004508);
  background-image: -ms-linear-gradient(top, #34d976, #004508);
  background-image: -o-linear-gradient(top, #34d976, #004508);
  background-image: linear-gradient(to bottom, #34d976, #004508);
  -webkit-border-radius: 3;
  -moz-border-radius: 3;
  border-radius: 3px;
  font-family: Arial;
  color: #ffffff;
  font-size: 11px;
  padding: 6px 20px 6px 20px;
  text-decoration: none;
}

.btnUpdate:hover {
  background: #00820f;
  background-image: -webkit-linear-gradient(top, #00820f, #0d6300);
  background-image: -moz-linear-gradient(top, #00820f, #0d6300);
  background-image: -ms-linear-gradient(top, #00820f, #0d6300);
  background-image: -o-linear-gradient(top, #00820f, #0d6300);
  background-image: linear-gradient(to bottom, #00820f, #0d6300);
  text-decoration: none;
}
</style>

<body>
																																																																																																																																																																	
<!-- HEADER --> 
    <div id = "header">
        <div style="float:left;height:50px;width:15%;min-width:120px;">
			<a href = "/">
            <img type = "everest_logo" src = "/imgs/everest-logo.png" alt = "Everest Logo" style="padding-left:28px;width: 107px;"/>
			</a>
        </div>


		<?php

		include_once ('./config.php');

		$conn=mysqli_connect($servername,$username,$password,$dbname);

		if (mysqli_connect_errno())
		{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
		}

		if(isset($_COOKIE['UID']))
		{
			$_COOKIE['UID'];
			$userid= $_COOKIE['UID'];
			$query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
			$result = mysqli_query($conn,$query);
			if($row = mysqli_fetch_array($result))
			{	
			$ccID = $row['ccID'];
			}
			else{$ccID=0;}
			$query="select * from team_best_rds.tbl_orders where ccID = $ccID and cart =1";
			$result = mysqli_query($conn,$query);

			if($row = mysqli_fetch_array($result)){//if an order exist
				$orderID=$row['orderID'];

				$query="SELECT COUNT(*) as count FROM team_best_rds.tbl_orderdetails where orderID = $orderID";
				$result = mysqli_query($conn,$query);
				$row = mysqli_fetch_array($result);	

				echo'<a href="cart.php"style="color:white;margin-left: 67%;position: absolute;top: 15px; " ><span class="glyphicon glyphicon-shopping-cart"> Cart</span><span class = "tooltiptext">('.$row['count'].') </span> </a>';



			}else{//if there's no order yet
				echo'<a href="cart.php"style="color:white;margin-left: 67%;position: absolute;top: 15px; " ><span class="glyphicon glyphicon-shopping-cart"> Cart</span><span class = "tooltiptext"> (0) </span> </a>
				';
			}
	
		}else{
			echo'<a href="cart.php"style="color:white;margin-left: 67%;position: absolute;top: 15px; " ><span class="glyphicon glyphicon-shopping-cart"> Cart</span><span class = "tooltiptext"> </span> </a>';
		}		
		?>
		
		
		<form method="post" action="search.php" name="form">  
		<div  id="search">
            <input name = "searchbar" id = "searchbox" type="text" size="30" onkeyup="showResult(this.value)" placeholder="Search for an item..." />
        </div>
        </form>
            <?php
				if(isset($_COOKIE['email']) == "") {
					echo '<a href="login.php"style="color:white;margin-left: 75%;position: absolute;top: 15px;" ><span class="glyphicon glyphicon-log-in"> Login</span> </a>
					<a href="myaccount.php"style="color:white;margin-left: 41%;position: absolute;top: 15px;display:none"><span class="glyphicon glyphicon-user"> My Account</span> </a>
            		<a href="logout.php"style="color:white;margin-left: 75%;position: absolute;top: 15px;display:none"><span class="glyphicon glyphicon-log-out"> Logout</span> </a>
					';
				} else {
					echo'
					<a href="myaccount.php"style="color:white;margin-left: 41%;position: absolute;top: 15px;"><span class="glyphicon glyphicon-user"> My Account</span> </a>
            		<a href="logout.php"style="color:white;margin-left: 75%;position: absolute;top: 15px;"><span class="glyphicon glyphicon-log-out"> Logout</span> </a>
					<a href="login.php"style="color:white;margin-left: 75%;position: absolute;top: 15px; display:none" ><span class="glyphicon glyphicon-log-in"> Login</span> </a>
					';
				}

?>
    </div> <!-- End of Div header --> 

    <div id="form_content" >
        <?php
            include_once ('./config.php');

            $conn = new mysqli($servername, $username, $password, $dbname);
           
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            if(isset($_COOKIE['UID']))
	        {

            $userid= $_COOKIE['UID']; //grab userid
            if(!isset($_COOKIE['sup']))
	        {

            $sql = "SELECT * FROM tbl_users  WHERE userID = $userid";
            $result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($result);	
           
           // while($row = mysqli_fetch_array($result)){

                echo '
                
                    <h2>My Account Information:</h2>
                    <br>
                    <form method="post" action="updateUser.php">
                        <p>Name:
                        <input name="FirstName" placeholder = "First Name" value = "'.$row["FirstName"].'" style="width: 160px;top: 0px;left: 73px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                        <input name="LastName" placeholder = "Last Name" value = "'.$row["LastName"].'" style="width: 160px;top: 0px;left: 70px;position: relative;padding-top: 0px;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;" type="text">
                        </p>
                        <p>Email:
                        <input name = "email" type = "email" style = "margin-left: 76px;" value = "'.$row["email"].'">
                        </p>
                        <p>Date of birth:
                        <input name = "dob" type = "date" style = "margin-left: 33px;width: 150px;" value = "'.$row["DOB"].'">
                        </p>
                        <p>Password:
                        <input id = "pwd1" value = "'.$row["pwd"].'" name = "pwd1" type="password" placeholder = "New password..."
                            style="
                            padding-top: 0px;
                            padding-left: 0px;
                            padding-bottom: 0px;
                            padding-right: 0px;
                            margin-left:48px;
                        ">
                        <p>Retype Password:
                        <input id = "pwd2" value = "'.$row["pwd"].'" name = "pwd2" type="password" style="
                            padding-top: 0px;
                            padding-left: 0px;
                            padding-bottom: 0px;
                            padding-right: 0px;
                        ">
                        <p>Phone Number:
                        <input name = "phone_num" type = "tel" style = "margin-left:16px;" value = "'.$row["phone_num"].'">
                        </p>';
                        $sql = "SELECT * FROM tbl_seller  WHERE userID = $userid";
                        $result = mysqli_query($conn,$sql);
                        if($row = mysqli_fetch_array($result))
                        {
                            echo'
                                    <p>Annual Income:
                                    <input name="annual_income" placeholder = "Annual Income" value = "'.$row["annual_income"].'" style="width: 151px;top: 0px;left: 16px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                                    </p>
                                    <input class = "btnUpdate" type="submit" value="Update">   
                                </form>
                                <div id = "links">
                                <p>
                                <a href="upcomingorders.php">To-DO: Upcoming Orders</a>
                                </p>
                                <p>
                                <a href="sellanitem.php">Add an item for Sale/Bid</a>
                                </p>
                                <p>
                                <a href="orders.php">View Order History</a>
                                </p>
                                <a href="deleteacc.php">Delete Account</a>
                                </p>
                                <a href="shipaddr.php">Manage my shipping addresses</a>
                                </p>
                                <a href="billaddr.php">Manage my billing addresses</a>
                                </p>
                                <a href="ccedit.php">Manage my credit cards</a>
                                </p>
                            ';
                        }else{
                            
                    echo'
                        <input class = "btnUpdate" type="submit" value="Update">   
                    </form>
                    <div id = "links">
                    <p>
                    <a href="orders.php">View Order History</a>
                    </p>
                    <a href="becomeseller.php">Become Seller</a>
                    </p>
                    <a href="deleteacc.php">Delete Account</a>
                    </p>
                    <a href="shipaddr.php">Manage my shipping addresses</a>
                    </p>
                    <a href="billaddr.php">Manage my billing addresses</a>
                    </p>
                    <a href="ccedit.php">Manage my credit cards</a>
                    </p>
                ';}
                 }else{
                    $sql = "SELECT * FROM tbl_supplier  WHERE supplierID = $userid";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_array($result);	
                       echo '
                
                    <h2>My Account Information:</h2>
                    <br>
                    <form method="post" action="updateUser.php">
                        <p>Name:
                        <input name="Name" placeholder = "Supplier Name" value = "'.$row["name"].'" style="width: 175px;top: 0px;left: 73px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                        </p>
                        <p>Email:
                        <input name = "email" type = "email" style = "margin-left: 76px;" value = "'.$row["email"].'">
                        </p>
                        <p>Manager:
                        <input name = "manager" type = "manager" style = "margin-left: 53px;width: 175px;" value = "'.$row["managername"].'">
                        </p>
                        <p>Password:
                        <input id = "pwd1" value = "'.$row["pwd"].'" name = "pwd1" type="password" placeholder = "New password..."
                            style="
                            padding-top: 0px;
                            padding-left: 0px;
                            padding-bottom: 0px;
                            padding-right: 0px;
                            margin-left:48px;
                        ">
                        <p>Retype Password:
                        <input id = "pwd2" value = "'.$row["pwd"].'" name = "pwd2" type="password" style="
                            padding-top: 0px;
                            padding-left: 0px;
                            padding-bottom: 0px;
                            padding-right: 0px;
                        ">
                        <p>address:
                        <input name = "address" type = "address" style = "margin-left:60px;" value = "'.$row["address"].'">
                        </p>';
                        $sellerID=$row['sellerID'];
                        $sql = "SELECT * FROM tbl_seller  WHERE sellerID = $sellerID";
                        $result = mysqli_query($conn,$sql);
                        if($row = mysqli_fetch_array($result))
                        {
                            echo'
                                    <p>Annual Income:
                                    <input name="annual_income" placeholder = "Annual Income" value = "'.$row["annual_income"].'" style="width: 175px;top: 0px;left: 16px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                                    </p>
                                    <input class = "btnUpdate" type="submit" value="Update">   
                                </form>
                                <div id = "links">
                                <p>
                                <a href="sellanitem.php">Add an item for Sale/Bid</a>
                                </p>
                                <p>
                                <a href="deleteacc.php">Delete Account</a>
                                </p>
                            ';}
                }
            }
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to view this page!");
                    if (r == true) {
                        window.location.href = "login.php";
                    } else {
                        window.location.href = "index.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction();
        </script>'
        ;
	}
                
            //}

            ?>

            
        </div>

         <script>
    /*script for password confirmation*/

    var password = document.getElementById("pwd1"),
      confirm_password = document.getElementById("pwd2");

    function validatePassword() {
      if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
  </script>




     <!-- Start of Footer -->
    <div id="footer">																																																																										
		<div id="footer_inside">
			<p>Copyright &copy;. All rights reserved. Design by Team Best - CMPSC 431W</p>					                                                                                                                                                                                                         																																																				
		</div>
	</div>
    <map name="Map">
       <area shape="rect" coords="78,45,312,119" href="index.php">
       <area shape="poly" coords="670,87,719,78,727,123,677,130" href="#">
       <area shape="poly" coords="776,124,818,152,793,189,751,160" href="#">
       <area shape="poly" coords="834,52,885,61,878,105,828,96" href="#">
	</map>
</body>
</html>