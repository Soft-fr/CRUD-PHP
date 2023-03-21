<?php 
try{
    $dbhost = 'localhost';
    $dbname = 'film';
    $dbuser = 'root';
    $dbpwd = 'root';
    $db = new PDO ('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8',$dbuser,$dbpwd);

}
catch(Exception $e){
    die ('Erreur :'.$e->getMessage());
}


?>
