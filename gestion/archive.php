<?php
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY nomFiliere DESC');
$databases->requette('DELETE FROM conmdp');
?>
<div style="margin-top: 2cm;" class="col-lg-6 offset-lg-3">
	<div  class="section_title text-center">Les Classe Archive</div>
</div>
<div class="container">
	<div style="background-color: black;" class="jumbotron">		
		<br>
		<div  class="d-flex flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
            <?php
            $classe = $databases->requette('SELECT * FROM arch_classe
                WHERE idFiliere = '.$idFiliere.
                ' GROUP BY idClasse  ORDER BY nomClasse');
			while($classes = $classe->fetch()) : 
                $idClasse = $classes['idClasse'];
            ?>
			<div style="display: flex;">
				<span class="fa fa-hand-o-right">
					<a href="../backend/Gpage.php?page=listeArchive&id=<?=$classes['idClasse']?>&source=archive" class="retxt-info">
					<?=$classes['nomClasse']?>
					</a>	
				</span>
			</div>
            <?php endwhile ?>
			<br>
		</div>
		<?php endwhile ?>
		</div>
	</div>
</div>


		