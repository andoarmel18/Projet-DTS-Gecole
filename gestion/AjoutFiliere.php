<?php
include_once 'lienProf.php';
?>
<div class="container">
    <div class="jumbotron">
        <form action="" method="post">
        <?php
        $filiere = new Input('fil','texte','form-control','','');
        $filiere->CreatInput('Enter La Filiere : ','form-group');
        $btn = new Input('btn','submit','btn btn-info','Valider','');
        $btn->CreatInput('','form-group');
        ?>
        </form>
    </div>
</div>
<?php
$fil = $databases->requette('SELECT * FROM filiere');
while ($fils = $fil->fetch()) {
   $in_fil [] = $fils['nomFiliere'];
}
if(!empty($_POST[$filiere->getName()])){
    $in_input = $_POST[$filiere->getName()];
    if(!in_array($in_input,$in_fil)){
        $databases->ReqSecure('INSERT INTO filiere (nomFiliere) VALUES (:fil)',
        [
            ':fil' => $_POST[$filiere->getName()]
        ]);
        header('location: ../backend/Gpage.php?page=LprofMat&stat=1');
    }
}
