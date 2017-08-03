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
		$query="select * from team_best_rds.tbl_billing_address where userID = $userid";
		$result = $con->query($query);
        $row = mysqli_fetch_array($result);
		if(isset($_GET['action']))
			{
				if($_GET['action']=='remove')
				{
					$shipid=$_GET['code'];
					$query="UPDATE tbl_billing_address set deleted = 1 where baddrID = $shipid and userID=$userid";
					$con->query($query);
                    echo'
                    window.location.href = "billaddr.php"';
				}
			
				elseif($_GET['action']=='edit')
				{
					//$query="DELETE from team_best_rds.tbl_orderdetails where orderID = $orderID";
					//$con->query($query);
                    echo'
                    window.location.href = "editbilladdr.php"';
				}
			}
        //get info
        $query="select * from team_best_rds.tbl_billing_address where userID = $userid and deleted = 0";
        $result = $con->query($query);
        echo '
        <div id="shopping-cart" style="margin-top: 60px;">
			<div class="txt-heading"><Strong>Manage Billing Address</strong></div>
			<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
			<th style="text-align:left;"><h4>Address</h4></th>
			<th style="text-align:left;"><h4>City</h4></th>
			<th style="text-align:center;"><h4>State</h4></th>
            <th style="text-align:center;"><h4>Zip Code</h4></th>
			<th style="text-align:center;"></th>
            <th style="text-align:center;"></th>
            <th style="text-align:center;"></th>
			</tr>	';
        while($row = mysqli_fetch_array($result))
                {
                    $add1and2 = $row["address1"]." ".$row["address2"];
                echo '<tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$add1and2.'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["city"].'</td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;">'.$row["state"].'</td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;">'.$row["zipcode"].'</td>
                <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="billaddr.php?action=edit&code='.$row["baddrID"].'" class="btnRemoveAction">Edit Billing Address</a></td>
			    <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="billaddr.php?action=remove&code='.$row["baddrID"].'" class="btnRemoveAction">Delete Billing address</a></td>
                </tr></div>';
			}
        echo '
                <tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "Address" type = "text" placeholder="Address (Street Name)">
                </td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "City" type = "text" placeholder="City">
                </td>
                <td style="text-align:center;border-bottom:#F0F0F0 1px solid;">
				<input name = "State" type = "text" placeholder ="e.g. PA">
				</td>
                <td style="text-align:center;border-bottom:#F0F0F0 1px solid;">
				<input name = "ZipCode" type = "text" placeholder ="e.g. 16803">
				</td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;">
                <input type = "submit" value = "Add New">
                </td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
				</td>
                </tr>
                </div>
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