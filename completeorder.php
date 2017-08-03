<?php
    include_once ('./config.php');
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}

    if(isset($_POST['cc']))
	{
        $cc=$_POST['cc'];
        //echo $cc;
        //echo 'done';
    }
    if(isset($_POST['sa']))
	{
        $sa=$_POST['sa'];
        //echo $sa;
        //echo 'done';
    }
    if(isset($_POST['ba']))
	{
        $ba=$_POST['ba'];
        //echo $ba;
        //echo 'done';
    }
   // echo $orderID;
    if(isset($_COOKIE['UID']))
    {    
        $userid= $_COOKIE['UID'];
        //get ccid
		$query="select ccID from team_best_rds.tbl_credit_card where userID=$userid";
		$result = mysqli_query($con,$query);
		$row = mysqli_fetch_array($result);
		$ccID = $row['ccID'];
		//$today = date("Ymd");
        //get orderid
		$query="select * from team_best_rds.tbl_orders where ccID = $ccID and cart =1";
		$result = $con->query($query);
        $row = mysqli_fetch_array($result);
        $orderID=$row['orderID'];

        $query2 = "update tbl_orders SET cart = 0, ccID = $cc, shipping_addess=$sa,billing_addess=$ba where orderID = $orderID";
        $result = $con->query($query2);

        echo'<script>
            alert("Your order has been placed!")
            window.location.href = "index.php";
        </script>
        ';

    }
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to view cart!");
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