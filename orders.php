<?php
include_once './includes/template.php';
include_once './includes/dbconn.php';

$notLogged = true;
if(@$_SESSION['loggedIn']){$notLogged = false;}
if($notLogged){header('Location: index.php?operation=logOut');}


if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;

/*
$conn=mysqli_connect("localhost","my_user","my_password","my_db");
// Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}
*/

$total_pages_sql = "SELECT COUNT(*) FROM orders";
$result = mysqli_query($connection,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT * FROM orders LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($connection,$sql);



echo'
<!DOCTYPE html>
<html>
    <head>
        '.$headerLinks.'
    </head>
    <body>';

echo str_replace('{{home}}', 'active', $navBar);

echo '
<div class="container">
    <h4>Item List of Job Number : </h4>
            
    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Item Type</th>
            <th>Item Name</th>
            <th>Item Info</th>
            <th>Length</th>                
            <th>Final Length</th>                
            <th></th>
        </tr>
        </thead>
        <tbody>
    ';

while($row = mysqli_fetch_array($res_data)){
    //here goes the data
    echo '<tr><td>'.$row['name'].'</td></tr>';
}

?>
<ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
</body>
</html>

<?php mysqli_close($connection); ?>