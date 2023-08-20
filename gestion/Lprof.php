<?php
$active = 5;
include_once 'lienProf.php';
?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 0.5cm;" class="section_title text-center">Liste Des Profs</div>
</div>
<div class="container">
    
        <div class="card-body">
        <div class="alert alert-light">
            <div class="d-flex flex-wrap col-md-12">
            <?php 
            $prof = $databases->requette('SELECT * FROM prof');
            while($profs = $prof->fetch()) : ?>
                <div class=" border-bottom border-right m-1 p-1 border-dark" style="width: 8cm;">
                    <strong style="color:black;">
                        <i>
                            <span class="fa fa-mortar-board "></span><?=$profs['nomProf']?>  <?=$profs['prenomProf']?>
                        </i>
                        <a href="../backend/Gpage.php?page=infoProf&id=<?=$profs['idProf']?>" style="color: purple;"><span class="fa fa-info-circle"></span></a>
                        <a href="../backend/Gpage.php?page=modProf&id=<?=$profs['idProf']?>"><span class="fa fa-pencil-square"></span></a>
                        <a href="../backend/Gpage.php?page=confDel&id=<?=$profs['idProf']?>&action=delProf" style="color: red;"><span class="fa fa-trash"></span></a>
                    </strong><br>
                        <p ><span class="fa fa-user"> Sexe : </span><?=$profs['sexe']?></p>
                        <p ><span class="fa fa-phone"> Numéro : </span><?=$profs['numero']?></p>
                        <p ><span class="fa fa-envelope-o"> Mail : </span><?=$profs['mail']?></p>
                </div>
            <?php endwhile ?>
            </div>   
        
        </div>
    </div>
</div>