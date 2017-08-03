<?php
    include_once ('./config.php');
	$numinstock=0;
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
    $time=time();
    $code = "select userID,b.itemID,max(bid_price) AS max_price,time_lim,reserve_price from team_best_rds.tbl_bidding b, team_best_rds.tbl_user_bid u 
group by b.itemID";
        $results = $con->query($code);
       while ($col = mysqli_fetch_array($results)) {
            $time_lim = $col['time_lim'];  
            $newtime=strtotime($time_lim)-$time+6*60*60;
            echo $newtime."   ".strtotime($time_lim)."    ".$time."/n";
            if($newtime<0)
            {
                if($col['reserve_price']<$col['max_price'])
                {
                    $itemid=$col['itemID'];
                    $userid=$col['userID'];
                    $query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
                    $result = mysqli_query($con,$query);
                    $row = mysqli_fetch_array($result);
                    $ccID = $row['ccID'];
                    $today = date("Ymd");
                    $query="insert into team_best_rds.tbl_orders (ccID, date, shipped, cart)
                    values ($ccID, $today,0,0) ";
                    if ($con->query($query) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }
                    $query="select * from team_best_rds.tbl_orders where ccID = $ccID order by orderID desc limit 1";
                    $result = $con->query($query);
                    $row = mysqli_fetch_array($result);
                    $orderID=$row['orderID'];
                    $query="UPDATE team_best_rds.tbl_items SET qty = 0 WHERE itemID=$itemid";
                    if ($con->query($query) == TRUE) {
                        echo "New record created successfully";
                        //header("location:/index.php");
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }
                    $query="insert into team_best_rds.tbl_orderdetails (orderID, itemID, qty) values ($orderID, $itemid,1)";
                    if ($con->query($query) == TRUE) {
                        echo "add order details    ";
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }	
                }
                $query="DELETE FROM team_best_rds.tbl_bidding WHERE itemID=$itemid";
                    if ($con->query($query) == TRUE) {
                        echo "deleted";
                        
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }	

            }
        }
        $code = "select itemID,time_lim,reserve_price from team_best_rds.tbl_bidding";
        $results = $con->query($code);
       while ($col = mysqli_fetch_array($results)) {
           $itemid=$col['itemID'];
            $time_lim = $col['time_lim'];  
            $newtime=strtotime($time_lim)-$time+6*60*60;
            echo $newtime."   ".strtotime($time_lim)."    ".$time."/n";
            if($newtime<0){
                    $query="UPDATE team_best_rds.tbl_items SET qty = 0 WHERE itemID=$itemid";
                    if ($con->query($query) == TRUE) {
                        echo "New record created successfully";
                        //header("location:/index.php");
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }
                    $query="DELETE FROM team_best_rds.tbl_bidding WHERE itemID=$itemid";
                    if ($con->query($query) == TRUE) {
                        echo "deleted";
                        
                    } else {
                        echo "Error: " . $query . "<br>" . $con->error;
                    }	
            }
        }
        header("location:/index.php?a=1");
    ?>