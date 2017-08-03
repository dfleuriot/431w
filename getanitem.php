<!-- actual item specific page -->
<!DOCTYPE html>
<html>

<style>
.btn {
  background: #34d976;
  background-image: -webkit-linear-gradient(top, #34d976, #004508);
  background-image: -moz-linear-gradient(top, #34d976, #004508);
  background-image: -ms-linear-gradient(top, #34d976, #004508);
  background-image: -o-linear-gradient(top, #34d976, #004508);
  background-image: linear-gradient(to bottom, #34d976, #004508);
  -webkit-border-radius: 4;
  -moz-border-radius: 4;
  border-radius: 4px;
  font-family: Arial;
  color: #ffffff;
  font-size: 10px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn:hover {
  background: #00820f;
  background-image: -webkit-linear-gradient(top, #00820f, #0d6300);
  background-image: -moz-linear-gradient(top, #00820f, #0d6300);
  background-image: -ms-linear-gradient(top, #00820f, #0d6300);
  background-image: -o-linear-gradient(top, #00820f, #0d6300);
  background-image: linear-gradient(to bottom, #00820f, #0d6300);
  text-decoration: none;
}
</style>
<body>

	<?php
    include_once ('./config.php');
    $var_value = $_GET['itemid'];
$con=mysqli_connect($servername,$username,$password,$dbname);
				// Check connection
if (mysqli_connect_errno())
{
echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
}

//echo $var_value;
$query="SELECT i.name AS iname, c.name AS cname,itemprice,description, itemID, isBid, filename
FROM team_best_rds.tbl_items i,team_best_rds.tbl_item_categories c 
WHERE i.itemID='$var_value' AND i.curr_level=c.curr_level";
$result = mysqli_query($con,$query);


$row = mysqli_fetch_array($result);
if($row['isBid']==0)
{
echo '<div id="main_block" class="style1">																																																																													
		<div id="item">
            <h4>'.$row['iname'].'</h4><br />
            <div class="big_view">
				<img src="./imgs/'.$row['filename'].'" alt="" width="311" height="319" /><br />
				<span>$'.$row['itemprice'].'</span>
			</div>
		</div>
		<div class="description">
			<p>
				<strong>'.$row['cname'].'</strong><br />
                '.$row['description'].'
            </p>
            <p>
				<!--<span class="view"> <p>Qty: </p></span>-->
                 <form method="post" action="addtocart.php?itemid='.$row['itemID'].'">
           Qty: <input type="text" name="qqqq" value="1" style="width: 50px;padding: 12px 16px;top: -60px;left: -100px;<!--position: relative;-->"></input></br></br>
	        <input class = "btn" type="submit" value="Add to Cart">   
 </form>
                <!--<a class="cart" href="addtocart.php?itemid='.$row['itemID'].'">Add To Cart</a>-->
			</p>
        </div>
	</div>';
}
else{
	$query="SELECT i.name AS iname, c.name AS cname,itemprice,description, filename FROM team_best_rds.tbl_items i,team_best_rds.tbl_item_categories c WHERE i.itemID='$var_value' AND i.curr_level=c.curr_level";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
        $file = $row['filename'];
        $code = "SELECT min_price,time_lim from team_best_rds.tbl_bidding WHERE itemID =$var_value";
        $results = $con->query($code);
        if ($col = mysqli_fetch_array($results)) {
            $bidprice = $col['min_price'];
            $time_lim = $col['time_lim'];
            
        }

		 $code2 = "SELECT MAX(bid_price) as hest from team_best_rds.tbl_user_bid WHERE itemID =$var_value";
        $results = $con->query($code2);
        if ($col2 = mysqli_fetch_array($results)) {
			echo $bidprice;
			echo $col2['hest'];
            if($bidprice < $col2['hest'])
			{
				$bidprice=$col2['hest'];
			}
        }

		echo '<div id="main_block" class="style1">																																																																													
			<div id="item">
            <h4>'.$row['iname'].'</h4><br />
            	<div class="big_view">
                <img src="./imgs/'.$file.'" alt="" width="311" height="319" /><br />
				</div>
			</div>
			<div class="description">
				<p>
					<strong>'.$row['cname'].'</strong><br />
                	'.$row['description'].'
            	</p>
				<h4>
				Current Highest Bid $'.$bidprice.'
				</h4>
            	<p>
                </p>
				<h4>
				Time Left 
                </h4>
                <p id="demo"></p>
                <script>

                var countDownDate = new Date("'.$time_lim.'").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

                // If the count down is finished, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
                }, 1000);
                </script>
            	<p>
					<form method="post" action="placebid.php?itemid='.$var_value.'">
           Current Bid: <input type="text" name="qqqq" value="" style="width: 100px;padding: 12px 16px;top: -60px;left: -100px;<!--position: relative;-->"></input></br></br>
	        <input class = "btn" type="submit" value="Place a Bid">   
 </form>
				</p>
        	</div>
		</div>';
        
}
//    echo $result['cname'];

mysqli_close($con);
?>

</body>
</html>