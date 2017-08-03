<!-- actual item specific page -->
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
        if(!isset($_COOKIE['sup']))
        {
		//echo $_COOKIE['UID'];
		$userid = $_COOKIE['UID'];
        $fname = $_POST['FirstName'];
        $lname = $_POST['LastName'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $pwd = $_POST['pwd1'];
        $phone = $_POST['phone_num'];

		$query="UPDATE tbl_users set FirstName='$fname',LastName='$lname',email='$email',pwd='$pwd',DOB='$dob',phone_num=$phone where userID=$userid";
		if ($con->query($query) === TRUE) {
    			echo "New record created successfully";
                //header("location:/myaccount.php");
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}
         $sql = "SELECT * FROM tbl_seller  WHERE userID = $userid";
                        $result = mysqli_query($con,$sql);
                        if($row = mysqli_fetch_array($result))
                        {
                            $seller=$row['sellerID'];
                            $income=$_POST['annual_income'];
                            $query="UPDATE tbl_seller set annual_income='$income'where sellerID=$seller";
                            if ($con->query($query) === TRUE) {
                                echo "New record created successfully";
                                header("location:/myaccount.php");
                            } else {
                                echo "Error: " . $query . "<br>" . $con->error;
                            }
                        }else{
                            header("location:/myaccount.php");
                        }
		

        }else{
            //echo $_COOKIE['UID'];
		$userid = $_COOKIE['UID'];
        $fname = $_POST['Name'];
        $email = $_POST['email'];
        $dob = $_POST['address'];
        $pwd = $_POST['pwd1'];
        $phone = $_POST['manager'];
        $income=$_POST['annual_income'];
		$query="UPDATE tbl_supplier set name='$fname',email='$email',pwd='$pwd',address='$dob',managername='$phone' where supplierID=$userid";
		if ($con->query($query) === TRUE) {
    			echo "New record created successfully";
                //header("location:/myaccount.php");
			} else {
    			echo "Error: " . $query . "<br>" . $con->error;
			}
        }
        $sql = "SELECT * FROM tbl_supplier  WHERE supplierID = $userid";
                    $result = mysqli_query($con,$sql);
                    if($row = mysqli_fetch_array($result))
                    {
                        echo "done";
                    }	
                    $sellerID=$row['sellerID'];
                    $query="UPDATE tbl_seller set annual_income='$income'where sellerID=$sellerID";
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

				// Check connection


//echo $var_value;



//    echo $result['cname'];

mysqli_close($con);

?>

</body>
</html>