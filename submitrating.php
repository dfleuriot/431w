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
        $itemid = $_GET['itemid'];
        $orderid = $_GET['orderid'];

        $rating = $_POST["itemrate"];
        $userid= $_COOKIE['UID'];

        $query_check = "select * from tbl_itemratings where itemID = $itemid and userID = $userid";

        if ($con->query($query_check) == TRUE) { //if the user already rated on an item
    			echo'<script>
                function myFunction() {
                    var r = confirm("You already rated this item!");
                    if (r == true) {
                        window.location.href = "orderdetails.php?orderid='.$orderid.'";
                    } else {
                        window.location.href = "orderdetails.php?orderid='.$orderid.'";
                    }
                }
                </script>
                <script type="text/javascript">
                    myFunction();
                </script>'
                ;
                //header("location:/orderdetails.php?orderid=$orderid");
		} else
        { 

        $query="insert into tbl_itemratings (itemID,rating,userID,orderID)
                values($itemid,$rating,$userid,$orderid)";

        if ($con->query($query) == TRUE) {
    			echo "New record created successfully";
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}
        }

    }else{
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