<?php
include_once 'lienEmploi.php';
$idClasse = (int)$_GET['id'];
$input = [];
$jour = $databases->requette('SELECT * FROM jour');
$heure = $databases->requette('SELECT * FROM heure');
$classe = $databases->getAllData('SELECT * FROM classe c 
    JOIN filiere f ON c.idFiliere=f.idFiliere 
    WHERE c.idClasse='.$idClasse);
$profOccupe = [];
$occup = $databases->requette('SELECT * FROM emploi_du_temp edt 
JOIN profmat pm ON edt.idProfMat=pm.idProfMat
JOIN prof p ON pm.idProf=p.idProf');
while($occups = $occup->fetch()){
$profOccupe [] = $occups['idProf'].'/'.$occups['idHeure'].'/'.$occups['idJour'];
}
ob_start();
?>
<div class="section_title text-center">
    <button id="profOccup" class="btn btn-success">Voir Les Prof Occupé</button>
</div><br>

<div id="op" class="container">
    <div class="alert alert-info">
        <?php
        $profMat = $databases->requette('SELECT * FROM profmat pm
            LEFT JOIN matiere m ON pm.idMatiere=m.idMatiere
            LEFT JOIN prof p ON p.idProf=pm.idProf
            WHERE m.idFiliere='.$classe['idFiliere'].' AND m.idAnnee='.$classe['idAnnee'].' 
            GROUP BY p.idProf ORDER BY m.nomMatiere');
        ?>
        <div class="d-flex flex-wrap col-md-12">
            <?php while($pm = $profMat->fetch()) : $idProf = $pm['idProf'] ?>
                <div class=" border-bottom border-right m-1 p-1 border-dark" style="width: 8cm;">
                    <strong><i><?=strtoupper($pm['nomProf']).' '.ucfirst($pm['prenomProf']) ?></i></strong>
                    <ul>
                    <?php
                        $emploiProf = $databases->requette('SELECT * FROM emploi_du_temp edt 
                            JOIN profmat pm ON pm.idProfMat=edt.idProfMat
                            JOIN prof p ON pm.idProf=p.idProf
                            JOIN classe c ON c.idClasse=edt.idClasse
                            JOIN filiere f ON c.idFiliere=f.idFiliere
                            JOIN heure h ON h.idHeure=edt.idHeure
                            JOIN jour j ON j.idJour=edt.idJour
                            WHERE p.idProf='.$idProf);
                            while($emploiProfs = $emploiProf->fetch()) :
                    ?>
                                 <li class="fa fa-dot-circle-o" style="margin-left: 0.5cm;">
                                    <?=$emploiProfs['jour'].' le '.$emploiProfs['heure'].'heures : '.$emploiProfs['nomClasse'].'('.$emploiProfs['nomFiliere'].')'?>
                                 </li>
                            <?php endwhile?>
                    </ul>
                </div>
            <?php endwhile?>
        </div>
    </div>
</div>
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
                            $name = $heures['heure'].':'.$days['jour'];
                            ?> 
                            <th>
                            <select class="form-control" name="<?=$name?>" id="">
                            <option value=""></option>
                            <?php
                            $profMat = $databases->requette('SELECT * FROM profmat pm
                                LEFT JOIN matiere m ON pm.idMatiere=m.idMatiere
                                LEFT JOIN prof p ON p.idProf=pm.idProf
                                WHERE m.idFiliere='.$classe['idFiliere'].' AND m.idAnnee='.$classe['idAnnee'].' 
                                ORDER BY m.nomMatiere');
                            while($pm = $profMat->fetch()) :
                                $occupation = $pm['idProf'].'/'.$idHeure.'/'.$idJour;
                            ?>
                                <?php if(!in_array($occupation,$profOccupe)) : ?>
                                    <option value="<?=$pm['idProfMat']?>"><?=$pm['nomMatiere'].' ('.$pm['nomProf'].' '.$pm['prenomProf'].')'?></option>
                                <?php endif ?>
                            <?php endwhile ?>
                            </select>
                            </th>  
                            <?php
                            if(!empty($_POST[$name])){
                                $input[] = $_POST[$name].$idClasse.$idHeure.$idJour;
                            }
                            endwhile ?>   
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
$content = ob_get_clean();
$emploiDuTemp = $databases->requette('SELECT * FROM emploi_du_temp');
while ($emploiDuTemps = $emploiDuTemp->fetch()) {
   $notDouble = $emploiDuTemps['idProfMat'].$emploiDuTemps['idClasse'].$emploiDuTemps['idHeure'].$emploiDuTemps['idJour'];
        if(in_array($notDouble,$input)){
            echo '<div class="alert alert-danger">Vous Avez Déjat Inseret le meme Donnée! Veuillez Modifier ou Supprimer Pour Ajouter Des Nouveaux</div>';
            echo $content;
            die();
        }
}

    $heure = $databases->requette('SELECT * FROM heure');
    while($time = $heure->fetch()){
        $idHeure = $time['idHeure'];
        $jour = $databases->requette('SELECT * FROM jour');
            while($day = $jour->fetch()){
                $idJour = $day['idJour'];
                $name = $time['heure'].':'.$day['jour'];
                    if(!empty($_POST['btn'])){
                        $databases->ReqSecure('INSERT INTO emploi_du_temp(idProfMat,idClasse,idHeure,idJour)
                        VALUES (:pm, :classe, :heure, :jour)',
                            [
                                ':pm' => $_POST[$name],
                                ':classe' => $idClasse,
                                ':heure' => $idHeure,
                                ':jour' => $idJour
                            ]);
                        header('location: ../backend/Gpage.php?page=emploiClasse&stat=1&id='.$idClasse);
                    }
            }

    }
    echo $content;
   

