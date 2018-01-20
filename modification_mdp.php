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
    <title>Changement de mot de passe</title>
</head>
<body>
<?php require('includes/header.php');

$id = $_SESSION['id'];
$req = $db->query("SELECT * FROM user WHERE id_user = $id");
$user = $req->fetch();

?>
<div class="row">
    <div class="form col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
        <br>
        <a href="page_membre.php"> < Retour</a>
<h3>Changement de mot de passe</h3>
<form action="" method="post">
    <label for="old_pwd">Ancien mot de passe</label><br>
    <input type="password" name="old_pwd" id="old_pwd"><br>

    <label for="new_pwd">Nouveau mot de passe</label><br>
    <input type="password" name="new_pwd" id="new_pwd"><br>

    <label for="new_pwd2">Confirmation du nouveau mot de passe</label><br>
    <input type="password" name="new_pwd2" id="new_pwd2"><br><br>

    <input type="submit" value="Modifier" class="btn mdp">
</form>

<?php
if ((isset($_POST)) && (!empty($_POST['old_pwd'])) && (!empty($_POST['new_pwd'])) && (!empty($_POST['new_pwd2']))) {
    $old_pwd = sha1($_POST['old_pwd']);
    $old_pwd2 = $user['password'];
    $new_pwd =sha1($_POST['new_pwd']);
    $new_pwd2 = sha1($_POST['new_pwd2']);

    if($old_pwd != $old_pwd2){
        echo "Votre \"ancien\" mot de passe est erroné.";
    }
    elseif($new_pwd != $new_pwd2) {
        echo "Les nouveaux mots de passe ne sont pas identiques";
    }
    else {
        $req = $db->prepare("UPDATE user SET password = :password WHERE id_user = $id");
        $req->execute([
            ':password' => $new_pwd
        ]);
        header('Location: page_membre.php');
    }

}
?>

    </div>
</div>
<?php
require('includes/footer.html');
