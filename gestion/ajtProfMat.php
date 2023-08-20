<?php
include_once 'lienProf.php';
$nameTotal = null;
$idProf = (int)preg_quote($_GET['id']);
$prof = $databases->getAllData('SELECT * FROM prof WHERE idProf='.$idProf);
$filiere = $databases->requette('SELECT * FROM filiere');
?>
<div class="container">
    <div class="jumbotron">
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">
                <?=strtoupper($prof['nomProf']).' '.ucfirst($prof['prenomProf'])?>
            </div>
        </div>
        <div>
            <form action="" method="Post">
                <div class="d-flex bg-dark flex-wrap">
                    <?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere']?> 
                        <div class="col-md-4 border-left">
                              <h3><?=$filieres['nomFiliere']?></h3>
                              <?php 
                                $matiere = $databases->requette('SELECT * FROM matiere m  
                                JOIN annee a ON a.idAnnee=m.idAnnee WHERE idFiliere='.$idFiliere.'
                                ORDER BY nomMatiere');
                              while($matieres = $matiere->fetch()) : $name = $matieres['idMatiere']?> 
                                <label> 
                                    <input type="checkbox" name="<?=$name?>" value="<?=$matieres['idMatiere']?>">
                                    <?=$matieres['nomMatiere'].' ('.$matieres['annee'].')'?> 
                                </label><br>
                    <?php if(isset($_POST[$name])){
                        $nameTotal[] = $_POST[$name];
                    }
                ?>
                <?php  endwhile ?>
                        </div>
                    <?php  endwhile ?>

               
                </div><br>
                    <input type="submit" name="btn" class="btn btn-info" value="Confirmer">
            </form>
        </div>
        
    </div>
</div>
<?php
if(!empty($_POST['btn'])){
    foreach($nameTotal as $idMatiere){
        $databases->ReqSecure('INSERT INTO profmat (idProf,idMatiere) VALUES (:idProf, :idMatiere)',[
            ':idProf' => $idProf,
            'idMatiere' => $idMatiere
        ]);
        header('location: ../backend/Gpage.php?page=action&stat=1');
    }
}
