<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';

    $notLogged = true;
    if(@@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $headerLinks ?>
    </head>
    <body>
        <?php 
            echo str_replace('{{account}}', 'active', $navBar); 
    
            if(@@$_GET['error']!=''){
                echo '<div class="alert alert-warning"><strong>Error!</strong> '.@@$_GET['error'].'!.</div>';
            }
    
            $sql = "SELECT 	userType, userName, displayName FROM user WHERE userID = ".@@$_SESSION['user_id'];
            $result = $connection->query($sql);            
            while ($rowUser = $result->fetch_assoc()) {
            $userType = $rowUser['userType'];
        ?>
   
        <form action="./data.php?operation=updateUser" method="post" id="updateUserForm">
            <div class="container"><br />
                <div class="card">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 text-right" >Display Name :</div>
                            <div class="col-6" ><input type="text" class="form-control" id="displayName" name="displayName" placeholder="Display Name" value="<?php echo $rowUser['displayName'] ?>" ></div>
                            <div class="col-3 text-right"><button type="submit" class="btn btn-secondary" id="updateDisplayName">Change</button></div>
                        </div><br>
                        <div class="row">
                            <div class="col-3 text-right" >User Name :</div>
                            <div class="col-6" ><input type="text" class="form-control" id="userName" name="userName" placeholder="User Name" value="<?php echo $rowUser['userName'] ?>" ></div>
                            <div class="col-3 text-right"><button type="submit" class="btn btn-secondary" id="updateUserName">Change</button></div>
                        </div><br>
                        <div class="row">
                            <div class="col-3 text-right" ><b>Change Password</b></div>
                        </div>
        </form>
        <form action="./data.php?operation=updateUserPass" method="post" id="updateUserPassForm">
                        <div class="row">
                            <div class="col-3 text-right" >Old Password :</div>
                            <div class="col-6" ><input type="password" class="form-control" id="displayName" name="oldPsssword" placeholder="Old Password" value="" ></div>
                            <div class="col-3 text-right" ></div><br><br>
                            <div class="col-3 text-right" >New Password :</div>
                            <div class="col-6" ><input type="password" class="form-control" id="displayName" name="newPassword" placeholder="New Password" value="" ></div>
                            <div class="col-3 text-right" ></div><br><br>
                            <div class="col-3 text-right" >New Password (Verify):</div>
                            <div class="col-6" ><input type="password" class="form-control" id="displayName" name="newPasswordVerify" placeholder="New Password (Verify)" value="" ></div>
                            <div class="col-3 text-right" ></div>
                            <div class="col-9 text-right"><button type="submit" class="btn btn-secondary" id="updateUserPass">Change</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php 
            } 
    
            if($userType=="admin"){
        ?>
    
        <form action="./data.php?operation=addUser" method="post" id="addUserForm">
            <div class="container"><br />
                <div class="card">
                    <div class="card-header">Add New User</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 text-right" >Display Name :</div>
                            <div class="col-6" ><input type="text" class="form-control" id="displayName" name="displayName" placeholder="Display Name" value="" ></div>                        
                        </div><br>
                        <div class="row">
                            <div class="col-3 text-right" >User Name :</div>
                            <div class="col-6" ><input type="text" class="form-control" id="userName" name="userName" placeholder="User Name" value="" ></div>                        
                        </div><br>
                        <div class="row">
                            <div class="col-3 text-right" >User Type :</div>
                            <div class="col-6" >
                                <select class="chosen-select form-control " data-placeholder="Select User Type" id="userType" name="userType" required>
                                        <option value=""></option>
                                        <option value="admin">Administrator</option>
                                        <option value="user">System User</option>
                                </select>
                            </div>                        
                        </div><br>
                        <div class="row">
                            <div class="col-3 text-right" >Password :</div>
                            <div class="col-6" ><input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" ></div>
                            <div class="col-3 text-right" ></div><br><br>
                            <div class="col-3 text-right" >Password (Verify):</div>
                            <div class="col-6" ><input type="password" class="form-control" id="passwordVerify" name="passwordVerify" placeholder="Password (Verify)" value="" ></div>
                            <div class="col-3 text-right" ></div>
                            <div class="col-9 text-right"><button type="submit" class="btn btn-secondary" id="updateUserPass">Add User</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    
        <div class="container">
            <h4>List of users</h4>
                
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Display Name</th>
                        <th>User Name</th>
                        <th>User Type</th>
                        <th></th>           
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    $usersList = $connection->query("SELECT userID, userType, userName, displayName FROM user WHERE userName != 'root'");
                    $i = 1;
                    while ($row = $usersList->fetch_assoc()) {
                        echo '<tr><td>'.$i.'</td><td>'.$row['displayName'].'</td><td>'.$row['userName'].'</td><td>'.$row['userType'].'</td><td>
                        <button type="button" onclick="deleteUser('.$row['userID'].', 1)" class="btn btn-secondary" id="del'.$row['userID'].'">Delete</button>
                        </td></tr>';
                        $i++;
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>  


    <?php
            }     
    ?>

    </body>
    <script>
    function deleteUser(user, operation){        
        window.location.href = "./data.php?operation=deleteUser&userID="+user;
    }
    </script>
</html>