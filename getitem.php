<!DOCTYPE html>
<html>
<body>

<?php
    include_once ('./config.php');
	if(isset($_GET['category'])) {
    // id index exists
}else {
$category=9;
}
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT itemID, itemprice, isBid, name, qty,isBid, filename FROM tbl_items WHERE qty!=0 and curr_level like '$category%' and itemID<>9999 order by itemID DESC";
$result = $conn->query($sql);

while ($row = mysqli_fetch_array($result)) {
    if($row['isBid']==0)
    {
echo '
    <div class="item">
        <img src="./imgs/'.$row['filename'].'" alt="" width="202" height="173" /><br />
        <span>$'.$row['itemprice']. '</span>
        <a href="item.php?itemid='.$row['itemID'].'&category=9 " class="view">'.$row['name'].'</a>
       
        <a class="cart" href="addtocart.php?itemid='.$row['itemID'].'">Add To Cart</a>
	
    </div>
    ';}else{
        echo '
    <div class="item">
        <img src="./imgs/'.$row['filename'].'" alt="" width="202" height="173" /><br />
        <span>$'.$row['itemprice']. '</span>
        <a href="item.php?itemid='.$row['itemID'].'&category=9 " class="view">'.$row['name'].'</a>
       
        <p class="cart" >Item is on Bid</p>
	
    </div>';
    }
}
$conn->close();
?>

</body>
</html>