<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/header.css">
    <title>Réponse d'offre</title>
</head>
<body>
<?php require('includes/header.php');

$id_ad = $_SESSION['id_ad'];
echo $id_ad;
?>


<div class="row">
    <div class="form col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
        <p><a href="page_membre.php">< Retour</a></p>

        <h3>Réponse à l'offre</h3>
<form action="" method="post">
    <label for="accept">Statut</label>
    <select name="accept">
        <option value="1">En attente</option>
        <option value="2">Accepter</option>
        <option value="3">Refuser</option>
    </select><br>
    <label for="comments">Commentaires :</label><br>
    <textarea name="comments" id="" cols="30" rows="10"></textarea><br>
    <br>
    <button type="submit" name="valid" id="valid" value="valider" class="btn">Valider</button>
</form>
<?php

if (isset($_POST['valid']) && ($_POST['accept'] != "1")) {
    if ($_POST['accept'] == "2") {
        $req = $db->prepare("UPDATE response SET accepted = 'true', comments = :comments WHERE id_ad = $id_ad");
        $req->execute([
            ':comments' => $_POST['comments']
        ]);
        //print_r($req->errorInfo());
        header('Location:page_membre.php');
    } elseif ($_POST['accept'] == "3") {
        $req = $db->prepare("UPDATE response SET accepted = 'false', comments = :comments WHERE id_ad = $id_ad");
        $req->execute([
            ':comments' => $_POST['comments']
        ]);
        header('Location:page_membre.php');
    }
}
?>

</div>
</div>

<?php
require('includes/footer.html');

?>
