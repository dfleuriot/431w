<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Everest - Search Results</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel= "stylesheet" type="text/css" href = "../css/header_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<style>
.tooltiptext {
    visibility: hidden;
    width: 120px;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    top: 100%;
    left: 50%;
    margin-left: -21px;
    margin-top: -14px;
}

.tooltiptext {
    visibility: visible;
}
</style>
																																																																																																																																																																	
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
			//$_COOKIE['UID'];
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



	<div id="wrapper">																		                                                                                                         																																																					
		<div id="content_inside">
			<div id="sidebar">
				<h3>CATEGORIES</h3>																																																																
				<?php
				include_once ('./getcat.php');
				?>
			</div>




			<div id="main_block">
				<div class="about">
					<?php 

						if(isset($_COOKIE['name']) == "") {
							echo'
								<h3> Welcome guest user...</h3>
								<br>
								</div>
						';
						}
						else{
						echo'
						<h3> Welcome '.$_COOKIE['name'].'...</h3>
						<br>
						</div>
						';
						}

					?>
				<div id="items">
					<div id="items">

                    <!--SEARCH FUNCTION HERE -->
                    <?php
                        include_once ('./config.php');
                        $item_total=0;
                        $con=mysqli_connect($servername,$username,$password,$dbname);
                        if (mysqli_connect_errno())
                        {
                            echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
                        }


                        $search = $_POST["searchbar"];

                        $sql = "SELECT * FROM tbl_items WHERE qty!=0 and name like '%$search%' and itemID <>9999";
                        $result = $con->query($sql);

                        while ($row = mysqli_fetch_array($result)) {
						if($row['isBid']==0)
						{
						echo '
							<div class="item">
								<img src="./imgs/'.$row['itemID'].'.jpg" alt="" width="202" height="173" /><br />
								<span>$'.$row['itemprice']. '</span>
								<a href="item.php?itemid='.$row['itemID'].'&category=9 " class="view">'.$row['name'].'</a>
							
								<a class="cart" href="addtocart.php?itemid='.$row['itemID'].'">Add To Cart</a>
							
							</div>
							';
						}else{
								echo '
							<div class="item">
								<img src="./imgs/'.$row['itemID'].'.jpg" alt="" width="202" height="173" /><br />
								<span>$'.$row['itemprice']. '</span>
								<a href="item.php?itemid='.$row['itemID'].'&category=9 " class="view">'.$row['name'].'</a>
							
								<a class="cart" href="addtocart.php?itemid='.$row['itemID'].'">Place a Bid</a>
							
							</div>';
							}
						}
                        $con->close();
                    ?>
                    <!-- END OF SEARCH-->

				</div>
			</div>
		</div>
	</div>
	<div id="footer">																																																																										
		<div id="footer_inside">
			<ul class="footer_menu">
				<li><a href="index.html">Home Page</a>|</li>
				<li><a href="index2.html">About Us</a>|</li>
				<li><a href="index2.html">News &amp; Events</a>|</li>
				<li><a href="index2.html">Services</a>|</li>
				<li><a href="index2.html">My Account</a>|</li>
				<li><a href="index2.html">Contacts</a></li>
			</ul><br /><br />
			<p>Copyright &copy;. All rights reserved. Design by Team Best - CMPSC 431W</p>					                                                                                                                                                                                                         																																																				
		</div>
	</div>
    <map name="Map">
       <area shape="rect" coords="78,45,312,119" href="index.html">
       <area shape="poly" coords="670,87,719,78,727,123,677,130" href="#">
       <area shape="poly" coords="776,124,818,152,793,189,751,160" href="#">
       <area shape="poly" coords="834,52,885,61,878,105,828,96" href="#">
	</map>
</body>
</html>