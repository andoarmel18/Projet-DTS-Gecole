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
        $mdp = new Input('mdp','texte','form-control','','');
        $mdp->CreatInput('Enter Le Nouveau Mot De Passe:','form-group');
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
if(!empty($_POST[$mdp->getName()])){
    $stat = $databases->ReqSecure('UPDATE admin SET mdp=:mdp',[
        ':mdp' => $_POST[$mdp->getName()]
    ]);

    if($stat == false){
        echo '<div class="alert alert-danger">
                 <p>Echec</p>
            </div>';
    }else{
        session_start();
        session_destroy();
        header('location: ../index.php?success=1');
    }
}

