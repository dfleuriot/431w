<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Everest - Template Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../css/main.css" />
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


        <!-- ************* INCLUDE YOUR CODE HERE ************  -->


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