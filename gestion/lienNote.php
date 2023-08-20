<?php
$idMdp = $databases->getAllData('SELECT MAX(id) AS id FROM conmdp');
?>
<div style="margin-top: 2cm;" class="row page_nav_row">
	<div class="col">
		<div class="page_nav">
			<ul class="d-flex flex-row align-items-start justify-content-center">
				<li <?php if($active === 1) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=note&idmdp=<?=$idMdp['id']?>">Ajout Des Notes</a></li>
                <li <?php if($active === 2) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=AfficheNote">Note par Classe</a></li>
				
				
			</ul>
		</div>
	</div>
</div>
