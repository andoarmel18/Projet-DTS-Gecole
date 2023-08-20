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
        <div class="card table-responsive">
        <table style="border: solid black 3px;" class="table table-bordered"> 
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
                    $empld = $databases->requette('SELECT * FROM emploi_du_temp edt
                        JOIN classe c ON c.idClasse=edt.idClasse
                        JOIN heure h ON h.idHeure=edt.idHeure
                        JOIN jour j ON j.idJour=edt.idJour
                        JOIN profmat pm ON edt.idProfMat=pm.idProfMat
                        LEFT JOIN matiere m ON m.idMatiere=pm.idMatiere
                        LEFT JOIN prof p ON p.idProf=pm.idProf
                        WHERE edt.idClasse='.$idClasse.' AND edt.idHeure='.$idHeure.' AND edt.idJour='.$idJour);
                     
                        $emplds = $empld->fetch();
                            $valid = $databases->Chearch('SELECT * FROM emploi_du_temp edt
                            JOIN classe c ON c.idClasse=edt.idClasse
                            JOIN heure h ON h.idHeure=edt.idHeure
                            JOIN jour j ON j.idJour=edt.idJour
                            JOIN profmat pm ON edt.idProfMat=pm.idProfMat
                            LEFT JOIN matiere m ON m.idMatiere=pm.idMatiere
                            LEFT JOIN prof p ON p.idProf=pm.idProf
                            WHERE edt.idClasse='.$idClasse.' AND edt.idHeure='.$idHeure.' AND edt.idJour='.$idJour);
                        ?>
                            <?php if($valid == false) : ?>
                                <th class="table-info"></th>
                                <?php else : ?> 
                                    <th style="color: black;"><?=$emplds['nomMatiere'].'('.$emplds['nomProf'].' '.$emplds['prenomProf'].')'?></th>
                            <?php endif ?> 
                           
                         
                       
                    <?php endwhile ?>   
                </tr> 
                <?php endwhile ?>
            </tbody> 
        </table>
        <?php
        $stat = $databases->Chearch('SELECT * FROM emploi_du_temp WHERE idClasse='.$idClasse);
        if($stat) :
        ?>
        <a class="btn btn-info" href="../backend/Gpage.php?page=modEmploi&id=<?=$idClasse?>">Modifier</a> <br>
        <a class="btn btn-danger" href="../backend/Gpage.php?page=confDel&id=<?=$idClasse?>&action=delEmp">Supprimer</a>
        <?php endif?>
        </div>
    </div>
</div>