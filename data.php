<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';

    $notLogged = true;
    if(@@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}

    @$csvData = json_decode($_GET['data'], true);
    @$operation = $_GET['operation'];

    $order_id = $csvData["order_id"];
    $product_code = $csvData["product_code"];
    $name = $csvData["name"];
    $email = $csvData["email"];
    $mobile = $csvData["mobile"];
    $address_line_one = $csvData["address_line_one"];
    $address_line_two = $csvData["address_line_two"];
    $suburb = $csvData["suburb"];
    $state = $csvData["state"];
    $postcode = $csvData["postcode"];
    $country = $csvData["country"];

    $sql = "INSERT INTO orders (order_id, product_code, name, email, mobile, address_line_one, address_line_two, suburb, state, postcode, country, status) 
    VALUES ('".$order_id."', '".$product_code."', '".$name."', '".$email."', '".$mobile."', '".$address_line_one."', '".$address_line_two."', '".$suburb."', '".$state."', '".$postcode."', '".$country."', '".$country."' );";
    
        if ($connection->query($sql) === TRUE) {        
            echo 'inserted';
        } else {        
            echo $connection->error;
        }

    if($operation == 'updateUserPass'){
        @$oldPsssword = md5($_POST['oldPsssword']);
        @$newPassword = md5($_POST['newPassword']);
        @$newPasswordVerify = md5($_POST['newPasswordVerify']);

        if($newPassword===$newPasswordVerify){
            $sql = "SELECT 	userPass FROM user WHERE userID = ".@@$_SESSION['user_id'];
            $result = $connection->query($sql);        
            while ($rowUser = $result->fetch_assoc()) {
                if($oldPsssword===$rowUser['userPass']){
                    $sql = "UPDATE user SET userPass ='".$newPassword."' WHERE userID=".@@$_SESSION['user_id']; 
                    if ($connection->query($sql) === TRUE) {
                        header('Location: account.php?operation=saveUser');
                    } else { 
                        header('Location: account.php?error='.$connection->error);
                    }
                }else{
                    header('Location: account.php?error=Old Password Incorrect');
                }
            }
        }else{
            header('Location: account.php?error=New Password Mismatch');
        }            
    }elseif($operation == 'addUser'){
        @$displayName = $_POST['displayName'];
        @$userName = $_POST['userName'];
        @$userType = $_POST['userType'];
        @$password = md5($_POST['password']);
        @$passwordVerify = md5($_POST['passwordVerify']);
        
        if(@$password===@$passwordVerify){    
            $addUserSQL = "INSERT INTO user(userType, userName, userPass, displayName) VALUES ('".$userType."', '".$userName."', '".$password."', '".$displayName."');";
        
            if ($connection->query($addUserSQL) === TRUE) {
                header('Location: account.php?operation=saveUser');
            } else { 
                header('Location: account.php?error='.$connection->error);
            }
        }else{
            header('Location: account.php?error=Password Mismatch');
        }
    }elseif($operation == 'deleteUser'){
        @$userID = $_GET['userID'];

        $deleteUserSQL = "DELETE FROM user WHERE userID =".$userID;

        if ($connection->query($deleteUserSQL) === TRUE) {
            header('Location: account.php?operation=');
        } else {
            header('Location: account.php?error='.$connection->error);
        }
    }
?>
    
