<!-- actual item specific page -->
<!DOCTYPE html>
<html>
<body>
	<?php
    include_once ('./config.php');
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno()) {
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	if(isset($_COOKIE['UID'])) {
		$userid= $_COOKIE['UID'];
		$today = date("Ymd");
		if(isset($_GET['itemid'])) {
			$itemid=$_GET['itemid'];
            $minbid = "";
			 $code = "SELECT min_price from team_best_rds.tbl_bidding WHERE itemID =$itemid";
        $results = $con->query($code);
        if ($col = mysqli_fetch_array($results)) {
            $bidprice = $col['min_price'];
        }

		 $code2 = "SELECT MAX(bid_price) as hest from team_best_rds.tbl_user_bid WHERE itemID =$itemid";
        $results = $con->query($code2);
        if ($col2 = mysqli_fetch_array($results)) {
			echo $bidprice;
			echo $col2['hest'];
            if($bidprice < $col2['hest'])
			{
				$bidprice=$col2['hest'];
			}
        }
            if (isset($_POST['qqqq'])) {
                $newprice = $_POST['qqqq'];
                if ($newprice <= $bidprice) {
                    echo'<script>
                function myFunction2() {
                    var r = confirm("Too late! Someone else placed a higher bid.");
                    if (r == true) {
                        window.location.href = "index.php";
                    } else {
                        window.location.href = "index.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction2();
        </script>';
                } else {
                     $time=date('Y-m-d H:i:s',time());
            $query="insert into team_best_rds.tbl_user_bid (userID, itemID, bid_price, bid_time)
			values ($userid, $itemid,$newprice,'$time') ";
			if ($con->query($query) === TRUE) {
    			echo'<script>
                function myFunction1() {
                    var r = confirm("Your bid has been placed");
                    if (r == true) {
                        window.location.href = "index.php";
                    } else {
                        window.location.href = "index.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction1();
        </script>';
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}}
            }
           
		} else {
			echo "<div class='alert'>
  			<span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span> 
  			<strong>Danger!</strong> no item
			</div>";
		}
	} else {  
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to place a bid!");
                    if (r == true) {
                        window.location.href = "login.php";
                    } else {
                        window.location.href = "index.php";
                    }
                }
        </script>
        <script type="text/javascript">
            myFunction();
        </script>';
	}
mysqli_close($con);
?>
</body>
</html>