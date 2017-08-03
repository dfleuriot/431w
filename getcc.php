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
		$query="select * from team_best_rds.tbl_credit_card where userID = $userid";
		$result = $con->query($query);
        $row = mysqli_fetch_array($result);
		if(isset($_GET['action']))
			{
				if($_GET['action']=='remove')
				{
					$itemID=$_GET['code'];
					$query="UPDATE tbl_credit_card set deleted = 1 where ccID = $ccID and userID=$userid";
					$con->query($query);
                    echo'
                    window.location.href = "ccedit.php"';
				}
			
				elseif($_GET['action']=='edit')
				{
					//$query="DELETE from team_best_rds.tbl_orderdetails where orderID = $orderID";
					//$con->query($query);
                    echo'
                    window.location.href = "editcredit.php"';
				}
			}
        //get info
        $query="select * from team_best_rds.tbl_credit_card where userID = $userid and deleted = 0";
        $result = $con->query($query);
        echo '
        <div id="shopping-cart" style="margin-top: 60px;">
			<div class="txt-heading"><Strong>Manage Credit Cards</strong></div>
			<table cellpadding="10" cellspacing="1">
			<tbody>
			<tr>
			<th style="text-align:left;"><h4>Name on Card</h4></th>
			<th style="text-align:left;"><h4>Card Number</h4></th>
			<th style="text-align:left;"><h4>CVV</h4></th>
			<th style="text-align:left;"><h4>Expiry Date</h4></th>
			<th style="text-align:center;"></th>
            <th style="text-align:center;"></th>
			<th style="text-align:center;"></th>
			<th style="text-align:center;"></th>
			</tr>	';
        while($row = mysqli_fetch_array($result))
                {
                echo '<tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["Nameoncard"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["credit_card_num"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["security_num"].'</td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">'.$row["expiration_date"].'</td>
				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="ccedit.php?action=edit&code='.$row["ccID"].'" class="btnRemoveAction">Edit Credit Card</a></td>
			    <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="ccedit.php?action=remove&code='.$row["ccID"].'" class="btnRemoveAction">Delete Credit Card</a></td>
                </tr></div>';
			}
        echo '  
                <tr>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "Name" type = "text" placeholder="Name on Card">
                </td>
				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "ccnum" type = "text" placeholder="Credit Card Number">
                </td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                <input name = "cvv" type = "text" placeholder ="CVV/CVV2">
                </td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
				<input name = "exp_date" type = "text" placeholder ="MM/YY">
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