<!-- BEGINING OF CATE -->
<div id="wrapper">																		                                                                                                         																																																					
	<div id="content_inside">     
	<form method="get" action="getanitem.php">
    	<input type="hidden" name="itemid" value="var_value">
		<input tpye="submit">
	</form>
	<?php
		include_once ('./config.php');
    	$var_value = $_GET['itemid'];
        $con = new mysqli($servername, $username, $password, $dbname);
				// Check connection
		if (mysqli_connect_errno()) {
			echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
		}
		//echo $var_value;
		$query="SELECT i.name AS iname, c.name AS cname,itemprice,description FROM team_best_rds.tbl_items i,team_best_rds.tbl_item_categories c WHERE i.itemID='$var_value' AND i.curr_level=c.curr_level";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
        $code = "SELECT min_price from team_best_rds.tbl_bidding WHERE itemID =$var_value";
        $results = $con->query($code);
        while ($col = mysqli_fetch_array($results)) {
            $bidprice = $col['min_price'];
        }

		echo '<div id="main_block" class="style1">																																																																													
			<div id="item">
            <h4>'.$row['iname'].'</h4><br />
            	<div class="big_view">
					<img src="./imgs/item2.jpg" alt="" width="311" height="319" /><br />
				</div>
			</div>
			<div class="description">
				<p>
					<strong>'.$row['cname'].'</strong><br />
                	'.$row['description'].'
            	</p>
            	<p>
					<span class="view"> <p>Bid Price: </p></span>
                	<input type="text" name="Bid Price" value=$bidprice style="width: 100px;padding: 12px 16px;top: -60px;left: 70px;position: relative;"></input>
                	<a href="#" class="cart">Place Bid</a>
				</p>
        	</div>
		</div>';
		// echo $result['cname'];
		mysqli_close($con);          
	?>