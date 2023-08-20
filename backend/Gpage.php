<?php
session_start();
ob_start();
if(!empty($_SESSION['role'])) : 
require_once 'class/bdd.php';
require_once 'class/Input.php';
require_once 'fonction/fonction.php';
$active = null;
$success = null;
$databases = new Database();
$admin = $databases->getAllData('SELECT * FROM admin');
$erreur = [
	'Cette Données Existe Déjat Dans Notre Base!! Verifier d\'abord votre liste et puis essayer à nouveau',
	'Mot De Passe Invalide',
	'Image Trop Volumeux',
];
//date('D, d-M-Y');
$andro = [
	'Mon' => 'Lundi',
	'Tue' => 'Mardi',
	'Wed' => 'Mercredi',
	'Thu' => 'Jeudi',
	'Fri' => 'Vendredi',
	'Sat' => 'Samedi',
	'Sun' => 'Dimanche'
];
$volana= [
	'Jan' => 'Janvier',
	'Feb' => 'Fevrier',
	'Mar' => 'Mars',
	'Apr' => 'Avril',
	'May' => 'Mai',
	'Jun' => 'Juin',
	'Jul' => 'Juillet',
	'Aug' => 'Aout',
	'Sep' => 'Septembre',
	'Oct' => 'Octobre',
	'Nov' => 'Novembre',
	'Dec' => 'Decembre'
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<title>GESTION D'ECOLE</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Little Closet template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../gestion/styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="../gestion/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../gestion/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="../gestion/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="../gestion/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="../gestion/styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="../gestion/styles/responsive.css">
</head>
<body>

<!-- Menu -->

<div class="menu">

	<!-- Search -->
	<div class="menu_search">
		<form action="#" id="menu_search_form" class="menu_search_form">
			<input type="text" class="search_input" placeholder="Search Item" required="required">
			<button class="menu_search_button"><img src="../gestion/images/search.png" alt=""></button>
		</form>
	</div>
	
	<!-- Navigation -->
	<div class="menu_nav">
		<ul>
			<li><a href="Gpage.php?page=inscription">Accueil</a></li>
			<li><a href="Gpage.php?page=confMdp&id=0&action=payer">Payement</a></li>
			<li><a href="Gpage.php?page=AjoutProf">Les prof et Les Matières</a></li>
			<li><a href="Gpage.php?page=confMdp&id=0&action=note">Note</a></li>	
			<li><a href="Gpage.php?page=emploi">Emploi Du Temps</a></li>
			<li><a href="Gpage.php?page=choixSem&cible=bulletin">Bulletin De Note</a></li>	
			<li><a href="Gpage.php?page=pointage">Pointage</a></li>	
			<li><a href="Gpage.php?page=archive">Archive</a></li>	
		</ul>
	</div>
	<!-- Contact Info -->
	
	<div class="menu_contact">
		<div class="menu_social">
		<div class="card" style="margin-left: -1cm; width:9cm">
			<a href="Gpage.php?page=admin">
				<div style="display:flex;" >
					<div>
						<img style="width: 100px; height:100px" class="img-fluid rounded-circle img-thumbnail" src="../photo/<?=$admin['photo']?>" >
					</div>
					<div style="margin-left: 0.5cm;">
						<label for="">
							<strong style="color: black;">Institut :</strong>
							<p style="font-family: Angelina; font-size:20px"><i><?=strtoupper($admin['nom'])?></i> </p>
						</label><br>
						<label for="">
							<strong style="color: black;">Mail :</strong>
							<p style="font-family: Angelina; font-size:20px"><i><?=strtoupper($admin['mail'])?></i> </p>
						</label><br>
						<label for="">
							<strong style="color: black;">N° Institut :</strong>
							<p style="font-family: Angelina; font-size:20px"><i><?=strtoupper($admin['numero'])?></i> </p>
						</label>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>

</div>

<div class="super_container">

	<!-- Header -->

	<header class="header">
		<div class="header_overlay"></div>
		<div class="header_content d-flex flex-row align-items-center justify-content-start">
			<div class="logo">
				<a href="#">
					<div class="d-flex flex-row align-items-center justify-content-start">
					<div><img style="width: 35px;" src="../gestion/images/avatar-01.png" alt=""></div>
						<div>MENU</div>
					</div>
				</a>	
			</div>
			<div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
			<div style="margin-left: 2cm; width: 7cm">
			<marquee behavior="" direction="">
			<strong style="font-family: Menuetto; color:black;"><?=$andro[date('D')].' '.date('d').' '.$volana[date('M')].' '.date('Y')?></strong>
			</marquee>	
			</div>
			<div class="header_right d-flex flex-row align-items-center justify-content-start ml-auto">
				<!-- date -->
				
				<!-- Search -->
				<div class="header_search">
					<form action="Gpage.php?page=find" method="POST" id="header_search_form">
						<input type="text" class="search_input" name="chercher" placeholder="Search Item" required="required">
						<button class="header_search_button"><img src="../gestion/images/search.png" alt=""></button>
					</form>
				</div>
				<a href="../gestion/deconnexion.php" class="btn btn-danger cart" style="margin-left:3cm;"><span class="fa fa-sign-out"></span>Deconnexion</a>
				<!-- deconnexion 
				<div style="margin-left:7cm;" class="cart"  ><a  href="../gestion/deconnexion.php"><div style="display: flex; color:firebrick; font-size:20px"><img style="margin-left: -3cm ; height:20px; margin-top:0.1cm;" src="../gestion/images/deconnexion.jpg" >Deconnexion</div></a></div>
				-->
			</div>
		</div>
		
	</header>
	<?php if (isset($_GET['stat']) AND $_GET['stat'] == '1') : ?>
		<div class="container" style="margin-top: 3cm;">
			<div class="alert alert-info">
				<p>Opération Success</p>
			</div>
		</div>
		<?php elseif(isset($_GET['stat']) AND $_GET['stat'] == '2') : ?>
			<div class="container" style="margin-top: 3cm;">
				<div class="alert alert-danger">
					<p style="color:red ;">Ce Donné Existe Déjat Dans notre base!<span class="fa fa-exclamation-triangle"></span></p>
					<p>Verifier d'abord votre liste et puis essayer à nouveau</p>
				</div>
			</div>
		<?php elseif(isset($_GET['stat']) AND $_GET['stat'] == '3') : ?>
			<div class="container" style="margin-top: 3cm;">
				<div class="alert alert-danger">
					<p style="color:red ;">Il y a une ou plusieur erreur<span class="fa fa-exclamation-triangle"></span><br> Conseil</p>
					<ul>
						<li>Completer Tous Les Champ Obligatoire</li>
						<li>Verifier Les Information</li>
					</ul>
				</div>
			</div>
		<?php elseif(isset($_GET['stat']) AND $_GET['stat'] == '4') : ?>
			<div class="container" style="margin-top: 3cm;">
				<div class="alert alert-danger">
					<p style="color:red ;">Mot De Passe Incorrecte <span class="fa fa-exclamation-triangle"></span></p>
				</div>
			</div>
		<?php elseif(isset($_GET['stat']) AND $_GET['stat'] == '5') : ?>
			<div class="container" style="margin-top: 3cm;">
				<div class="alert alert-danger">
					<p style="color:red ;">Image trop grande<span class="fa fa-exclamation-triangle"></span></p>
				</div>
			</div>
		<?php elseif(isset($_GET['stat']) AND $_GET['stat'] == '6') : ?>
			<div class="container" style="margin-top: 3cm;">
				<div class="alert alert-danger">
					<p style="color:red ;">Enter Seulement Des Chiffe ou Des Chiffres En Virgule<span class="fa fa-exclamation-triangle"></span></p>
				</div>
			</div>
	<?php endif?>

    <?php 
    
        if(isset($_GET['page']))
        {
            $page =  $_GET['page'];
			include_once '../gestion/'.$page.'.php';
            /*Gpage('home' , '../gestion/inscription.php');
            Gpage('note' , '../gestion/note.php');
            Gpage('modif' , '../gestion/modif.php');
            Gpage('inscription' , '../gestion/inscription.php');
            Gpage('payement' , '../gestion/payement.php');
            Gpage('prof' , '../gestion/prof.php');
			Gpage('classe' , '../gestion/classe.php');
			Gpage('etudiant' , '../gestion/listeEtud.php');
			Gpage('lclasse' , '../gestion/listeClasse.php');
			Gpage('info' , '../gestion/infoEtudiant.php');
			Gpage('delete' , '../gestion/delete.php');
			Gpage('modifier' , '../gestion/modifier.php');
			Gpage('deleteClasse' , '../gestion/Dclasse?php');*/
            
        }
        else
        {
            include_once '../gestion/inscription.php';
        }
    ?>

<div class="footer_bar">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="footer_bar_content d-flex flex-md-row flex-column align-items-center justify-content-start">
					<div class="copyright order-md-1 order-2"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					 Application Web Developpé par <a href="" target="_blank">Ando Armel </a><span class="fa fa-hand-peace-o"></span>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
								
				</div>
			</div>
		</div>
	</div>
</div>




<script src="../gestion/js/jquery-3.2.1.min.js"></script>
<script src="../gestion/styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="../gestion/js/custom.js"></script>
<script>
	$(document).ready(function(){
	$('#err').hide();
	//occupation des prof
	$('#op').hide();
	$('#profOccup').click(function(){
		$('#op').slideToggle('normal');
	});
    //changement Photo
    $('#pict').hide();
    $('#btn').click(function() {
       $('#pict').toggle('normal');
    });
        //Affichage Info Etudiant
        $('#LFF').hide();
        $('#ff').click(function() {
            $('#rtd').hide();
            $("#lnt").hide();
            $("#labs").hide();
            $('#LFF').slideToggle('normal');
        });
            //Affichage Retard Etudiant
            $('#rtd').hide();
            $('#brtd').click(function() {
                $("#lnt").hide();
                $('#LFF').hide();
                $("#labs").hide();
                $('#rtd').toggle('normal');
            });
                //Affiche note
                $("#lnt").hide();
                $("#nt").click(function() {
                    $('#rtd').hide();
                    $('#LFF').hide();
                    $("#labs").hide();
                    $("#lnt").toggle('normal');
                });
                    //affiche absence
                    $("#labs").hide();
                    $("#abs").click(function() {
                        $('#rtd').hide();
                        $('#LFF').hide();
                        $("#lnt").hide();
                        $("#labs").toggle('normal');
                    });

                        //Info Classe
                        //liste FF
                        $("#p1").hide();
                        $("#fclasse").click(function() {
                            $("#p1").slideToggle('normal');
                        });
						
						
});

</script>

</body>
</html>
<?php else : header('location: ../index.php');?>
<?php endif ; 
$index = ob_get_clean(); 
echo $index;