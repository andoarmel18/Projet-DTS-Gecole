<?php
$idClasse = (int)preg_quote($_GET['id']);
$semestre = (int)preg_quote($_GET['semestre']);
$note = $databases->requette('SELECT * FROM note WHERE idClasse='.$idClasse);
$infoClasse = $databases->getAllData('SELECT * FROM classe c 
    JOIN filiere f ON f.idFiliere=c.idFiliere
    WHERE idClasse='.$idClasse);
$idFiliere = $infoClasse['idFiliere'];
$idAnnee = $infoClasse['idAnnee'];
$etudiant = $databases->requette('SELECT * FROM etudiant WHERE idClasse='.$idClasse.' ORDER BY matricule');

?>
<div style="margin-top: 2.5cm;" class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">
        BULLETIN DE NOTE DE LA CLASSE 
        <strong><?=$infoClasse['nomClasse'].'('.$infoClasse['nomFiliere'].')'?></strong>
    </div>
</div>
    <div class="container">
        <?php $i=1; while($etudiants = $etudiant->fetch()):?>
            <?php if($i==1) :?>
                <div class="card">
                    <?php require 'modelBulletin.php'?>
                </div><br>
                <?php else :?>
                <div class="card">
                    <?php require 'modelBulletin.php'?>
                </div><br>
            <?php endif ;$i++?>
        <?php endwhile ?>
    </div>
    
    
</div><br>

