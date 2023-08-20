<?php
include_once 'lienEmploi.php';
$idClasse = (int)$_GET['id'];
$jour = $databases->requette('SELECT * FROM jour');
$heure = $databases->requette('SELECT * FROM heure');
$classe = $databases->getAllData('SELECT * FROM classe c 
    JOIN filiere f ON c.idFiliere=f.idFiliere 
    WHERE c.idClasse='.$idClasse);
?>
<div class="container">
    <div class="jumbotron"> 
        <div class="col-lg-6 offset-lg-3">
	        <div class="section_title text-center">
                Emploi Du Temps De La Classe
                <strong style="color: blue;"><?=$classe['nomClasse'].'('.$classe['nomFiliere'].')'?></strong> 
            </div>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <table class="table table-bordered"> 
                    <thead> 
                        <tr> 
                            <th></th>
                            <?php while($jours = $jour->fetch()) : ?> 
                            <th class="table-dark"><?=ucfirst($jours['jour'])?></th>
                            <?php endwhile ?> 
                        </tr> 
                    </thead> 
                    <tbody>                
                    <?php while($heures = $heure->fetch()) : $idHeure = $heures['idHeure'] ?> 
                        <tr> 
                            <th class="table-dark"><?=$heures['heure']?></th>
                            <?php
                            $day = $databases->requette('SELECT * FROM jour');
                            while($days = $day->fetch()) : 
                            $idJour = $days['idJour'];
                            $modEdt = $databases->getAllData('SELECT * FROM profmat pm
                                LEFT JOIN emploi_du_temp edt ON pm.idProfMat=edt.idProfMat
                                LEFT JOIN matiere m ON pm.idMatiere=m.idMatiere
                                LEFT JOIN prof p ON p.idProf=pm.idProf
                                WHERE idClasse='.$idClasse.' AND idHeure='.$idHeure.' AND idJour='.$idJour);
                                $name = $heures['heure'].':'.$days['jour'];
                            ?> 
                            <th>
                            <select class="form-control" name="<?=$name?>" id="">
                            <?php if($modEdt) :?>
                                <option value=<?=$modEdt['idProfMat']?>><?=$modEdt['nomMatiere'].' ('.$modEdt['nomProf'].' '.$modEdt['prenomProf'].')'?></option>
                            <?php else : ?>
                                <option value=""></option>
                            <?php endif?> 
                            <?php
                            $profMat = $databases->requette('SELECT * FROM profmat pm
                                LEFT JOIN matiere m ON pm.idMatiere=m.idMatiere
                                LEFT JOIN prof p ON p.idProf=pm.idProf
                                WHERE m.idFiliere='.$classe['idFiliere'].' AND m.idAnnee='.$classe['idAnnee'].' 
                                ORDER BY m.nomMatiere');
                                while($pm = $profMat->fetch()) : ?>
                                <option value=<?=$pm['idProfMat']?>><?=$pm['nomMatiere'].' ('.$pm['nomProf'].' '.$pm['prenomProf'].')'?></option>
                                <?php endwhile ?>
                                <option value="0"></option>
                            </select>
                            </th> 
                            
                            <?php endwhile ?>   
                        </tr> 
                    <?php endwhile ?>
                </tbody> 
            </table> 
            <input type="submit" class="btn btn-info" name="btn" value="Creer">
        </form> 
    </div>
</div>
</div>


<?php
    $heure = $databases->requette('SELECT * FROM heure');
    while($time = $heure->fetch()){
        $idHeure = $time['idHeure'];
        $jour = $databases->requette('SELECT * FROM jour');
            while($day = $jour->fetch()){
                $idJour = $day['idJour'];
                $name = $time['heure'].':'.$day['jour'];
                    if(!empty($_POST['btn'])){
                        $databases->ReqSecure('UPDATE emploi_du_temp SET idProfmat=:mat, idClasse=:classe, idHeure=:heure, idJour=:jour 
                        WHERE idClasse='.$idClasse.' AND idHeure='.$idHeure.' AND idJour='.$idJour,
                            [
                                ':mat' => $_POST[$name],
                                ':classe' => $idClasse,
                                ':heure' => $idHeure,
                                ':jour' => $idJour
                            ]);
                        $empld = $databases->getAllData('SELECT * FROM emploi_du_temp 
                        WHERE idClasse='.$idClasse.' AND idHeure='.$idHeure.' AND idJour='.$idJour);
                        $tabEmpl [] = $empld['idMatiere'].$empld['idClasse'].$empld['idHeure'].$empld['idJour'];
                        $input = $_POST[$name].$idClasse.$idHeure.$idJour;
                        if(!in_array($input,$tabEmpl)){
                            $databases->ReqSecure('INSERT INTO emploi_du_temp(idProfMat,idClasse,idHeure,idJour)
                            VALUES (:mat, :classe, :heure, :jour)',
                            [
                                ':mat' => $_POST[$name],
                                ':classe' => $idClasse,
                                ':heure' => $idHeure,
                                ':jour' => $idJour
                            ]);
                        }
                        $databases->requette('DELETE FROM emploi_du_temp WHERE idProfMat=0');
                        header('location: ../backend/Gpage.php?page=emploiClasse&stat=1&id='.$idClasse);
                    }
            }

    }
   
