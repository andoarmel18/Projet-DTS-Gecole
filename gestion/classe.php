<?php 
$active = 'cls';
require_once 'lienAccueil.php';
$dtClasse = [];
$dataClasse = $databases->requette('SELECT * FROM classe');
$datNow = (int)date('Y');
$datHold = $datNow - 2;
$datFutur = $datNow + 2;
for($i = $datHold;$i<=$datFutur;$i++){
    $anneScol [$i-1 .'-'. $i] = $i-1 .'-'. $i;   
}
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Ajout des Classes</div>
</div>

<div style="margin-top: 1cm;" class="container">
    <div class="jumbotron">
        <form action="#" method="post">
        <?php
        $classe = new Input('classe' , 'text' , 'form-control' , '' , 'Votre classe');
        $classe->CreatInput('Enter votre classe' , 'Form-group');
        //===========================================================
        $f11 = $databases->requette('SELECT * FROM filiere');
        $fil = new Input('filiere' , 'text' , 'form-control' , '' , '');
        $fil->CreatSelect('Choisissez le filiere' , 'form-group' , 'idFiliere' , 'nomFiliere','' , $f11 , 'Choisissez le filiere');
        //===========================================================
        $years = $databases->requette('SELECT * FROM annee');
        $annee = new Input('annee','','form-control','','');
        $annee->CreatSelect('Selectionner l\'année','form-group','idAnnee','annee','',$years,'Année de la classe','');
        //===========================================================
        $profs = $databases->requette('SELECT * FROM prof');
        $resp = new Input('prof','','form-control','','');
        $resp->CreatSelect('Prof responsable','form-group','idProf','nomProf','prenomProf',$profs,'Prof responsable',0);
        //===========================================================
        $as = new Input('anneeScol', '','form-control','',);
        $as->creatSelectSimple('Années Scolaire','form-group',$anneScol,$datNow-1 .'-'.$datNow);
        //===========================================================
        $bouton = new Input('bt' , 'submit','btn btn-success','Enregister','');
        $bouton->CreatInput('','form-group');
        ?>
        </form>
    </div>
</div>
<?php

while($dataClasses = $dataClasse->fetch()){
    $dtClasse [] = $dataClasses['nomClasse'].$dataClasses['idFiliere'].$dataClasses['idAnnee'];
}
    if(!empty($_POST[$classe->getName()])){
        $donne = $_POST[$classe->getName()].$_POST[$fil->getName()].$_POST[$annee->getName()];
            if(!in_array($donne , $dtClasse) OR (int)compter('classe') == 0){
                $databases->ReqSecure('INSERT INTO classe (nomClasse, idFiliere, idAnnee, idProf, annee_scolaire) VALUES (:classe, :filiere, :annee, :prof, :asco)',
                [
                    ':classe' => $_POST[$classe->getName()],
                    ':filiere' => $_POST[$fil->getName()],
                    ':annee' => $_POST[$annee->getName()],
                    ':prof' => $_POST[$resp->getName()],
                    ':asco' => $_POST[$as->getName()]
                ]);
                    header('location: ../backend/Gpage.php?page=listeClasse&stat=1');
                }else{
                    
                    header('location: ../backend/Gpage.php?page=classe&stat=2');
                    
                }
    }
            