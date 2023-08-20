<div style="margin-top: 2cm;" class="row page_nav_row">
	<div class="col">
		<div class="page_nav">
			<ul class="d-flex flex-row align-items-start justify-content-center">
				<li <?php if($active === 1) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=pointage">Retard</a></li>
				<li <?php if($active === 2) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=listeTard">Liste Des Retard</a></li>
                <li <?php if($active === 3) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=absence">Les Absences</a></li>
				<li <?php if($active === 4) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=ListeAbsence">Liste des Absents</a></li>	
			</ul>
		</div>
	</div>
</div>