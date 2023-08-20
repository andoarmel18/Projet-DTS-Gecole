<?php
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY nomFiliere DESC');
$active = 2;
include_once 'lienEmploi.php';
?>
<div class="col-lg-6 offset-lg-3">
	<div  class="section_title text-center">Les Classe Existant</div>
</div>
<div class="container">
	<div class="jumbotron">		
		<br>
		<div  class="d-flex  flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
            <?php
            $classe = $databases->requette('SELECT * FROM classe WHERE idFiliere = '.$idFiliere.' ORDER BY nomClasse');
			while($classes = $classe->fetch()) : 
                $idClasse = $classes['idClasse'];
                $valid = $databases->Chearch('SELECT * FROM emploi_du_temp WHERE idClasse='.$idClasse);
            ?>
			<div style="display: flex;">
				<span class="fa fa-hand-o-right">
                    <?php
                    if($valid == true){
                        echo '<a href="../backend/Gpage.php?page=modEmploi&id='.$classes['idClasse'].'" class="retxt-info">
                                '.$classes['nomClasse'].'<span style="color:cyan ;" class="fa fa-check"></span>
                            </a>';
                    }else{
                        echo '<a href="../backend/Gpage.php?page=ajtEmploi&id='.$classes['idClasse'].'" class="retxt-info">
                        '.$classes['nomClasse'].'<span style="color:red ;" class="fa fa-close"></span></a>';
                    }
                    ?>		
				</span>
			</div>
            <?php endwhile ?>
			<br>
		</div>
		<?php endwhile ?>
		</div>
	</div>
</div>


		