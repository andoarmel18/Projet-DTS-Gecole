<!DOCTYPE html>
	<html lang="en">
	    <head>
		    <title>Creer Admin</title>
		    <meta charset="UTF-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1">
		    <link rel="stylesheet" type="text/css" href="../login/vendor/bootstrap/css/bootstrap.min.css">
	    </head>
    <body>

    <div class="container">
    <div class="jumbotron">
        <form action="" method="POST">
        <?php
        include_once '../backend/class/Input.php';
        $mdp = new Input('mdp','date','form-control','','');
        $mdp->CreatInput('Enter La Date De création De Votre Institut:','form-group');
        $bt = new Input('btn','submit','btn btn-info','Valider','');
        $bt->CreatInput('','Form-group');
       ?>
    </form>
    </div>
</div>
    </body>
</html>

<?php
include_once '../backend/class/bdd.php';
$databases = new Database();
$dateC = $databases->getAllData('SELECT date_creation FROM admin');
if(!empty($_POST[$mdp->getName()])){
    if($_POST[$mdp->getName()] === $dateC['date_creation']){
        header('location: mdpchange.php');
    }
    else{
        echo '<div class="alert alert-danger">
                <p>Date Incorecte</p>
            </div>';
    }
}
