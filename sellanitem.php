<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Everest - Sell/Bid</title>
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
                echo '
                
                    <h2>Add an Item for Sale/Bid:</h2>
                    <br>
                    <form method="post" action="sell.php" name = "sell" enctype="multipart/form-data">
                        <p>Name:
                        <input required name="ItemName" placeholder = "Name of Item" style="width: 160px;top: 0px;left: 73px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                        </p>
						<p>
						Price:
						<input required name="Price" placeholder = "Price of Item" style="width: 160px;top: 0px;left: 78px;position: relative;padding-top: 0px;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;" type="text">
                        </p>
                        <p>Quantity in Stock:
                        <input required name = "Qty" type = "text" style = "margin-left: 3px;width:50px;" />
                        </p>
                        <p>Description:
                        <textarea required placeholder = "Please enter a description for your item..." name = "Description" rows="4" cols="50" style = "margin-left: 40px;"></textarea>
                        </p>

						</p>
                        <p>Category :
                        <select required name = "Category" style = "margin-left: 48px;" >
						<option value="" disabled selected>Please choose a Category for your item</option>';
						

						$query="select name,curr_level from tbl_item_categories where parent_level<>0";
						$result = mysqli_query($conn,$query);
						$row = mysqli_fetch_array($result);
						while($row = mysqli_fetch_array($result)){

							echo '
								<option value="'.$row['curr_level'].'">'.$row['name'].'</option>
							';


							}
						echo'</select>
                        </p>



						<p>
						Auction Item?:
						<input  type="checkbox" name="bid" id = "bid"  style = "margin-left: 24px;" onclick="check()">
						</p>

						<p>Reserve Price:
                        <input disabled = "" name="ReservePrice" id = "ReservePrice" placeholder = "Buy it Now price" style="width: 160px;top: 0px;left: 25px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                        </p>

						<p>Starting Price:
                        <input disabled = "" name="MinPrice" id ="MinPrice" style="width: 160px;top: 0px;left: 26px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="text">
                        </p>

						<p>End Date:
                        <input disabled = "" name="EndDate" id ="EndDate" style="width: 160px;top: 0px;left: 52px;position: relative;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;" type="date">
                        </p>

						<script type="text/javascript">
							$("#bid").change(function(){
							$("#ReservePrice").prop("disabled", !$(this).is(":checked"));
							$("#MinPrice").prop("disabled", !$(this).is(":checked"));
							$("#EndDate").prop("disabled", !$(this).is(":checked"));
							});
						</script>


						<p>
						Shipped From:
						<select name = "stateshipped" style = "margin-left: 22px;">
							<option value="" disabled selected>Please choose a State</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>		
						</p>
						Upload image: <input type="file" name="fileToUpload" id="fileToUpload" style = "margin-top: -16px;margin-left: 117px;">
						
						<br>
						<input class = "btnUpdate" type="submit" value="Sell item">   
                    </form>
                        ';

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

				?>



		</div> <!-- end of form_content -->

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