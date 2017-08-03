<?php
include("./config.php");

session_start();

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname = $_POST['fnamesignup'];
$lname = $_POST['lnamesignup'];
$email = $_POST['emailsignup'];
$pwd   = $_POST['passwordsignup'];

if (isset($_POST['regsupplier'])) { //register as a supplier
    //create seller first to be able to get a seller id
    $sql = "INSERT INTO team_best_rds.tbl_seller (userID)
        VALUES (null)";
    
    if (mysqli_query($conn, $sql)) { //grab seller id from table
        
        $sql = "SELECT * FROM team_best_rds.tbl_seller order by sellerID desc limit 1";
        
        $result   = $result = $conn->query($sql);
        $row      = mysqli_fetch_array($result);
        $sellerid = $row['sellerID']; //save the recently created seller id. it will be used to populate tbl_supplier
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    $sql2 = "INSERT INTO team_best_rds.tbl_supplier (name,email,pwd, sellerID)
        VALUES ('$fname', '$email', '$pwd', $sellerid)";
    
    if (mysqli_query($conn, $sql2)) {
        //echo "New supplier created successfully";
        setcookie(sup, 1, time() + (1800), "/"); //if 1 => a supplier is logged in
        setcookie(email, $email, time() + (1800), "/");
        header("location: /mysupplieraccount.php");
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
} else { //else register as a regular user
    setcookie(kli, "", time() + (1800), "/");
    $sql = "INSERT INTO team_best_rds.tbl_users (FirstName,LastName,email,pwd)
        VALUES ('$fname', '$lname', '$email', '$pwd')";
    
    if (mysqli_query($conn, $sql)) {
        $sql = "SELECT * FROM team_best_rds.tbl_users where email = '$email'";
        
        $result = $result = $conn->query($sql);
        $row    = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $uid    = $row['userID'];
        
        //echo "New record created successfully";
        setcookie(email, $email, time() + (1800), "/");
        setcookie(name, $fname, time() + (1800), "/");
        setcookie(UID, $uid, time() + (1800), "/");
        header("location: /index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>