<?php require_once "connect.php";
$id = 0;
if (isset($_GET["id"]) && $_GET["id"]>0){
    $id = $_GET["id"];
}

echo $sql = "DELETE FROM film WHERE film_id = ".$id.";";

$stmt = $db->prepare($sql);
$stmt->execute();
header("Location: index.php");
?>

