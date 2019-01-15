<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';

    $notLogged = true;
    if(@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}


    if (isset($_GET['pageno'])) {$pageno = $_GET['pageno'];} else {$pageno = 1;}

    $no_of_records_per_page = 10;
    $offset = ($pageno-1) * $no_of_records_per_page;

    $total_pages_sql = "SELECT COUNT(*) FROM orders";
    $result = mysqli_query($connection,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    $sql = "SELECT * FROM orders LIMIT $offset, $no_of_records_per_page";
    $res_data = mysqli_query($connection,$sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $headerLinks; ?> 
    </head>
    <body>
        <?php echo str_replace('{{home}}', 'active', $navBar); ?>
        <div class="container">
            <div class="card">
                <div class="card-header">List of Past Orders</div>
                <div class="card-body">                                        
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr><th>Ordr #</th><th>Order Date</th><th>Name</th><th>Email</th><th>Mobile</th><th>Shipping Status</th></tr>
                        </thead>
                        <tbody>        
                        <?php
                            while($row = mysqli_fetch_array($res_data)){                        
                                echo '<tr id="'.$row['id'].'" class="orderRow"><td>'.$row['order_id'].'</td><td></td><td>'.$row['name'].'</td><td>'.$row['email'].'</td><td>'.$row['mobile'].'</td><td>'.$row['status'].'</td></tr>';
                                echo '<tr id="detailRow'.$row['id'].'" style="display:none;"><td colspan="2">Product Code : '.$row['product_code'].'</td><td>Adress :</td><td colspan="4">'.$row['address_line_one'].'<br/>'.$row['address_line_two'].'<br/>'.$row['suburb'].' '.$row['state'].' '.$row['postcode'].'</td></tr>';
                            }
                        ?>
                        </tbody>
                    </table>

                    <ul class="pagination justify-content-end">
                        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                        <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
                </div>
            </div>

            
        </div>
    </body>
    <script>
        $(".orderRow").click(function(){            
            window.location.href = "./orderDetails.php?ID="+this.id;
        });

        $(".orderRow").hover(function(){  
            detailRowid="detailRow"+this.id;        
            $("#"+detailRowid).show();
        });

        $(".orderRow").mouseout(function(){  
            detailRowid="detailRow"+this.id;        
            $("#"+detailRowid).hide();
        });        
    </script>
</html>

<?php mysqli_close($connection); ?>