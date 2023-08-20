<?php 
$active = 'cls';
require_once 'lienAccueil.php';
$getClasse = (int)preg_quote($_GET['id']);
$dataClasse = $databases->getAllData('SELECT * FROM classe c
LEFT JOIN filiere f ON c.idFiliere=f.idFiliere
LEFT JOIN annee a ON a.idAnnee=c.idAnnee
LEFT JOIN prof p ON p.idProf=c.idProf
WHERE c.idClasse='.$getClasse);

    $dtClasse [] = $dataClasse['nomClasse'].$dataClasse['idFiliere'].$dataClasse['idAnnee'];
    $nomProf = $dataClasse['nomProf'].' '.$dataClasse['prenomProf'];
    $datNow = (int)date('Y');
    $datHold = $datNow - 2;
    $datFutur = $datNow + 2;
    for($i = $datHold;$i<=$datFutur;$i++){
        $anneScol [$i-1 .'-'. $i] = $i-1 .'-'. $i;   
    }
?>

<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Modification De la Classe</div>
</div>

<div style="margin-top: 1cm;" class="container">
    <div class="jumbotron">
        <form action="#" method="post">
        <?php
        $classe = new Input('classe' , 'text' , 'form-control' , $dataClasse['nomClasse'] , 'Votre classe');
        $classe->CreatInput('Enter votre classe' , 'Form-group');
        //===========================================================
        $f11 = $databases->requette('SELECT * FROM filiere');
        $fil = new Input('filiere' , 'text' , 'form-control' , '' , '');
        $fil->CreatSelect('Choisissez le filiere' , 'form-group' , 'idFiliere' , 'nomFiliere','' , $f11 ,$dataClasse['nomFiliere'],$dataClasse['idFiliere']);
        //===========================================================
        $years = $databases->requette('SELECT * FROM annee');
        $annee = new Input('annee','','form-control','','');
        $annee->CreatSelect('Selectionner l\'année','form-group','idAnnee','annee','',$years,$dataClasse['annee'],$dataClasse['idAnnee']);
        //===========================================================
        $profs = $databases->requette('SELECT * FROM prof');
        $resp = new Input('prof','','form-control','','');
        $resp->CreatSelect('Prof responsable','form-group','idProf','nomProf','prenomProf',$profs, $nomProf,$dataClasse['idProf']);
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

    if(!empty($_POST[$classe->getName()])){
        $donne = $_POST[$classe->getName()].$_POST[$fil->getName()].$_POST[$annee->getName()];
                $databases->ReqSecure('UPDATE classe SET  nomClasse=:classe, idFiliere=:filiere, idAnnee=:annee, idProf=:prof,annee_scolaire=:an WHERE idClasse='.$getClasse,
                [
                    ':classe' => $_POST[$classe->getName()],
                    ':filiere' => $_POST[$fil->getName()],
                    ':annee' => $_POST[$annee->getName()],
                    ':prof' => $_POST[$resp->getName()],
                    ':an' => $_POST[$as->getName()]
                ]);
                echo 
                    '<script>
                        alert("Modification réussie");
                    </script>';
                    header('location: ../backend/Gpage.php?page=infoClasse&id='.$getClasse);
                }
            
            