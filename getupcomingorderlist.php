<?php
    include_once ('./config.php');
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}

    if(isset($_COOKIE['UID']))
	{
        
        $userid= $_COOKIE['UID'];
		$query="select sellerID from team_best_rds.tbl_seller where userID=$userid";
		$result = mysqli_query($con,$query);
        $row = mysqli_fetch_array($result);
		$sellerid = $row['sellerID'];


        //get info
        $query="select * from tbl_orders o, tbl_credit_card c, tbl_orderdetails od, tbl_items i 
                where o.orderID = od.orderID and  od.itemID = i.itemID and i.sellerID = $sellerid and o.ccID = c.ccID order by o.orderID ASC";
        $result = $con->query($query);
        echo '
        <div id="shopping-cart" style="margin-top: 60px;">
			<div class="txt-heading"><Strong>UPCOMING ORDERS</strong></div>
			<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
			<th style="text-align:left;"><h4>Order#</h4></th>
			<th style="text-align:left;"><h4>Date Placed</h4></th>
			<th style="text-align:left;"><h4>Carrier</h4></th>
            <th style="text-align:left;"><h4>Tracking No.</h4></th>
			<th style="text-align:left;"><h4>Estimated Shipping Date</h4></th>
            <th style="text-align:left;"><h4>Credit Card Number</h4></th>
            <th style="text-align:left;"><h4>Shipped?</h4></th>
            <th style="text-align:left;"><h4>Action</h4></th>
			</tr>	';
            
        while($row = mysqli_fetch_array($result))
        {   
                $orderid = $row['orderID'];
                $ship = $row['shipped'];
                echo '
                <form method="post" action="submitorderdetails.php?orderid='.$orderid.'" name="submitupdate">
                
                <tr>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a style = "cursor:pointer;" href = "sorderdetails.php?orderid='.$row["orderID"].'">'.$row["orderID"].'</a></td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["date"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "Carrier" type = "text" placeholder="Carrier Name" value = "'.$row["carrier"].'">
                </td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "Tracking" type = "text" placeholder="Enter Tracking#" value = "'.$row["tracking_no"].'">
                </td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "ShipDate" type = "date" value = "'.$row["est_shipping_date"].'">
                </td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["credit_card_num"].'</td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                ';
                if ($ship == 1){
                echo'
                <input  type="checkbox" name="Shipped" checked = "Checked">
                </td>
                ';
                }else{
                    echo'
                    <input  type="checkbox" name="Shipped">
                    </td>
                    ';
                }
                
                echo'<td>
                <input type = "submit" value = "Update Info">
                </td>
                </tr>
                </div>
                </form>';
		}
        echo '
        </tbody>
        </table>
        </div>';

    }
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to access this page!");
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