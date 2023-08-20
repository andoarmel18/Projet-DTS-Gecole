<?php
$semestre = (int)preg_quote($_GET['semestre']);
$filiere = $databases->requette('SELECT * FROM filiere ORDER BY nomFiliere DESC');
$databases->requette('DELETE FROM conmdp');
?>
<div style="margin-top: 2cm;" class="col-lg-6 offset-lg-3">
	<div  class="section_title text-center">Les Classe Existant</div>
</div>
<div class="container">
	<div style="background-color: black;" class="jumbotron">		
		<br>
		<div  class="d-flex flex-wrap">
		<?php while($filieres = $filiere->fetch()) : $idFiliere = $filieres['idFiliere'] ?>
		<div class="col-md-4">
			<h3><?=$filieres['nomFiliere'] ?></h3>
            <?php
            $classe = $databases->requette('SELECT * FROM classe WHERE idFiliere = '.$idFiliere.' ORDER BY nomClasse');
			while($classes = $classe->fetch()) : 
                $idClasse = $classes['idClasse'];
            $valid = $databases->Chearch('SELECT * FROM note WHERE idClasse='.$idClasse.' AND semestre='.$semestre);
            ?>
			<?php
            		if($valid == true){
                        $icone = '<span style="color: cyan;" class="fa fa-check"></span>';
						$bo = '<a';
						$bf = '</a>';
                    }else{
                        $icone = '<span style="color: red;" class="fa fa-close"></span>';
						$bo = '<b';
						$bf = '</b>';
                    }
                    ?>
			<div style="display: flex;">
				<span class="fa fa-hand-o-right">
					<?=$bo?> href="../fpdf184/PDF.php?id=<?=$classes['idClasse']?>&semestre=<?=$semestre?>" class="retxt-info">
					<?=$classes['nomClasse'].$icone?>
					<?=$bf?>	
				</span>
			</div>
            <?php endwhile ?>
			<br>
		</div>
		<?php endwhile ?>
		</div>
	</div>
</div>


		