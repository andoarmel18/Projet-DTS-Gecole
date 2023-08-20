<div style="margin-top: 2cm;" class="row page_nav_row">
	<div class="col">
		<div class="page_nav">
			<ul class="d-flex flex-row align-items-start justify-content-center">
				<li <?php if($active === 'cls') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=classe">Ajout des classe</a></li>
				<li <?php if($active === 'lcls') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=listeClasse">Tous les Classe</a></li>
				<li <?php if($active === 'ins') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=inscription">Inscription</a></li>
				<li <?php if($active === 'let') : echo 'class="active "'; endif?> ><a href="../backend/Gpage.php?page=listeEtud">Tous les étudiants</a></li>
			</ul>
		</div>
	</div>
</div>