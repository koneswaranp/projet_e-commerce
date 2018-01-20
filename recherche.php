<?php


$result ="";
if(isset($_POST['query'])&& !empty($_POST['query'])){

    $query =preg_replace("#[a-zA-Z ?0-9]#i","" ,$_POST['query']);
    if ($_POST['Site'] == "Site entier") {

    }else if ($_POST['Site'] == "Pages") {

    }

    include("includes/init.php");

    $req = $db->prepare($sql);
    $req ->execute(array('%'.$query. '%', '%'.$query.'%'));

    $count =$req->rowCount();
    if($count >=1){


        echo"$count Resultat trouvés pour <strong>$query</strong>";
        while ($data =$req->fetch(PDO::FETCH_OBJ)){
            echo '#'.$data ->id. ' -Titre:' .$data->title.'';   }
    }else{
        echo"Resultat trouvé pour <strong>$query</strong>";
    }

}
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche</title>
</head>
<body>
<form action="index.php" method="post">
    <label for="query">Entrer votre recherche: </label>
    <input type="search" name="query" maxlength="80" size="80" id="query" /><br>
    Rechercher au niveau de:
    <select name="Site">
        <option value="Site entier">Site Entier</option>
        <option value="Pages">Pages</option>
    </select><br>
    <input type="submit" value="Rechercher">

</form>


</body>
</html>