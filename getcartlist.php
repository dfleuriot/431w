<?php
    include_once ('./config.php');
 $item_total=0;
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}

    if(isset($_COOKIE['UID']))
	{
        
        $userid= $_COOKIE['UID'];
        //get ccid
		$query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		$ccID = $row['ccID'];
		//$today = date("Ymd");
        //get orderid
		$query="select * from team_best_rds.tbl_orders where ccID = $ccID and cart =1";
		$result = $con->query($query);
        if($row = mysqli_fetch_array($result))
		{

        $orderID=$row['orderID'];
			 if(isset($_GET['action']))
			{
				if($_GET['action']=='remove')
				{
					$itemID=$_GET['code'];
					$query="SELECT * from team_best_rds.tbl_orderdetails where orderID = $orderID and itemID =$itemID";
					$result = $con->query($query);
        			while($row = mysqli_fetch_array($result))
					{
						$qty=$row['qty'];
						$query2="UPDATE team_best_rds.tbl_items SET qty=qty+$qty where itemID = $itemID";
						$con->query($query2);
					}
					$query="DELETE from team_best_rds.tbl_orderdetails where orderID = $orderID and itemID =$itemID";
					$con->query($query);
				}
				elseif($_GET['action']=='empty')
				{
					$query="SELECT * from team_best_rds.tbl_orderdetails where orderID = $orderID";
					$result = $con->query($query);
        			while($row = mysqli_fetch_array($result))
					{
						$qty=$row['qty'];
						$itemID=$row['itemID'];
						$query2="UPDATE team_best_rds.tbl_items SET qty=qty+$qty where itemID = $itemID";
						$con->query($query2);
					}
					$query="DELETE from team_best_rds.tbl_orderdetails where orderID = $orderID";
					$con->query($query);
				}
			}
        //get info
        $query="select i.itemID, i.name,o.qty as numbuy,i.qty as numinstock,i.itemprice from team_best_rds.tbl_orderdetails o,team_best_rds.tbl_items i where orderID = $orderID and i.itemID=o.itemID";
        $result = $con->query($query);
        echo '
		<div id="shopping-cart" style="margin-top: 60px;">
		<div class="txt-heading"><strong>Shopping Cart </strong><a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a></div>
		<table cellpadding="10" cellspacing="1">
		<tbody>
		<tr>
		<th style="text-align:left;"><h4>Name</h4></th>
		<th style="text-align:left;"><h4>Qty</h4></th>
		<!--<th style="text-align:right;"><h4>in stock</h4></th>-->
		<th style="text-align:right;"><h4>Price</h4></th>
		<th style="text-align:center;"><h4>Action</h4></th>';
        while($row = mysqli_fetch_array($result))
                {
                echo '<tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong>'.$row["name"].'</strong></td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["numbuy"].'</td>
				<!--<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">'.$row["numinstock"].'</td>-->
				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">'.$row["itemprice"].'</td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="cart.php?action=remove&code='.$row["itemID"].'" class="btnRemoveAction">Remove Item</a></td>
				</tr></div>';
				
        $item_total += ($row["itemprice"]*$row["numbuy"]);
		}
        echo '<tr>
		<td colspan="5" align=right><h4 style = "margin-right:25px">Total:$ '.$item_total.'</h4></td>
		</tr>
		</tbody>
		</table>
		</div>';
?>


      <div id="wrapper">
        <div id="login" class="animate form">
          <form action="completeorder.php" method="POST">
 			<p>
              <label for="cclist" class="cclist" data-icon="p"> Choose a credit card </label>
			  <select name='cc' required style = "margin-left: 35px;">
			  		<?php

						$userid= $_COOKIE['UID'];
						$query="select * from team_best_rds.tbl_credit_card where userID=$userid";
						$result = mysqli_query($con,$query);
						while($row = mysqli_fetch_array($result)){
							$num = $row['credit_card_num'];
							$cardnum= substr($num, -4);
							echo'
								<option value = "'.$row['ccID'].'"> Card ending in '.$cardnum.'</option>
							';
						}
						?>
				</select>
				<br>
					<label for="Saddrlist" class="Saddrlist" data-icon="p"> Confirm Shipping address </label>
					<select name='sa' required>
							<?php
						$query="select * from team_best_rds.tbl_shipping_address where userID=$userid and deleted = 0";
						$result = mysqli_query($con,$query);
						while($row = mysqli_fetch_array($result)){
							$addr1 = $row['address1'];
							$addr2 = $row['address2'];
							$city = $row['city'];
							$state = $row['state'];
							$zip = $row['zip_code'];
							$full = $addr1." ".$addr2.", ".$city.", ".$state." ".$zip;
							echo'
								<option value = "'.$row['saddrID'].'">'.$full.'</option>
							';
						}
					  	?>
			  		</select>
					  <br>
					<label for="Baddrlist" class="Baddrlist" data-icon="p"> Confirm Billing address </label>
					<select name='ba' required style = "margin-left: 18px;">
							<?php
						$query="select * from team_best_rds.tbl_billing_address where userID=$userid and deleted = 0";
						$result = mysqli_query($con,$query);
						while($row = mysqli_fetch_array($result)){
							$addr1 = $row['address1'];
							$addr2 = $row['address2'];
							$city = $row['city'];
							$state = $row['state'];
							$zip = $row['zipcode'];
							$full = $addr1." ".$addr2.", ".$city.", ".$state." ".$zip;
							echo'
								<option value = "'.$row['baddrID'].'">'.$full.'</option>
							';
						}
					  	?>
			  		</select>
            </p>

			 <input type="submit" value="Complete Order">
 		  </form>
        </div>
	  </div>


<?php
	}else{
		 echo '
        <div id="shopping-cart" style="margin-top: 60px;">
		<div class="txt-heading"><strong>Shopping Cart </strong><a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a></div>
		<table cellpadding="10" cellspacing="1">
		<tbody>
		<tr>
		<th style="text-align:left;"><h4>Name</h4></th>
		<th style="text-align:left;"><h4>Qty</h4></th>
		<!--<th style="text-align:right;"><h4>in stock</h4></th>-->
		<th style="text-align:right;"><h4>Price</h4></th>
		<th style="text-align:center;"><h4>Action</h4></th>
		</tr>	';
		echo '<tr>
		<td colspan="5" align=right><h4 style = "margin-right:25px">Total:$ '.$item_total.'</h4></td>
		</tr>
		</tbody>
		</table>
		</div>';

	}
    }
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to view cart!");
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