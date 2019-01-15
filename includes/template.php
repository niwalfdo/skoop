<?php
    session_start();

    $headerLinks = '
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js" type="text/javascript"></script>    
    <script src="https://unpkg.com/sweetalert2@7.3.0/dist/sweetalert2.all.js"></script> 
    ';
    $jsScript = '<script src="./includes/app.js"></script>';
    $chosenScript = '<script src="./lib/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>';

    $navBar = '
    <nav class="navbar navbar-expand-sm bg-dark  navbar-dark">
        <ul class="navbar-nav mx-auto">
            <img src="./images/SKOOP_Logo_White_Trans.png" height="70">
        </ul>
    </nav>
    <nav class="navbar navbar-expand-sm bg-light  navbar-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{home}}">
                <a class="nav-link" href="./orders.php">Order History</a>
            </li>
            <li class="nav-item {{csv}}">
                <a class="nav-link" href="./csv.php">Upload CSV</a>
            </li>           
        </ul>
        <ul class="navbar-nav mx-auto">
            <li class="nav-item active">
                <a class="nav-link">Welcome '.@@$_SESSION['display_name'].'</a>            
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{account}}">
                <a class="nav-link" href="./account.php">My Account</a>            
            </li>
            <li class="nav-item {{logOut}}">
                <a class="nav-link" href="./index.php?operation=logOut">Log Out</a>            
            </li>
        </ul>
    </nav><br />';

?>