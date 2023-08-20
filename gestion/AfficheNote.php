<?php
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY idFiliere DESC');
$active = 2;
include_once 'lienNote.php';

?>
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: cm;" class="section_title text-center">Gestion des notes</div>
</div>
<div class="container">
   <h3 style="font-family: walrusGumbo; color: black" class="text-center">Choissez la classe que vous voulez afficher leur note</h3>
   <br>
	<div class="card">
		<fieldset style="border: solid black 1px; width: 7cm ">
			<p style="color: black;"><span class="fa fa-file-text"></span> Classe  contient  des notes</p>
			<p style="color: black;"><span class="fa fa-file-o"></span> Classe ne contient pas des notes</p>
		</fieldset>
		<br>
		<br>
    
		<div  class="d-flex flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
		<?php
		$classe = $databases->requette('SELECT * FROM classe WHERE idFiliere = '.$idFiliere.' ORDER BY nomClasse');
		while($classes = $classe->fetch()):
		$sem1 = $databases->Chearch('SELECT * FROM note n 
			JOIN matiere m ON m.idMatiere=n.idMatiere
			JOIN filiere f ON f.idFiliere=m.idFiliere
			JOIN classe c ON c.idFiliere=f.idFiliere
			WHERE n.semestre=1 AND n.idClasse='.$classes['idClasse']);

		$sem2 = $databases->Chearch('SELECT * FROM note n 
			JOIN matiere m ON m.idMatiere=n.idMatiere
			JOIN filiere f ON f.idFiliere=m.idFiliere
			JOIN classe c ON c.idFiliere=f.idFiliere
			WHERE n.semestre=2 AND n.idClasse='.$classes['idClasse']);

		?>
			<div style="display: flex;">
				<span class="fa fa-hand-o-right">
					<a href="../backend/Gpage.php?page=affNote&id=<?=$classes['idClasse']?>" class="retxt-info">
					<?=$classes['nomClasse']?>
						<?php if($sem1 == true ): ?>
							<span class="fa fa-file-text"></span>
							<?php else : ?> 
							<span class="fa fa-file-o"></span>
						<?php endif ?>
						<?php if($sem2 == true ): ?>
							<span class="fa fa-file-text"></span>
							<?php else : ?> 
							<span class="fa fa-file-o"></span>
						<?php endif ?>
					</a>	
				</span>
			</div>
		</br>
		<?php endwhile ?>
		</div>
		<span></span>
		<?php endwhile ?>
		</div>
	</div>
</div>
<br>
<br>
