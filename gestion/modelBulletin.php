<?php
$institut = $databases->getAllData('SELECT * FROM admin');
$noteElev = [];
?>
<div class="container">
    <div class="section_title text-center">
        <img style="width: 100px; height: 100px" src="<?='../photo/'.$institut['photo']?>" class="img-fluid rounded-circle">
        <p><?=$institut['nomAdmin']?></p>
        <p>info</p>
        <p>slogant</p>
        <p><strong>DIRECTION DES ETUDE</strong></p>
        <p><STRONG>
            <?php if($semestre == 1) :?>
                PREMIERE SEMESTRE
            <?php else : ?>
                DEUXIEME SEMESTRE
            <?php endif?>
        </STRONG></p>
        <p><strong><?=$infoClasse['nomClasse'].'('.$infoClasse['nomFiliere'].')'?></strong></p>
    </div>
    <div style="margin-left: 1cm;">
        <strong>NOM ET PRENOM : <span><?=strtoupper($etudiants['nom']).' '.ucfirst($etudiants['prenom'])?></span></strong><br>
        <strong>MATRICULE : <span><?=$etudiants['matricule']?></span></strong><br>
        <strong>Année académique : <span>taona</span></strong><br>
    </div>
    

    <div class="table-responsive">
        <table class="table table-bordered"> 
            <thead> 
                <tr> 
                    <th><b>Matières</b></th> 
                    <th><b>Notes/20</b></th> 
                    <th><b>Coef</b></th> 
                    <th><b>note/Coef</b></th> 
                </tr> 
            </thead> 
            <tbody> 
                <?php
                $matiere = $databases->requette('SELECT * FROM matiere 
                WHERE idFiliere='.$idFiliere.' AND idAnnee='.$idAnnee.' AND semestre='.$semestre);
                 while($matieres = $matiere->fetch()) :?>
                <tr> 
                    <th><?=$matieres['nomMatiere']?></th>
                    <?php
                    $noteElev = $databases->getAllData('SELECT * FROM note n
                        JOIN matiere m ON n.idMatiere=m.idMatiere
                        WHERE idClasse='.$idClasse.' 
                        AND matricule='.$etudiants['matricule'].' 
                        AND n.idMatiere='.$matieres['idMatiere'].'
                        AND n.semestre='.$semestre);
                    ?> 
                    <th><?=$noteElev['note']?></th> 
                    <th><?=$noteElev['coeuf']?></th> 
                   
                </tr> 
                <?php endwhile?>
            </tbody> 
        </table>
    </div>
</div>
