<?php
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY nomFiliere DESC');
$active = 3;
include_once 'lienPointage.php';
?>
<div class="col-lg-6 offset-lg-3">
	<div  class="section_title text-center">Gestion des Absents</div>
</div>
<div class="container">
	<div class="jumbotron">
		<div class="d-flex  flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
			<?php 
			$classe = $databases->requette('SELECT * FROM classe WHERE idFiliere = '.$idFiliere.' ORDER BY nomClasse');
			while($classes = $classe->fetch()) :?>
			<div style="display: flex;">
				<span class="fa fa-hand-o-right">
					<a href="../backend/Gpage.php?page=ajtAbsent&id=<?=$classes['idClasse']?>" class="retxt-info">
						<?=$classes['nomClasse']?>
                    </a>	
				</span>
			</div>
			<br>
			<?php endwhile ?>
		</div>
	
		<?php endwhile ?>
		</div>
	</div>
</div>


		