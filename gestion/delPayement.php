<?php
$idPayement = (int)preg_quote($_GET['id']);
$stat = $databases->requette('DELETE FROM ecolage WHERE idEcolage='.$idPayement);
header('location: ../backend/Gpage.php?page=listePayement&stat=1');
if($stat == false){
   echo 'erreur' ;
}