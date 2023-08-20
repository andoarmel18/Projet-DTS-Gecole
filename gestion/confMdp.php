<?php
ob_start();
$databases->requette('DELETE FROM conmdp');
?>
<div class="col-lg-6 offset-lg-3" style="margin-top: 2.5cm;">
    <div style="margin-top: 0.5cm; color:red;" class="section_title text-center">Confirmation De Votre Identité</div>
</div>
<div class="container">
    <div class="jumbotron">
        <form action="" method="POST">
        <?php
        $mdp = new Input('mdp','password','form-control','','');
        $mdp->CreatInput('Entrer Le Mot de Passe :','form-group');
        $bt = new Input('btn','submit','btn btn-info','Valider','');
        $bt->CreatInput('','Form-group');
       ?>
    </form>
    </div>
</div>
<?php
$content = ob_get_clean();
if(isset($_GET['id'])){
    $getId = (int)preg_quote($_GET['id']);
    if(!empty($_POST[$mdp->getName()])){
        $databases->ReqSecure("INSERT INTO conmdp (mdpconfirm) VALUES (:mdp)",[
            ":mdp" => $_POST[$mdp->getName()]
    ]);
    $lastId = $databases->getAllData('SELECT MAX(id) AS id FROM conmdp');  
    $idcrypt = password_hash($lastId['id'], PASSWORD_DEFAULT);
    if($_GET['action'] === 'modifier'){
        header('location: Gpage.php?page=modPay&idmdp='.$idcrypt.'&id='.$getId);
    }
    if($_GET['action'] === 'supprimer'){
        header('location: Gpage.php?page=delPayement&idmdp='.$lastId['id'].'&id='.$getId);
    }
    if($_GET['action'] === 'payer'){
        header('location: Gpage.php?page=payement&idmdp='.$lastId['id'].'&id='.$getId);
    }
    if($_GET['action'] === 'note'){
        header('location: Gpage.php?page=note&idmdp='.$lastId['id'].'&id='.$getId);
    }
}
echo $content;
}




        
        




