
<div style="margin-top: 2cm;" class="row page_nav_row">
	<div class="col">
		<div class="page_nav">
			<ul class="d-flex flex-row align-items-start justify-content-center">
				<li <?php if($active === 2) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=AjoutProf">Ajout Des Profs</a></li>
				<li <?php if($active === 3) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=LprofMat">Liste des matières</a></li>
				<li <?php if($active === 5) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=Lprof">Liste des Profs</a></li>
				<li <?php if($active === 4) : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=action">Profs/Matieres</a></li>
			</ul>
		</div>
	</div>
</div>