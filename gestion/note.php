<?php
ob_start();
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY nomFiliere DESC');
$active = 1;
include_once 'lienNote.php';
$idMdp = (int)preg_quote($_GET['idmdp']);
$mdp = $databases->getAllData('SELECT mdp FROM admin');
$userMdp = $databases->getAllData('SELECT mdpconfirm FROM conmdp WHERE id='.$idMdp);
?>
<div class="col-lg-6 offset-lg-3">
	<div  class="section_title text-center">Gestion des notes</div>
</div>
<div class="container">
	<div class="jumbotron">
		<div class="d-flex  justify-content-center">
			<fieldset style="border: solid black 1px; width: 7cm ">
				<p style="color: black;"><span class="fa fa-file-text"></span> Classe  contient  des notes</p>
				<p style="color: black;"><span class="fa fa-file-o"></span> Classe ne contient pas des notes</p>
			</fieldset>
		</div>
		
		<br>
		<div  class="d-flex flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
			<?php 
			$classe = $databases->requette('SELECT * FROM classe WHERE idFiliere = '.$idFiliere.' ORDER BY nomClasse');
			while($classes = $classe->fetch()) :
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

		if($sem2 == true AND $sem1 == true){
			$Bouvert = '<strong';
			$Bferme = '</strong>';
		}else{
			$Bouvert = '<a';
			$Bferme = '</a>';
		}
			?>
			<div class="d-flex  flex-wrap">
				<span class="fa fa-hand-o-right">
					<?=$Bouvert?> href="../backend/Gpage.php?page=choixSem&id=<?=$classes['idClasse']?>&cible=note" class="retxt-info">
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
					<?=$Bferme?>	
				</span>
			</div>
			<br>
			<?php endwhile ?>
		</div>
	
		<?php endwhile ?>
		</div>
	</div>
</div>
<?php $content = ob_get_clean(); 
if($mdp['mdp'] === $userMdp['mdpconfirm']){
	echo $content;
}else {
	header('location: ../backend/Gpage.php?page=confMdp&stat=4');
}
?>

		