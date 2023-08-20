<?php
$active = 4;
include_once 'lienProf.php';
$matiere = $databases->requette('SELECT * FROM matiere m JOIN filiere f 
    ON m.idFiliere=f.idFiliere');
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Les Action Des Prof</div>
</div>
<div class="container">
    <div class="card">
        <div class="alert alert-info">
        <div class="d-flex flex-wrap ">
        <?php 
            $prof = $databases->requette('SELECT * FROM prof');
            while($profs = $prof->fetch()) : 
            $idProf = $profs['idProf'];
        ?>
                <div class="col-md-2 border-bottom border-right m-1 p-1 border-dark">
                <strong >
                    <i class="fa fa-mortar-board ">
                        <?=$profs['nomProf'].' '.$profs['prenomProf']?>
                        <a href="../backend/Gpage.php?page=ajtProfMat&id=<?=$idProf?>"><span class="fa fa-plus-square"></span></a>
                    </i>
                </strong><br>
                    <?php 
                        $actProf = $databases->requette('SELECT * FROM profmat pf 
                            RIGHT JOIN prof p ON p.idProf=pf.idProf
                            JOIN matiere m ON m.idMatiere=pf.idMatiere WHERE pf.idProf='.$idProf);
                            while($actprofs = $actProf->fetch()) : ?>
                                <p >
                                    <span class="fa fa-circle"> <?=$actprofs['nomMatiere']?></span> 
                                    <a href="../backend/Gpage.php?page=delActionProf&id=<?=$actprofs['idProfMat']?>"><span style="color: red;" class="fa fa-mail-reply"></span></a>
                                </p>
                              
                            <?php endwhile ?>  
                </div>
            <?php endwhile ?>
        </div>   
        </div>
    </div>
</div>



