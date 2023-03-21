<?php
session_start();
if(!isset($_SESSION["connected"])||$_SESSION["connected"]!="ok"){
    header("Location: login.php");
}
require_once "./connect.php";
$id = 0;
if(isset($_GET['id']) && $_GET['id']>0){
    $id = $_GET['id'];
}

$titre = "";
$resume = "";
$annee = "";
 $age_id = 0;
 $real_id = 0;

 if ($id >0){
     $stmt = $db->prepare("SELECT * FROM film WHERE film_id = :id");
     $stmt -> execute([":id" => $id]);
     if ($row = $stmt -> fetch()){
         $titre = $row["film_titre"];
         $resume = $row["film_description"];
         $annee = $row["film_date"];
         $age_id = $row["film_age_id"];
         $real_id = $row["film_realisateur_id"];
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire-to-SQL</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>Formulaire : Mathi fait son cinéma</h1>
    <section id= "container">
    <form action="./traitement.php" method="Post" enctype="multipart/form-data">
        
        <input type="hidden" name="film_id" value="<?=htmlspecialchars($id);?>">
        <br><br>
        <label for="">Titre Du Film</label> <br>
        <input require type="text" name="film_titre" class="taille" value="<?=htmlspecialchars($titre);?>">
        <br>
        <label for="">Description</label> <br>
        <input require type="text" name="film_description" value="<?=htmlspecialchars($resume);?>" class="taille" id="desc">
        <br>
        <label for="">Date de sortie</label> <br>
        <input require type="text" name="film_date" value="<?=htmlspecialchars($annee);?>" class="taille">
        <br>
        <br>
        <select require name="film_age_id" class="taille">
            
            <option value="0">Selectionnez la catégorie d'âge...</option>
            <?php 
                $recordset= $db->query ("SELECT * FROM age_categorie");
                foreach($recordset as $row){ ?>
                    <option value="<?=htmlspecialchars($row['age_id']);?>" <?=($row["age_id"]==$age_id)?"selected":"";?>>
                        <?=htmlspecialchars($row['age_minimum']);?>
                    </option>
                
            <?php }?>
        </select>
        <br>       
        <br> 
        <select require name="film_realisateur_id" class="taille">
            <option value="0">Selectionnez un réalisateur...</option>
            <?php 
                $recordReal = $db->query("SELECT * FROM realisateur");
                foreach($recordReal as $row){ ?>
                    <option value="<?=htmlspecialchars($row['realisateur_id']);?>" <?=($row["realisateur_id"]==$real_id)?"selected":" ";?>>
                        <?=htmlspecialchars($row['realisateur_nom']);?>
                        <?=htmlspecialchars($row['realisateur_prenom']);?>
                    </option>

            <?php }?>
            
        </select>
        <label for="">Durée du film</label>
        <input type="text" name="duree">
        <label for=""></label>
        <br>
        <br>
        <!-- <input type="hidden" name="film_id" value="<?//=$id;?>"> -->
        <input type="submit" value="Envoyer" id="bouton">
        <br>
        <br>
        <input type="file" name="film_image">
    </form>
    </section>
</body>
</html>