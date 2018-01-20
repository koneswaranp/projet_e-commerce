<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/header.css">
    <title>Modification du profil</title>
</head>

<body>
    <?php require('includes/header.php');

$id = $_SESSION['id'];
$req = $db->query("SELECT * FROM user WHERE id_user = $id");
$user = $req->fetch();
?>
    <div class="row">
        <div class="form col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <p>
                <a href="page_membre.php">
                    < Retour </a>
            </p>

            <h2>Modifier mon profil</h2>
            <form enctype="multipart/form-data" action="" method="post" name="modif">

                <label for="username">Pseudo</label><br>
                <input type="text" name="username" id="username" value="<?php echo $user['username'] ?>" /><br>

                <label for="last_name">Nom</label><br>
                <input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name'] ?>" /><br>

                <label for="first_name">Prénom</label><br>
                <input type="text" name="first_name" id="first_name" value="<?php echo $user['first_name'] ?>" /><br>

                <label for="mail">Mail</label><br>
                <input type="email" name="mail" id="mail" value="<?php echo $user['mail'] ?>" /><br>

                <label for="phone">Telephone</label><br>
                <input type="text" name="phone" id="phone" value="<?php echo $user['phone'] ?>" /><br>

                <label for="github">Github</label><br>
                <input type="text" name="github" id="github" value="<?php echo $user['github'] ?>" /><br>

                <label for="linkedin">Linkedin</label><br>
                <input type="text" name="linkedin" id="linkedin" value="<?php echo $user['linkedin'] ?>" /><br>

                <label for="perso">Site Personnel</label><br>
                <input type="text" name="perso" id="perso" value="<?php echo $user['perso'] ?>" /><br>

                <label for="description">Description</label><br>
                <textarea name="description" id="description" rows="10" cols="50"><?php echo $user['description'] ?></textarea>

                <br>
                <!--<div>
                <button type="button" id="btnmodif" onclick="enable()">Modifier mon profil </button>
            </div>!-->
                <br>
                <input type="submit" value="Envoyer" class="btn">

            </form>
            <?php
        if ((isset($_POST)) 
            && (!empty($_POST['username'])) 
            && (!empty($_POST['last_name'])) 
            && (!empty($_POST['first_name'])) 
            && (!empty($_POST['mail'])) 
            && (!empty($_POST['phone'])) ) {
            $req = $db->prepare("UPDATE user SET username = :username, last_name = :ln, first_name = :fn, mail = :mail, phone = :phone, github = :github, linkedin = :linkedin, perso = :perso, description = :description WHERE id_user = $id");
            $req->execute([
                ':username' => $_POST['username'],
                ':ln' => $_POST['last_name'],
                ':fn' => $_POST['first_name'],
                'mail' => $_POST['mail'],
                'phone' => $_POST['phone'],
                'github' => $_POST['github'],
                'linkedin' => $_POST['linkedin'],
                'perso' => $_POST['perso'],
                'description' => $_POST['description']
            ]);
            header('Location: page_membre.php');
        }

        ?>

                <a href="modification_mdp.php">Modifier mon mot de passe ></a>
        </div>
    </div>

    <?php
require('includes/footer.html');
