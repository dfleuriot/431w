<!-- actual item specific page -->
<!DOCTYPE html>
<html>
<body>

	<?php
    include_once ('./config.php');
	
	$numinstock=0;
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	if(isset($_COOKIE['UID']))
	{
		//echo $_COOKIE['UID'];
		$userid= $_COOKIE['UID'];
		$query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
		$result = mysqli_query($con,$query);
		if(!$row = mysqli_fetch_array($result))
		{
			echo'<script>
                function myFunction3() {
                    var r = confirm("You need to Enter a Cedit Card");
                    if (r == true) {
                        window.location.href = "ccedit.php";
                    } else {
                        window.location.href = "ccedit.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction3();
        </script>';
		}else{
		$ccID = $row['ccID'];
		$today = date("Ymd");

		$query="select * from team_best_rds.tbl_orders where ccID = $ccID and cart =1";
		$result = $con->query($query);
		if(!$row = mysqli_fetch_array($result))
		{
			$query="insert into team_best_rds.tbl_orders (ccID, date, shipped, cart)
			values ($ccID, $today,0,1) ";
			if ($con->query($query) === TRUE) {
    			echo "New record created successfully";
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}
			$query="select * from team_best_rds.tbl_orders where ccID = $ccID and cart =1";
			$result = $con->query($query);
			$row = mysqli_fetch_array($result);
			$orderID=$row['orderID'];
		}		
		$orderID=$row['orderID'];
		if(isset($_GET['itemid']))
		{
			$itemid=$_GET['itemid'];

			$query="select * from team_best_rds.tbl_items where itemID =$itemid";
			$result = $con->query($query);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$numinstock=$row['qty'];

			$query="select * from team_best_rds.tbl_orderdetails where orderID = $orderID and itemID =$itemid";
			$result = $con->query($query);
			if(isset($_POST['qqqq']))
			{
				//$Qty=document.getElementById("Qty").value;
				$Qty = $_POST['qqqq'];
				if($Qty>$numinstock)
				{
					echo'<script>
                function myFunction3() {
                    var r = confirm("Not enough item in stock");
                    if (r == true) {
                        window.location.href = "item.php?itemID='.$itemid.'";
                    } else {
                        window.location.href = "item.php?itemID='.$itemid.'";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction3();
        </script>';
		header("location:/index.php");
				}
$query="UPDATE team_best_rds.tbl_items SET qty = qty- $Qty WHERE itemID=$itemid";
if ($con->query($query) == TRUE) {
    				echo "New record created successfully";
					//header("location:/index.php");
				} else {
    				echo "Error: " . $query . "<br>" . $con->error;
				}
				echo $Qty;
				/*echo ' <script> 
				function getQty(){

				document.write(document.getElementById("Qty");
				
				}
				</script> <script type ="text/javascript">
				getQty();
				</script>';*/

			}
			else{
				$Qty=1;
				if($Qty>$numinstock)
				{
					echo'<script>
                function myFunction3() {
                    var r = confirm("Not enough item instock");
                    if (r == true) {
                        window.location.href = "index.php";
                    } else {
                        window.location.href = "index.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction3();
        </script>';
		header("location:/index.php");
				}
				$query="UPDATE team_best_rds.tbl_items SET qty = qty- $Qty WHERE itemID=$itemid";
				if ($con->query($query) == TRUE) {
    				echo "New record created successfully";
					//header("location:/index.php");
				} else {
    				echo "Error: " . $query . "<br>" . $con->error;
				}
			}
			if($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
			{
				$query="UPDATE team_best_rds.tbl_orderdetails SET qty = qty+ $Qty WHERE orderID=$orderID and itemID=$itemid";
				if ($con->query($query) == TRUE) {
    				echo "New record created successfully";
					header("location:/index.php");
				} else {
    				echo "Error: " . $query . "<br>" . $con->error;
				}
			}else{
				$itemid=$_GET['itemid'];
				$query="insert into team_best_rds.tbl_orderdetails (orderID, itemID, qty) values ($orderID, $itemid,$Qty)";
				if ($con->query($query) == TRUE) {
    				echo "New record created successfully";
					header("location:/index.php");
				} else {
    				echo "Error: " . $query . "<br>" . $con->error;
				}	
			}


		
		}
		else{
		
			echo "<div class='alert'>
  			<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span> 
  			<strong>Danger!</strong> no item
			</div>";
		}}
	}
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to add an item to cart!");
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

				// Check connection


//echo $var_value;



//    echo $result['cname'];

mysqli_close($con);

?>

</body>
</html>