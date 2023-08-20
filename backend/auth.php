<?php
include 'connect.php';
try{
    $admins =  $serveur->query('SELECT * FROM admin');
    $admin = $admins->fetch();
    if(isset($_POST['nad'] , $_POST['pass']) AND $_POST['nad'] == $admin['pseudo'] AND $_POST['pass'] == $admin['mdp']){
    session_start();
    $_SESSION['role'] = 'admin';
    header('location: Gpage.php');
    }
    else{
        header('location: ../index.php');
    }

}
catch(PDOException $pe){
    echo $pe->getMessage();
}