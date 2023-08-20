
<div style="margin-top:1CM ;" class="container">
    <div class="jumbotron">
        <div class="col-lg-6 offset-lg-3">
	        <div style="margin-top: 0.5cm;" class="section_title text-center">MODOFICATION</div>
        </div>
        <form action="" method="POST">
            <div class="form-group row"> 
                <label class="col-form-label col-md-2" for="inputNom">Nom Institut</label> 
                    <input type="text" value="<?=$admin['nom']?>" name="nom" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2" for="inputPrenom">Pseudo</label> 
                    <input type="text" value="<?=$admin['pseudo']?>" name="pseudo" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2">Adresse</label> 
                    <input type="text" value="<?=$admin['adresse']?>" name="adresse" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2">Numéro</label> 
                    <input type="text" value="<?=$admin['numero']?>" name="num" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2">Mail</label> 
                    <input type="mail" value="<?=$admin['mail']?>" name="mail" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2">Web</label> 
                    <input type="text" value="<?=$admin['lien']?>" name="lien" class="form-control col-md-4" > 
                <label class="col-form-label col-md-2">Slogan</label> 
                    <textarea name="slogan" id="" cols="30" class="form-control col-md-4" rows="10"><?=$admin['slogan']?></textarea>
            </div> 
            <center>
                <button type="submit" class="btn btn-lg btn-primary">Modifier</button> 
            </center>
        </form> 
    </div>     
</div>
<?php
$idAmdin = (int)preg_quote($_GET['id']);
$admin = $databases->getAllData('SELECT * FROM admin');
if(!empty($_POST['nom']) AND !empty($_POST['pseudo'])  AND !empty($_POST['adresse']) AND !empty($_POST['num']) AND !empty($_POST['mail']) AND !empty($_POST['lien']) AND !empty($_POST['slogan'])){
    $databases->reqSecure('UPDATE admin SET nom=:nom,pseudo=:pseudo,slogan=:slogan,numero=:num,mail=:mail,lien=:lien,adresse=:adresse',[
        ':nom' => $_POST['nom'],
        ':pseudo' => $_POST['pseudo'],
        ':slogan' => $_POST['slogan'],
        ':num' => $_POST['num'],
        ':mail' => $_POST['mail'],
        ':lien' => $_POST['lien'],
        ':adresse' => $_POST['adresse']
    ]);
    header('location: ../backend/Gpage.php?page=admin&stat=1');
}

