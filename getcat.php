<!DOCTYPE html>
<html>
<body>

	<?php
	$oldcatname;
	$oldcat;
	$category;
    include_once ('./config.php');
	if(isset($_GET['category'])) {
		$category = $_GET['category'];
    // id index exists
}else {
$category=9;
}
	/*try{$category = $_GET['category'];}catch (Exception $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	
}*/
$con=mysqli_connect($servername,$username,$password,$dbname);
				// Check connection
if (mysqli_connect_errno())
{
echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
}
$oldcat= substr($category,0,strlen($category)-1);
if($oldcat!='')
{
$result = mysqli_query($con,"SELECT name FROM team_best_rds.tbl_item_categories WHERE curr_level='$oldcat'");
$row = mysqli_fetch_array($result);
$oldcatname = $row['name'];
}
$result = mysqli_query($con,"SELECT name,curr_level FROM team_best_rds.tbl_item_categories WHERE parent_level='$category'");

//echo $oldcat;
if($oldcat!='') //if there's no parent'
{
//echo "<li><a href=index.php?category=$oldcat>$oldcatname</a></li>";
	if($oldcatname == "all"){
			echo "<span><a href=index.php?category=$oldcat> Go Back to All Categories</a></span>
			<br>
			<br>";
	}else{
			echo "<span><a href=index.php?category=$oldcat> Go Back to $oldcatname </a></span>
			<br>
			<br>";
	}
}
while($row = mysqli_fetch_array($result))
{
echo '<li style = "list-style-type: none;"><a href=index.php?category='.$row['curr_level'].'>'.$row['name'].'</a></li>';
if($row = mysqli_fetch_array($result)){
echo '<li style = "list-style-type: none;" class="color"><a href=index.php?category='.$row['curr_level'].'>'.$row['name'].'</a></li>';
}
}


mysqli_close($con);
?>

</body>
</html>