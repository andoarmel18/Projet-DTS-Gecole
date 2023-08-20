<?php
$idMdp = $databases->getAllData('SELECT MAX(id) AS id FROM conmdp');
?>
<div style="margin-top: 2cm;" class="row page_nav_row">
	<div class="col">
		<div class="page_nav">
			<ul class="d-flex flex-row align-items-start justify-content-center">
				<li <?php if($active === 'pmt') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=payement&idmdp=<?=$idMdp['id']?>">Payement</a></li>
				<li <?php if($active === 'le') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=listePayement">Liste des payement effectué</a></li>
				
			</ul>
		</div>
	</div>
</div>

