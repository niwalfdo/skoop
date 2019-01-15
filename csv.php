<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';
    include_once './includes/functions.php';

    $notLogged = true;
    if(@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}

    $products = $connection->query("SELECT code FROM products");
    $productsArray = array();
    while($row = mysqli_fetch_array($products)){
        array_push($productsArray, $row['0']);        
    }   
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $headerLinks; ?>
    </head>
    <body>
        <?php echo str_replace('{{csv}}', 'active', $navBar); ?>
        <?php if(isset($_POST['Import'])){ ?>
        <?php
            $filename=$_FILES['file']['tmp_name'];
            if($_FILES['file']['size'] > 0)
            {
                $file = fopen($filename, 'r');                     
        ?>
        <div class="container text-right">                     
            <button type="button" class="btn btn-secondary" id="addCSV_Data">Add Data</button>                        
        </div><br />
        <div class="container" style="display:none" id="errorBlock">
            <p class="alert alert-danger" id="errorNote"></p>
        </div>                                             
        <table class="table table-light table-striped table-hover">
            <thead>
                <tr><th>#</th><th>Ordr #</th><th>Product ID</th><th>Customer Name</th><th>Email</th><th>Mobile</th><th>Address Line 1</th><th>Address Line 2</th><th>Suburb</th><th>State</th><th>Post Code</th><th>Country</th><th># Invali data</th></tr>
            </thead>
            <tbody>   
        <?php       
                $i=1;
                $csv = array();
                $totalErrors=0;
                while (($getData = fgetcsv($file, 0, ',')) !== FALSE)
                {                    
                    $getData[12]=0;

                    $productID = validateProductID($getData[2], $productsArray, $i, $getData[12]);                    
                    $getData[12]=$productID[1];

                    $name = validateName($getData[3], $i, $getData[12]);
                    $getData[12]=$name[1];

                    $email = validateEmail($getData[4], $i, $getData[12]);
                    $getData[12]=$email[1];

                    $addressOne = validateAddLineOne($getData[6], $i, $getData[12]);
                    $getData[12]=$addressOne[1];

                    $postCode = validatePostCode($getData[10], $i, $getData[12]);
                    $getData[12]=$postCode[1];
                    
                    $state = validateState($getData[9], $i, $getData[12]);
                    $getData[12]=$state[1];
                    
                    $country = validateCountry($getData[11], $i, $getData[12]);
                    $getData[12]=$country[1];

                    $totalErrors=$totalErrors+$getData[12];
                    echo '
                    <tr id="trID'.$i.'">
                    <td>'.$i.'</td>
                    <td>'.$getData[1].'</td>
                    <td>'.$productID[0].'</td>
                    <td>'.$name[0].'</td>
                    <td>'.$email[0].'</td>
                    <td>'.$getData[5].'</td>
                    <td>'.$addressOne[0].'</td>
                    <td>'.$getData[7].'</td>
                    <td>'.$getData[8].'</td>
                    <td>'.$state[0].'</td>
                    <td>'.$postCode[0].'</td>
                    <td>'.$country[0].'</td>
                    <td>'.$getData[12].'</td>
                    </tr>
                    ';
                    $csv[$i]=array("order_id"=>$getData[1], 
                                    "product_code"=>$getData[2], 
                                    "name"=>$getData[3], 
                                    "email"=>$getData[4], 
                                    "mobile"=>$getData[5], 
                                    "address_line_one"=>$getData[6], 
                                    "address_line_two"=>$getData[7], 
                                    "suburb"=>$getData[8], 
                                    "state"=>$getData[9], 
                                    "postcode"=>$getData[10], 
                                    "country"=>$getData[11],
                                    "errors"=>$getData[12]);
                    $i++;   
                }                
                fclose($file);                
            }
        ?>
            </tbody>
        </table>
           
        <?php 
        }else{ ?>
        <div class="container col-6">
            <div class="card">
                <div class="card-header">Upload CSV</div>
                <div class="card-body">                    
                    <form class="form-inline" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                        <div class="form-group col-12">
                            <label class="col-4 control-label">Select File</label>
                            <div class="col-8">
                                <input type="file" name="file" id="file" class="form-control-file border">
                            </div>
                        </div><br /><br /> 
                        <div class="form-group col-12">
                            <label class="col-4 control-label">Import data</label>
                            <div class="col-8">
                                <button type="submit" id="submit" name="Import" class="btn btn-dark button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <?php 
        } ?>

        <script>
             var csvJSON=<?php echo json_encode($csv) ?>;
             var products=<?php echo json_encode($productsArray) ?>; 
             var totalErrors=<?php echo $totalErrors ?>; 

             $( document ).ready(function() {
                errorDisplay(totalErrors);                
            }); 
        </script>

        <?php echo $jsScript ?>
    </body>
</html>