<?php
include_once './includes/template.php';
include_once './includes/dbconn.php';

//var_dump($_POST);
//var_dump($_GET);

if(@@$_GET['operation']=='logOut'){    
    session_destroy();
}

$invalid=false;
if(isset($_POST['userName']) && isset($_POST['password']) ){
    $username  = $_POST['userName'];
    $password  = $_POST['password'];
    $passwordMD5 = md5($password);
    
    $_SESSION['loggedIn'] = false;

    if(!empty($username) || !empty($password)){        
        $sql = "SELECT userID, displayName FROM user WHERE userName='".mysqli_real_escape_string($connection,$username)."' AND userPass='".mysqli_real_escape_string($connection,$passwordMD5)."'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {            
            $row = $result->fetch_assoc();
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $row["userID"];
            $_SESSION['display_name'] = $row["displayName"];            
            header('Location: orders.php?');
        }else{
            $invalid=true;
        }        
    }
}


echo'
<!DOCTYPE html>
<html>
    <head>
    '.$headerLinks.'
    </head>
    <body>';
if($invalid){
    echo '  <div class="alert alert-warning">
                <strong>Error!</strong> Invalid User Name or Password!.
            </div>';
}
        
echo'
        <form action="./index.php?" method="post" id="loginForm">
            <div class="container col-6">
                <div class="card">
                    <div class="card-header">Login</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 text-right" >User Name:</div>
                                <div class="col-9" ><input type="text" class="form-control" name="userName" id="userName" placeholder="User Name" value="" required></div>
                            </div><br />
                            <div class="row">                                 
                                <div class="col-3 text-right" >Password:</div>
                                <div class="col-9" ><input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" required></div>
                            </div><br />
                            <div class="row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-secondary" id="logIn">Log In</button>                                
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
        ';
        