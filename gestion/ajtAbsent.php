<?php
$active = 3;
include_once 'lienPointage.php';
$idClasse = (int)preg_quote($_GET['id']);
$classe = $databases->getAllData('SELECT * FROM classe c
    JOIN filiere f ON f.idFiliere=c.idFiliere
    WHERE idClasse='.$idClasse);
$jour = (int)date('N');
$in_absent = [];
$eleve = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$idClasse);
$name = null;
$nom = null;
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">
    Ajout Des Absent De Classe De <?=$classe['nomClasse'].' ('.$classe['nomFiliere'].')'?>
    </div>
</div>
<div class="container">
    <div class="jumbotron">
        <form action="" method="post">
        <div class="card table-responsive">
            <table class="table table-bordered"> 
                <thead> 
                    <tr>
                        <th></th>
                        <?php 
                            $mat = $databases->requette('SELECT * FROM emploi_du_temp edt
                                JOIN profMat pf ON edt.idProfMat=pf.idProfMat
                                JOIN matiere m ON m.idMatiere=pf.idMatiere
                                WHERE idClasse='.$idClasse.' AND idJour='.$jour.'
                                GROUP BY m.idMatiere');
                    while($mats = $mat->fetch()) : ?>
                        <th class="table-dark"><?=$mats['nomMatiere']?></th> 
                    <?php endwhile?>
                    </tr> 
                </thead> 
                <tbody> 
                    <?php
                    while($eleves = $eleve->fetch()) :
                    ?>
                    <tr> 
                        <th class="table-dark"><?=$eleves['matricule']?></th> 
                        <?php 
                            $mat = $databases->requette('SELECT * FROM emploi_du_temp edt
                            JOIN profMat pf ON edt.idProfMat=pf.idProfMat
                            JOIN matiere m ON m.idMatiere=pf.idMatiere
                            WHERE idClasse='.$idClasse.' AND idJour='.$jour.'
                            GROUP BY pf.idMatiere');
                        while($mats = $mat->fetch()) :
                            $name = $mats['idMatiere'].':'.$eleves['matricule'];
                        ?>
                        <th>
                            <input type="checkbox" name="<?=$name?>" value="<?=$mats['idMatiere']?>" class="form-control">
                        </th> 
                        <?php endwhile?>
                    </tr>
                    <?php endwhile?> 
                </tbody> 
            </table><br>
            <button class="btn btn-info" name="btn" value="btn" type="submit">Enregister</button> 
        </div>
        </form>
    </div>
</div>
<?php
$absent = $databases->requette('SELECT * FROM absence');
while ($absents = $absent->fetch()) {
       $in_absent [] = $absents['matricule'].$absents['idMatiere'].$absents['dateAbs'];
}
    $eleve = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$idClasse);
    while($eleves = $eleve->fetch()){
        $mat = $databases->requette('SELECT * FROM emploi_du_temp edt
        JOIN profMat pf ON edt.idProfMat=pf.idProfMat
        JOIN matiere m ON m.idMatiere=pf.idMatiere
        WHERE idClasse='.$idClasse.' AND idJour='.$jour.'
        GROUP BY pf.idMatiere');
            while($mats = $mat->fetch()){
                $name = $mats['idMatiere'].':'.$eleves['matricule'];
                if(isset($_POST['btn'])){
                    if(empty($_POST[$name])){
                        $_POST[$name] = 0;
                    }
                    $in_input = $eleves['matricule'].$_POST[$name].date('Y-m-d');
                        if(!in_array($in_input,$in_absent) OR (int)compter('absence') < 1){
                            $databases->ReqSecure('INSERT INTO absence(matricule,idMatiere,dateAbs)
                                VALUES (:matricule,:matiere,:date)',
                                [
                                    ':matricule' => $eleves['matricule'],
                                    ':matiere' => $_POST[$name],
                                    ':date' => date('Y-m-d')
                                ]);
                                header('location: ../backend/Gpage.php?page=ListeAbsence');
                        }
                    $databases->requette('DELETE FROM absence WHERE idMatiere=0');
                    }

            }

    }
    
