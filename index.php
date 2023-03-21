<?php  
session_start();
if(!isset($_SESSION["connected"])||$_SESSION["connected"]!="ok"){
    header("Location: login.php");
}
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
require_once "./connect.php";



//echo renommage("sdolauhkqsdjqspqzaraz5448sq6.jfif","la communautée de l'anneau");

//$ext = substr($fichierSource,strrpos($fichierSource,"."));

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'acceuil BDD film</title>
    <link rel="stylesheet" href="./styleIndex.css">
</head>
<body>
    <br>
    <button id="create" >
        <a href="./formulaire.php">
            Ajouter un nouveau film
        </a>
    </button>
    <ul id="film">
    <?php 
        $pages = 10;
        $nbPage =1;
        $lavariablepourfaireplaisiraJarod = (($currentPage-1)*$pages);
        $recordset= $db->query ("SELECT * FROM film ORDER BY film_titre ASC LIMIT 10 OFFSET $lavariablepourfaireplaisiraJarod" );
        foreach($recordset as $row){ ?>
            <li class='filmListe'>
                <span> <?=htmlspecialchars("==>".$row['film_titre']);?></span>
                <div>
                    <a href="./formulaire.php?id=<?=$row["film_id"];?>">
                        <button>
                            Modifier
                        </button>
                    </a>        
                    <a href="./delete.php?id=<?=$row["film_id"];?>">
                        <button>
                            Supprimer
                        </button>
                    </a>

                </div>

            </li>
            
    <?php }?>
    </ul>
    <nav>
         <ul class="pagination">
             <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
             <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                          <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>

</body>
</html>