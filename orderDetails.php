<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';

    $notLogged = true;
    if(@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}

    if (isset($_GET['ID'])) {$ID = $_GET['ID'];}

    $order_data = $connection->query("SELECT O.id, O.order_id, O.product_code, O.name AS customer, O.email, O.mobile, O.address_line_one, O.address_line_two, O.suburb, O.state, O.postcode, O.country, O.status, P.name AS product FROM orders O INNER JOIN products P ON O.Product_code=P.code WHERE O.id=".$ID);
    $order_data_array = $order_data->fetch_assoc();  
    
    $sql="SELECT * FROM orders WHERE name LIKE ".'"'.$order_data_array['customer'].'"';
    $ordersByCustomer = mysqli_query($connection,$sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $headerLinks; ?>
    </head>
    <body>
        <?php echo str_replace('{{home}}', 'active', $navBar); ?>
        <div class="container col-10">            
            <div class="card">                
                <div class="card-header">Order Details for Order ID :<?php echo $order_data_array['id']; ?></div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-2">Order ID :</label><div class="col-4"><?php echo $order_data_array['order_id']; ?></div>
                        <label class="col-2">Product Code :</label><div class="col-4"><?php echo $order_data_array['product_code']; ?></div>
                    </div>
                    <div class="row">
                        <label class="col-2">Product :</label><div class="col-8"><?php echo $order_data_array['product']; ?></div>                        
                    </div><br />
                    <div class="row">
                        <label class="col-4">Customer Name :</label><div class="col-8"><?php echo $order_data_array['customer']; ?></div>                        
                    </div>
                    <div class="row">
                        <label class="col-4">Customer Email :</label><div class="col-8"><?php echo $order_data_array['email']; ?></div>                        
                    </div>
                    <div class="row">
                        <label class="col-4">Customer Mobile :</label><div class="col-8"><?php echo $order_data_array['mobile']; ?></div>                        
                    </div>
                    <div class="row">
                        <label class="col-4">Customer Address :</label>
                        <div class="col-8">
                        <?php echo $order_data_array['address_line_one'].'<br>'.$order_data_array['address_line_two'].'<br>'.$order_data_array['suburb'].' '.$order_data_array['state'].' '.$order_data_array['postcode']?>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-dark table-striped table-hover">
                            <thead>
                                <tr><th colspan="7" class="text-center">All orders by the customer</th></tr>
                                <tr><th>Ordr #</th><th>Order Date</th><th>Name</th><th>Email</th><th>Mobile</th><th>Shipping Status</th></tr>
                            </thead>
                            <tbody> 
                            <?php                                
                                while($row = mysqli_fetch_array($ordersByCustomer)){ 
                                    echo '<tr><td>'.$row['order_id'].'</td><td></td><td>'.$row['name'].'</td><td>'.$row['email'].'</td><td>'.$row['mobile'].'</td><td>'.$row['status'].'</td></tr>';                                                           
                                }
                            ?> 
                            </tbody>
                        </table>                      
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
        