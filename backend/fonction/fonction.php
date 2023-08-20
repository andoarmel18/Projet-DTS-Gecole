<?php
function compter($base){
    $data = new Database();
    $count = $data->requette('SELECT COUNT(*) as ligne FROM '.$base)->fetch();
    return $count['ligne'];
}

function compterLimit($base,$condition){
    $data = new Database();
    $count = $data->requette('SELECT COUNT(*) as ligne FROM '.$base.' WHERE id='.$condition)->fetch();
    return $count['ligne'];
}

function mdpValid($page){
    $confirmation = include_once '../Gpage.php?page=confMdp';
if($confirmation == true){
    header('location : ../Gpage.php?page='.$page);
}
}
function mdpConfirm($lien){
    echo '<div class="col-lg-6 offset-lg-3" style="margin-top: 2.5cm;">
    <div style="margin-top: 0.5cm; color:red;" class="section_title text-center">Confirmation De Votre Identité</div>
</div>
<div class="container">
    <div class="jumbotron">
        <form action="" method="POST">';
        $mdp = new Input('mdp','password','form-control','','');
        $mdp->CreatInput('Enter Votre Mot de Passe :','form-group');
        $bt = new Input('btn','submit','btn btn-info','Valider','');
        $bt->CreatInput('','Form-group');
       
    echo '</form>
    </div>
</div>';
if(!empty($_POST[$mdp->getName()])){
    $data = new Database();
    $data->ReqSecure("INSERT INTO conmdp (mdpconfirm) VALUES (:mdp)",[
        ":mdp" => $_POST[$mdp->getName()]
    ]);
    $id = $data->getAllData('SELECT MAX(id) as id FROM conmdp');
    header('location : '.$lien.'&id='.$id['id']);
}
}
function findMot($motChercher,$base,$table){
    $shortest = null;
    $closest = null;
    if(isset($motChercher)){
        $data = new Database();

        $word = $data->requette('SELECT DISTINCT '.$table.' FROM '.$base);
        while($words = $word->fetch()){
            $lev=levenshtein(strtolower($motChercher),strtolower($words[$table]));
            if($lev === 0){
                $closest[]=$words[$table];
                $shortest=0;
                break;
            }
            if($lev <= 2){
                $closest[]=$words[$table];
                $shortest=$lev;
               
            }
        }
    }
    
switch ($shortest) {
    case 0 :
        return $closest;
        break;
    case 1 :
        return $closest;
        break;
    case 2 :
        return $closest;
        break;
    default:
        return false;
        break;
    }
}

function NumberString(string $chiffre){
    $length = strlen($chiffre);
    $intTab = [
        0 => 'Zéro',
        1 => 'Un',
        2 => 'Deux',
        3 => 'Trois',
        4 => 'Quatre',
        5 => 'Cinq',
        6 => 'Six',
        7 => 'Sept',
        8 => 'Huit',
        9 => 'Neuf'
    ];
}


