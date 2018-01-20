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
if ($_SESSION){
    header('Location: index.php');
}
else {
?>
<div class="row">
    <div class="form col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
        <h2>Inscription</h2>
        <form enctype="multipart/form-data" action="" method="post">
            <label for="username">Pseudo</label><br>
            <input type="text" name="username" id="username" value="<?php if (isset($_POST['username'])) {
                echo $_POST['username'];
            } ?>"><br><br>
            <label for="last_name">Nom</label><br>
            <input type="text" name="last_name" id="last_name" value="<?php if (isset($_POST['last_name'])) {
                echo $_POST['last_name'];
            } ?>"><br><br>
            <label for="first_name">Prénom</label><br>
            <input type="text" name="first_name" id="first_name" value="<?php if (isset($_POST['first_name'])) {
                echo $_POST['first_name'];
            } ?>"><br><br>
            <label for="mail">Adresse mail</label><br>
            <input type="email" name="mail" id="mail" value="<?php if (isset($_POST['mail'])) {
                echo $_POST['mail'];
            } ?>"><br><br>
            <label for="mail2">Confirmation de l'adresse mail</label><br>
            <input type="email" name="mail2" id="mail2" value="<?php if (isset($_POST['mail2'])) {
                echo $_POST['mail2'];
            } ?>"><br><br>
            <label for="password">Mot de passe</label><br>
            <input type="password" name="password" id="password"><br><br>
            <label for="password2">Confirmation mot de passe</label><br>
            <input type="password" name="password2" id="password2"><br><br>
            <label for="phone">Phone</label><br>
            <input type="text" name="phone" id="phone" value="<?php if (isset($_POST['phone'])) {
                echo $_POST['phone'];
            } ?>"><br><br>

            <label for="photo">Photo de profil</label><br>
            <input type="file" name="photo"><br><br>


            <input type="submit" content="S'inscrire" class="btn"><br>

            <a href="connexion.php"><i>Déjà inscrit ?</i></a>
        </form>

        <?php
        if ((isset($_POST)) && (!empty($_POST['username'])) && (!empty($_POST['last_name'])) && (!empty($_POST['first_name']))
            && (!empty($_POST['mail'])) && (!empty($_POST['mail2'])) && (!empty($_POST['password'])) && (!empty($_POST['password2']))
            && (!empty($_POST['phone'])) && (!empty($_FILES['photo']))
        ) {
            //Vérification que les adresses mail sont identiques
            if ($_POST['mail'] != $_POST['mail2']) {
                echo "Les adresses mail ne sont pas identiques";
            } else {
                $crypt_pwd = sha1($_POST['password']);
                $crypt_pwd2 = sha1($_POST['password2']);
                //Vérification que les mots de passe sont identiques
                if ($crypt_pwd != $crypt_pwd2) {
                    echo "Les mots de passe ne sont pas identiques";
                } else {
                    $directory = 'img/';
                    $extensions = array('png', 'jpeg', 'jpg'); //extension autorisé pour les images.
                    $mimes = array('image/png', 'image/jpeg'); //extension autorisé pour les images

                    // Vérifier le typemime du fichier qui sera uploadé
                    $verifymime = finfo_open(FILEINFO_MIME_TYPE); // vérifier le mime
                    $mime = finfo_file($verifymime, $_FILES['photo']['tmp_name']); // regarder dans ce fichier le type mime
                    if (!in_array($mime, $mimes)) {
                        echo "Ce type de fichier n'est pas autorisé";
                        finfo_close($verifymime); //Une fois vérifié on arrête la lecture
                    } else {
                        finfo_close($verifymime); //Une fois vérifié on arrête la lecture
                        $tableau = explode('.', $_FILES['photo'] ['name']); // on fait un tableau
                        $imagename = $_FILES['photo']['name']; //Nom réel de l'image
                        $extension = $tableau[1];
                        $old_path = $_FILES['photo'] ['tmp_name']; //Nom temporaire donné par le serveur
                        $imagetype = $_FILES['photo'] ['type']; // type de l'image
                        $imagesize = $_FILES['photo'] ['size']; // poids de l'image
                        if (!in_array($extension, $extensions)) {
                            echo "Ce type de fichier n'est pas de la bonne extension";
                        } else {
                            //Vérifions si le fichier est supérieur à 8Mo
                            $taille_maxi = 8000000; // taille maximum autorisé par le serveur.
                            if ($imagesize > $taille_maxi) {
                                echo "Désolé le fichier est trop gros..";
                            } else {
                                $newname = "photo" . uniqid();
                                $finalname = $newname . '.' . $extension;
                                $new_path = $directory . $finalname;
                                move_uploaded_file($old_path, $new_path);


                                //Envoi des données en bdd
                                $request = $db->prepare("INSERT INTO USER (username, last_name, first_name, mail, password, phone, profile_photo) VALUES (:username, :last_name, :first_name, :mail, :password,
                                            :phone, :photo)");
                                $sending = $request->execute([
                                    ':username' => $_POST['username'],
                                    ':last_name' => $_POST['last_name'],
                                    ':first_name' => $_POST['first_name'],
                                    ':mail' => $_POST['mail'],
                                    ':password' => $crypt_pwd,
                                    ':phone' => $_POST['phone'],
                                    ':photo' => $new_path
                                ]);
                                //print_r($request->errorInfo());
                                header('Location: connexion.php');
                            }
                        }
                    }
                }
            }
        }
        ?>
    </div>
</div>
<?php
require('includes/footer.html');
}