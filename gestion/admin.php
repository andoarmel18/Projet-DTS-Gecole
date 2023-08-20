<?php
$admin = $databases->getAllData('SELECT * FROM admin');
?>
<div class="container">
<div class="col-lg-6 offset-lg-3">
	<div style="margin-top: 2cm;" class="section_title text-center">A propos De Vous</div>
</div>
    <div class="jumbotron" style="display: flex;">
        <div class="col-md-5">
            <img  class="img-fluid img-thumbnail" src="../photo/<?=$admin['photo']?>">
            <br>
            <br>
            <button id="btn" class="btn btn-primary">Changer la photo</button>
            <br>
            <br>
            <div id="pict">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="img" id="" class="from-control">
                    <input type="submit" value="Changer" class="btn btn-success">
                </form>
                <?php
                 if(!empty($_FILES['img']) AND $_FILES['img']['error'] == 0){
                    $file_info = pathinfo($_FILES['img']['name']);
                    $extension = $file_info['extension'];
                    $extension_autorised = ['jpeg' , 'png' ,'jpg'];
                    $name = basename($_FILES['img']['name']);
                
                        if(in_array($extension , $extension_autorised)){
                            move_uploaded_file($_FILES['img']['tmp_name'],'../photo/'.$name);  
                            $stat = $databases->ReqSecure('UPDATE admin SET photo=:photo',[
                                ':photo' => $name
                            ]);
                            if($stat){
                                header('location: ../backend/Gpage.php?page=admin&stat=1');
                            }else{
                                header('location: ../backend/Gpage.php?page=admin&stat=5');
                            }
                        }
                }
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <table class="table"> 
                <thead class="thead-light"> 
                   
                    <tr>
                        <th style="color:rgb(7, 202, 216);">Nom Institut : <span  style="color: black;"><?="  ".$admin['nom']?></span></th>
                       
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Pseudo : <span  style="color: black;"><?="  ".$admin['pseudo']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Slogan : <span  style="color: black;"><?="  ".$admin['slogan']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Numéro d'Institut : <span  style="color: black;"><?="  ".$admin['numero']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Adresse : <span  style="color: black;"><?="  ".$admin['adresse']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Mail : <span  style="color: black;"><?="  ".$admin['mail']?></span></th>
                    </tr>
                    <tr>
                        <th style="color: rgb(7, 202, 216);">Site Web: <span  style="color: black;"><?="  ".$admin['lien']?></span></th>
                    </tr>
                </thead> 
                
            </table>
           <a href="../user/mdpOublier.php" class="btn btn-danger">Changer le Mot de Passe</a> 
           <a href="../backend/Gpage.php?page=modAdmin&id=<?=$admin['idAdmin']?>" class="btn btn-info">Modifier les Information</a> 
        </div>
        </div>