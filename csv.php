<?php
include_once './includes/template.php';
include_once './includes/dbconn.php';

$notLogged = true;
if(@$_SESSION['loggedIn']){$notLogged = false;}
if($notLogged){header('Location: index.php?operation=logOut');}


echo'
<!DOCTYPE html>
<html>
    <head>
        '.$headerLinks.'
    </head>
    <body>';

echo str_replace('{{csv}}', 'active', $navBar);