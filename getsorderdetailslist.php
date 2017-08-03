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
        $orderid = $_GET['orderid'];
        
        $userid= $_COOKIE['UID'];

		$query="select *, od.qty as numbuy from tbl_orderdetails od, tbl_items i where od.orderID = $orderid and od.itemID = i.itemID";
		$result = $con->query($query);
        //$row = mysqli_fetch_array($result);
        echo '
        <div id="shopping-cart" style="margin-top: 60px;">
			<div class="txt-heading"><Strong>Order Details for Order# '.$orderid.'</strong></div>
			<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
			<th style="text-align:center;"><h4>Item </h4></th>
            <th style="text-align:left;"><h4>Qty</h4></th>
			<th style="text-align:left;"><h4>Price</h4></th>
			</tr>	';

        //$query2="select *, od.qty as numbuy from tbl_orderdetails od, tbl_items i where od.orderID = $orderid and od.itemID = i.itemID";
		//$result2 = $con->query($query2);



        while($row = mysqli_fetch_array($result))
        {
                $itemid = $row["itemID"];
                $orderid = $_GET['orderid'];
                $isbid = $row["isBid"];
                echo '
                <form method="post" action="submitrating.php?itemid='.$itemid.'&orderid='.$orderid.'" name="form">  
                <tr>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;">'.$row["name"].'</td>
                ';
                if ($isbid == 0){
                echo'
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["numbuy"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["itemprice"].'</td>
                </tr></div></form>';
                $item_total += ($row["itemprice"]*$row["numbuy"]);

                }else{
                    $sql= "select max(bid_price) as price from tbl_user_bid where itemID = $itemid";
                    $result2 = $con->query($sql);
                    $row2 = mysqli_fetch_array($result2);
                    $price = $row2["price"];
                echo'
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["numbuy"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row2["price"].'</td>
                </tr></div></form>';
                $item_total += ($row2["price"]*$row["numbuy"]);
                }
			}
        echo '<tr>
		<td colspan="5" align=right style = "padding-right: 25px;"><strong><h4>Total: $ </></strong>'.$item_total.'</td>
		</tr>
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