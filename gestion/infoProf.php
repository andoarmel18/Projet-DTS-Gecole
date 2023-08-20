<?php
include_once 'lienProf.php';
$idProf = (int)preg_quote($_GET['id']);
$nomProf = $databases->getAllData('SELECT * FROM prof WHERE idProf='.$idProf);
if($nomProf['sexe'] === "Masculin"){
    $sexe = 'MR';
}
if ($nomProf['sexe'] === "Feminin") {
    $sexe = 'MDM';
}
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">
        EMPLOI DU TEMP DE <?=$sexe?> 
        <strong style="font-family: 007 GoldenEye;"><?=strtoupper($nomProf['nomProf']).' '.ucfirst($nomProf['prenomProf']) ?> </strong>
    </div>
</div>
<div class="container">
    <div class="jumbotron">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead >
                    <tr>
                        <th class="table-light"></th>
                        <?php
                        $jour = $databases->requette('SELECT * FROM jour ORDER BY idJour');
                        while($jours = $jour->fetch()) :
                        ?>
                        <th class="table-dark"><?=$jours['jour']?></th>
                        <?php endwhile?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $heure = $databases->requette('SELECT * FROM heure ORDER BY idHeure');
                    while($heures = $heure->fetch()) :
                        $idHeure = $heures['idHeure'];
                    ?>
                    <tr>
                        <th class="table-dark"><?=$heures['heure']?></th>
                        <?php
                        $jour = $databases->requette('SELECT * FROM jour ORDER BY idJour');
                        while($jours = $jour->fetch()) :
                            $idJour = $jours['idJour'];
                        $infoProf = $databases->requette('SELECT * FROM emploi_du_temp edt
                        JOIN classe c ON c.idClasse=edt.idClasse
                        JOIN filiere f ON f.idFiliere=c.idFiliere
                        JOIN profmat pm ON pm.idProfMat=edt.idProfMat
                        JOIN prof p ON pm.idProf=p.idProf
                        WHERE p.idProf='.$idProf.' AND idHeure='.$idHeure.' AND idJour='.$idJour);
                   
                        $stat = $databases->Chearch('SELECT * FROM emploi_du_temp edt
                        JOIN classe c ON c.idClasse=edt.idClasse
                        JOIN filiere f ON f.idFiliere=c.idFiliere
                        JOIN profmat pm ON pm.idProfMat=edt.idProfMat
                        JOIN prof p ON pm.idProf=p.idProf
                        WHERE p.idProf='.$idProf.' AND idHeure='.$idHeure.' AND idJour='.$idJour);
                        $infoProfs = $infoProf->fetch();
                        if($stat):
                        ?>
                        <th class="table-light"><?=$infoProfs['nomClasse'].'('.$infoProfs['nomFiliere'].')'?></th>
                        <?php else :?>
                            <th class="table-info"></th>
                        <?php endif?>
                        <?php endwhile?>
                    </tr>
                    <?php endwhile?>
                </tbody>

            </table>

        </div>
    </div>
</div>