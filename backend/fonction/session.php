<?php
function session($return){
    session_start();
    if(!empty($_SESSION['role'])){
        return include $return;
    }
        return header('location: index.php');
};