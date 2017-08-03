<!DOCTYPE html>
<html>
<body>

	<?php
    include_once ('./config.php');
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	if(isset($_COOKIE['UID']))
	{
		//echo $_COOKIE['UID'];
		$userid= $_COOKIE['UID'];
        $query="insert into team_best_rds.tbl_seller (userID)
			values ($userid) ";
			if ($con->query($query) === TRUE) {
    			echo "New record created successfully";
                header("location:/myaccount.php");
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}
    }
	else{
		echo'<script>
                function myFunction() {
                    var r = confirm("Please Log In or Register to add an item to cart!");
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