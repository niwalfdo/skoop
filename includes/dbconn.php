<?php    
    $servername = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'scoop';
      
    $connection = new mysqli($servername, $username, $password, $database);
    
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }else{
        $connection->client_info;               
    }
    
?>