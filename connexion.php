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
    <title>Accueil</title>
</head>
<body>
<?php require('includes/header.php');

if ($_SESSION) {
    header('Location: index.php');
}
else {
?>

    <div class="form connexion col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
<h3>Connexion</h3>
        <form action="" method="post">
    <label for="username">Pseudo</label><br>
    <input type="text" name="username" id="username"><br><br>
    <label for="password">Mot de passe</label><br>
    <input type="password" name="password" id="password"><br><br>
    <input type="submit" value="Valider" class="btn"><br>

    <a href="inscription.php"><i>Pas encore inscrit ?</i></a>
</form>


<?php

if ((isset($_POST)) && (!empty($_POST['username'])) && (!empty($_POST['password']))) {
    $password = sha1($_POST['password']);
    $request = $db->prepare("SELECT * FROM user WHERE username=:username AND password=:password");
    $request->execute([
        ':username' => htmlentities($_POST['username']),
        ':password' => htmlentities($password)
    ]);
    $result = $request->fetchAll();

    if (count($result) > 0) {
        $_SESSION["id"] = $result[0]["id_user"];
        //header location vers accueil ou page membre
        header('Location: page_membre.php');
    } else {
        echo "connexion impossible, veuillez réessayer";
    }
}
}
?>

    </div>

<?php
require('includes/footer.html');