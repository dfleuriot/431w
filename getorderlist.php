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
        //get ccid
		$query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		$ccID = $row['ccID'];


		$query="select * from team_best_rds.tbl_orders where userID = $userid";
		$result = $con->query($query);
        $row = mysqli_fetch_array($result);
        //get info
        $query="select * from tbl_orders o, tbl_credit_card c where c.userID =$userid and c.ccID = o.ccID and o.cart = 0 order by o.orderID ASC";
        $result = $con->query($query);
        echo '
        <div id="shopping-cart" style="margin-top: 60px;">
			<div class="txt-heading"><Strong>My Orders</strong></div>
			<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
			<th style="text-align:left;"><h4>Order#</h4></th>
			<th style="text-align:left;"><h4>Date Placed</h4></th>
			<th style="text-align:left;"><h4>Carrier</h4></th>
            <th style="text-align:left;"><h4>Tracking No.</h4></th>
			<th style="text-align:left;"><h4>Estimated Shipping Date</h4></th>
            <th style="text-align:left;"><h4>Credit Card Used</h4></th>
            <th style="text-align:left;"><h4>Shipped</h4></th>
			</tr>	';
            
        while($row = mysqli_fetch_array($result))
        {   
               // $query2="select c.credit_card_num as ccnum from tbl_orders o, tbl_credit_card c where c.userID =$userid and c.ccID = o.ccID and o.cart = 0";
                //$result2 = mysqli_query($con,$query2);
                //$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
                $cardnum = substr($row['credit_card_num'], -4);
                $creditcard = "Card ending in ".$cardnum;
                
                if ($row["shipped"] == 1){
                    $status = "Shipped";
                }else{
                    $status = "Not Yet Shipped";
                }

                echo '<tr>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a style = "cursor:pointer;" href = "orderdetails.php?orderid='.$row["orderID"].'">'.$row["orderID"].'</a></td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["date"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["carrier"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["tracking_no"].'</td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["est_shipping_date"].'</td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$creditcard.'</td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$status.'</td>
                
                </tr></div>';
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