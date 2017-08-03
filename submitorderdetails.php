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

        $carrier = $_POST["Carrier"];
        $tracking = $_POST["Tracking"];
        $shipdate = $_POST["ShipDate"];
        if(isset($_POST['Shipped'])){
            $shipped = 1;
        }else{
            $shipped = 0;
        }
        $query="UPDATE tbl_orders set carrier = '$carrier',est_shipping_date = '$shipdate',
                tracking_no = $tracking ,shipped= $shipped where orderID = $orderid";

        if ($con->query($query) == TRUE) {
    			header("location:/upcomingorders.php");
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
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