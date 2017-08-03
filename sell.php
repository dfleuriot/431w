<!DOCTYPE html>
<html>
<body>

	<?php
    include_once ('./config.php');
	$conn=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}

            if(isset($_COOKIE['UID']))
            {
                $userid = $_COOKIE['UID'];

                $query = "SELECT sellerID FROM tbl_seller WHERE userID = $userid";
                $result = $conn->query($query);
                $row = mysqli_fetch_array($result);		
                $sellerid = $row['sellerID'];

                $name = $_POST['ItemName'];
                $price = $_POST['Price'];
                $qty = $_POST['Qty'];
                $desc = $_POST['Description'];
                $cat = $_POST['Category'];
                if(isset($_POST['bid'])){
                    $isBid = 1;
                }else{
                    $isBid = 0;
                }
                $state = $_POST['stateshipped'];
                if ($isBid == 1){
                $reserveprice = $_POST['ReservePrice'];
                $minprice = $_POST['MinPrice'];
                $enddate = $_POST['EndDate'];
                }

                //for image upload
                $target_dir = "./imgs/";
                $file = $_FILES["fileToUpload"]["name"];
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo "Sorry, only JPG, JPEG files are allowed. Please go back.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
                //end of image stuff*/

                $query="insert into tbl_items (itemprice,sellerID,name,description,qty,state_shipped,isBid,curr_level, filename)
                        values($price,$sellerid,'$name', '$desc', $qty, '$state', $isBid, $cat, '$file' )";
                if ($conn->query($query) === TRUE) {
                    
                    if ($isBid ==1){
                    $sql = "SELECT itemID FROM tbl_items ORDER BY itemID DESC LIMIT 1";
                    $result2 = $conn->query($sql);
                    $row2 = mysqli_fetch_array($result2);
                    $itemID = $row2['itemID'];

                    $query2="insert into tbl_bidding (reserve_price,min_price,itemID,time_lim)
                    values($reserveprice, $minprice, $itemID , '$enddate')";
                    $conn->query($query2);

                        echo'<script>
                            function myFunction1() {
                                var r = confirm("Your item has succesfully been placed on auction!");
                                if (r == true) {
                                    window.location.href = "myaccount.php";
                                } else {
                                    window.location.href = "myaccount.php";
                                }
                            }
                            </script>
                            <script type="text/javascript">
                                myFunction1();
                            </script>';                       
                        }else{

                            echo'<script>
                            function myFunction1() {
                                var r = confirm("Your item has succesfully been placed on sale!");
                                if (r == true) {
                                    window.location.href = "myaccount.php";
                                } else {
                                    window.location.href = "myaccount.php";
                                }
                            }
                            </script>
                            <script type="text/javascript">
                                myFunction1();
                            </script>';                 
                            }
                }
                else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }    

            }
            else{
                echo'<script>
                        function myFunction() {
                            var r = confirm("Please Log In or Register to view this page!");
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

mysqli_close($conn);

?>

</body>
</html>