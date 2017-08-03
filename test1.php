!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Everest - Supplier Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../css/main.css" />
<link rel="stylesheet" type="text/css" href="../css/table.css" />
<link rel= "stylesheet" type="text/css" href = "../css/header_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
																																																																																																																																																																	
<!-- HEADER --> 
    <div id = "header">
        <div style="float:left;height:50px;width:15%;min-width:120px;">
			<a href = "/">
            <img type = "everest_logo" src = "/imgs/everest-logo.png" alt = "Everest Logo" style="padding-left:28px;width: 107px;"/>
			</a>
        </div>
            <a href="cart.php"style="color:white;margin-left: 68%;position: absolute;top: 15px;"><span class="glyphicon glyphicon-shopping-cart"> Cart</span> </a>
        <div id="search">
            <input id = "searchbox" type="text" size="30" onkeyup="showResult(this.value)" placeholder="Search for an item..." />
        </div>
            <?php
				if (isset($_COOKIE['email']) == "") {
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

    <div id="main_block">
	    <div class="about">
		    <?php
				if(isset($_COOKIE['name']) != "") {
					echo'
    					<h3> Welcome '.$_COOKIE['name'].'...</h3>
						<br>
						</div>';
				}
                else header("Location:login.php");
                include_once ('./config.php');
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $uid = "";
                $sid = "";
                $item_total = "";
                if(isset($_COOKIE['UID']) != "") {
                    $uid = $_COOKIE['UID'];
                }
                $sql = "SELECT sellerID FROM tbl_seller WHERE userID = '$uid'";
                $results = $conn->query($sql);
                while ($row = mysqli_fetch_array($results)) {
                    $sid = $row["sellerID"];
                }
                if ($sid == "") {
                    $sid = $uid;
                }
                if(isset($_GET['category'])) {
                // id index exists
                } else {
                    $category=9;
                }
                 
                $sql = "SELECT o.orderID, o.qty as numbuy, i.itemprice, i.name FROM tbl_orderdetails o, tbl_items i WHERE i.sellerID = '$sid' AND i.itemID=o.itemID";
                $result = $conn->query($sql);
                echo '<h3> Your customers bought ... </h3>
		                    <br>
		                    </div>';
                echo '<div id="shopping-cart" style="margin-top: 60px;">
                    <table cellpadding="10" cellspacing="1">
                    <tbody>
                    <tr>
                    <th style="text-align:left;"><strong>Order ID</strong></th>
                    <th style="text-align:left;"><strong>Name</strong></th>
                    <th style="text-align:right;"><strong>Quantity</strong></th>
                    <th style="text-align:right;"><strong>Price</strong></th>
                    </tr>';
                    //<th style="text-align:center;"><strong>Ship</strong></th>
                    //</tr>	';
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>
				        <td style="text-align:right;border-bottom:#F0F0F0 1px solid;">'.$row["orderID"].'</td>
				        <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong>'.$row["name"].'</strong></td>
				        <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["numbuy"].'</td>
				        <td style="text-align:right;border-bottom:#F0F0F0 1px solid;">'.$row["itemprice"].'</td>
                        </tr></div>';
				        //<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="sellerbought.php?action=remove&code='.$row["itemID"].'" class="btnRemoveAction">Send Item</a></td>
				        //</tr></div>';	
                        $item_total += ($row["itemprice"]*$row["numbuy"]);
                }
                echo '<tr>
                    <td colspan="5" align=right><strong>Total:</strong>'.$item_total.'</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>';
                $conn->close();
                ?>
        </div>
    </div>    
    <!-- Start of Footer -->
    <div id="footer">																																																																										
		<div id="footer_inside">
			<ul class="footer_menu">
				<li><a href="index.php">Home Page</a>|</li>
				<li><a href="index2.php">About Us</a>|</li>
				<li><a href="index2.php">News &amp; Events</a>|</li>
				<li><a href="index2.php">Services</a>|</li>
				<li><a href="index2.php">My Account</a>|</li>
				<li><a href="index2.php">Contacts</a></li>
			</ul><br /><br />
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