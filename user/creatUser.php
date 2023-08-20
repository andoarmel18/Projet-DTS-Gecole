<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Creer Admin</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../login/vendor/bootstrap/css/bootstrap.min.css">
	</head>
<body>
    <div style="margin-top:1CM ;" class="container">
        <div class="jumbotron">
    <form action="" method="Post" enctype="multipart/form-data">
        <div class="form-group row"> 
            <label class="col-md-2 col-form-label">Photo</label> 
                <input type="file" name="sary" class="col-md-10 form-control mb-2"> 
        </div> 
        <div class="form-group row"> 
            <label class="col-form-label col-md-2" >Nom Institut</label> 
                <input type="text" name="nom" class="form-control col-md-4"  placeholder="Nom Institut" required> 
            <label class="col-form-label col-md-2">Nom D'utilisateur</label> 
                <input type="text" name="pseudo" class="form-control col-md-4" placeholder="pseudo" required> 
        </div> 
        <div class="form-group row"> 
            <label class="col-form-label col-md-2" >Mot De Passe</label> 
                <input type="text" name="mdp" class="form-control col-md-4" id="inputMail" placeholder="Votre Mot De Passe" required> 
            <label class="col-form-label col-md-2">Date de Creation</label> 
                <input type="date" name="dtc" class="form-control col-md-4" placeholder="date de creation" required> 
        </div>
        <div class="form-group row"> 
            <label class="col-form-label col-md-2" >Adresse</label> 
                <input type="text" name="adresse" class="form-control col-md-4" id="inputMail" placeholder="adresse" required> 
            <label class="col-form-label col-md-2">Numéro</label> 
                <input type="text" name="num" class="form-control col-md-4" placeholder="numéro téléphonique" required> 
        </div>  
        <div class="form-group row"> 
            <label class="col-form-label col-md-2" >Mail</label> 
                <input type="mail" name="mail" class="form-control col-md-4" id="inputMail" placeholder="adresse mail" required> 
            <label class="col-form-label col-md-2">Lien</label> 
                <input type="text" name="lien" class="form-control col-md-4" placeholder="site internet" required> 
        </div> 
        <div class="form-group row"> 
            <label class="col-form-label col-md-2" >Slogan</label> 
                <textarea name="slogan" id="" cols="30" rows="10" class="form-control col-md-4"></textarea>
        </div>
   <button type="submit" class="btn btn-lg btn-primary">Creer</button> 
</form>   
    </div>
</div>

    </body>
</html>


<?php
require_once '../backend/class/bdd.php';
require_once '../backend/fonction/fonction.php';

    if(!empty($_FILES['sary']) AND $_FILES['sary']['error'] == 0){
        $file_info = pathinfo($_FILES['sary']['name']);
        $extension = $file_info['extension'];
        $extension_autorised = ['jpeg' , 'png' ,'jpg'];
        $name = basename($_FILES['sary']['name']);

            if(in_array($extension , $extension_autorised)){
                move_uploaded_file($_FILES['sary']['tmp_name'],'../photo/'.$name);
    
                if(!empty($_POST['nom']) AND !empty($_POST['pseudo']) AND !empty($_POST['mdp']) AND !empty($_POST['dtc']) AND !empty($_POST['adresse']) AND !empty($_POST['num']) AND !empty($_POST['mail']) AND !empty($_POST['lien']) AND !empty($_POST['slogan'])){
                    $databases = new Database();
                    $databases->ReqSecure('INSERT INTO admin (photo,pseudo,nom,slogan,mdp,date_creation,adresse,numero,lien,mail) 
                        VALUES(:photo,:pseudo,:nom,:slogan,:mdp,:date,:adresse,:num,:lien,:mail)',
                        [
                            ':photo' => $name,
                            ':pseudo' => $_POST['pseudo'],
                            'nom' => $_POST['nom'],
                            'slogan' => $_POST['slogan'],
                            ':mdp' => $_POST['mdp'],
                            ':date' => $_POST['dtc'],
                            ':adresse' => $_POST['adresse'],
                            ':num' => $_POST['num'],
                            ':lien' => $_POST['lien'],
                            ':mail' => $_POST['mail']
                        ]);
                    header('location: ../index.php?success=2');
                }
            }else{
                echo 'erreur extension';
            }   
    }else{
        echo 'erreur base';
    }


