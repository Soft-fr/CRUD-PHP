<?php 
session_start();
if(!isset($_SESSION["connected"])||$_SESSION["connected"]!="ok"){
    header("Location: login.php");
}
require_once "connect.php";
$id = 0;
if (isset($_POST['film_id']) && $_POST['film_id']>0){
    $id = $_POST['film_id'];
}


/*$titre=$_POST["titre"];
$desc = $_POST["description"];
$date = $_POST["sortie"];
$age = $_POST["age"];
$real = $_POST["real"];*/
//$sql = "INSERT INTO film(film_titre,film_description,film_date) VALUES ('".$titre."','".$desc."',".$date.")";

/*$stmt = $db->prepare("INSERT INTO film(film_titre,film_description,film_date) VALUES(?,?,?)";
$stmt->execute([$titre,$desc,$date]):*/

/*if($id > 0 ){
    $sql = "UPDATE film SET film_titre = :titre , film_description = :desc, film_date = :date, film_realisateur_id=:real,film_age_id=:age WHERE film_id = :id";
    
} else{
    $sql="INSERT INTO film(film_titre,film_description,film_date,film_age_id,film_realisateur_id)VALUES(:titre,:desc,:date,:age,:real)";
    
//$stmt->execute([":titre"=>$titre, ":desc"=>$desc,":date"=>$date]);

}


$stmt = $db->prepare($sql);
$stmt-> bindParam(":titre",$titre,PDO::PARAM_STR);
$stmt-> bindParam(":desc",$desc,PDO::PARAM_STR);
$stmt-> bindParam(":date",$date,PDO::PARAM_INT);
$stmt->bindParam(":age",$age,PDO::PARAM_INT);
$stmt->bindParam(":real",$real,PDO::PARAM_INT);
$stmt->execute();*/

$sql2 = "";
$values = [];
function renommage($fichierSource,$titreFilm){
    $result=$titreFilm;
    $result=str_replace(" ","-",$result);
    $result=str_replace("é","e",$result);
    $result=str_replace(["?"],[""],$result);

    $result= str_replace(" ","-",$result);
    $ext = substr($fichierSource,strrpos($fichierSource,"."));
    return $result.$ext;
    
}
if(isset($_FILES['film_image'])&& $_FILES['film_image']['name']!=""){
    $newFile=  renommage($_FILES['film_image']['name'],$_POST['film_titre']);
    move_uploaded_file($_FILES["film_image"]["tmp_name"],"./upload/".$newFile);
}





echo $_FILES['film_image']['tmp_name'];
if($id>0){
    $sql = "UPDATE film SET ";
    foreach($_POST as $key => $value){
        if($key != "film_id"){
            $sql .= $key." = :".$key.",";
            $values[":".$key] = $value;
        }

    }
    $sql = rtrim($sql,",");
    $sql .= " WHERE film_id=:film_id";
    $values[":film_id"] = $_POST["film_id"];
    echo $sql;
}else{
    $sql = "INSERT INTO film(";
    foreach($_POST as $key=>$value){
        if($key != "film_id"){
            $sql .= $key.",";
            $sql2 .=":".$key.",";
            $values[":".$key] = $value;
            }
    }
    $sql = rtrim($sql,",");
    $sql2 = rtrim($sql2,",");
    
    $sql .= ") VALUES(".$sql2.");";
    
    
    echo $sql;
  //var_dump ($values);
}
$stmt = $db->prepare($sql);
$stmt->execute($values);







 header("Location: index.php");





?>