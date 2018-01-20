<?php header("Content-type: text/html; charset=utf-8"); ?>
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
    <title>Devonation</title>
</head>
<body>
<?php require('includes/header.php');

if (isset($_SESSION['id'])) {

    ?>

    <div class="row">
            <div class="form content col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                <h2>Publier une annonce</h2>
                <form action="" method="post">
                    <label for="title">Titre de l'annonce</label><br>
                    <input type="text" name="title" id="title" value="<?php if (isset($_POST['title'])) {
                        echo $_POST['title'];
                    } ?>"><br><br>
                    <label for="deadline">Date de fin</label><br>
                    <input type="date" name="deadline" id="deadline" value=""><br><br>
                    <label for="description">Description de l'annonce</label><br>
                    <textarea name="description" id="content" cols="80" rows="10"></textarea><br><br>
                    <input type="submit" content="S'inscrire" class="btn">
                </form>

                <?php
                if ((isset($_POST)) && (!empty($_POST['title'])) && (!empty($_POST['description']))) {
                    $deadline = (isset($_POST['deadline']) && !empty($_POST['deadline'])) ? $_POST['deadline'] : null;
                    $request = $db->prepare("INSERT INTO ad (title, ad_date, deadline, description, id_user) VALUES (:title, NOW(), :deadline, :description, :id_user)");
                    $request->execute([
                        ':title' => $_POST['title'],
                        ':deadline' => $deadline,
                        ':description' => $_POST['description'],
                        ':id_user' => $_SESSION['id']
                    ]);
                    echo "Votre annonce a été publié.";
                } ?>
            </div>
            <div class="row">
                <div class="ads content col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <h3>Toutes les annonces</h3>
                    <table class="table table-striped table-hover">
                        <tr class="entete">
                            <td><b>Numéro de l'annonce</b></td>
                            <td><b>Utilisateur</b></td>
                            <td><b>Titre de l'annonce</b></td>
                            <td><b>Date de mise en ligne</b></td>
                        </tr>
                        <?php

                        $req = $db->query("SELECT * FROM ad ORDER BY ad_date desc");
                        $ads = $req->fetchAll();
                        foreach ($ads as $ad) {
                            $id_user = $ad['id_user'];
                            $req = $db->query("SELECT * FROM user WHERE id_user = $id_user");
                            $user = $req->fetch();
                            ?>
                            <tr>
                                <td>
                                    <?php echo $ad['id_ad']; ?>
                                </td>
                                <td>
                                    <a href="Profil/profil_infos_utilisateur.php?id_user=<?php echo $ad['id_user']?>" class="dark_link">
                                    <?php echo $user['username']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="annonce.php?id_ad=<?php echo $ad['id_ad']?>" class="dark_link">
                                    <?php echo $ad['title']; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    if (isset($ad['ad_date'])) {
                                        $array = explode(" ", $ad['ad_date']);
                                        $date = explode("-",$array[0]);
                                        $new_date = "$date[2]-$date[1]-$date[0]";
                                        echo $new_date;
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
    </div>
    <?php
} else {
    ?>
<div class="row">
    <div class="form content col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
    <h2>Bienvenue sur DevoNation</h2>
        <h3>Qui sommes-nous ?</h3>
        <p>
            Créée en 2017 par une équipe de trois étudiantes de l'école Ynov Informatique Ingésup, DevoNation est une plateforme permettant de mettre en relations des clients et des développeurs.
            Vous chercher à réaliser une application mobile, un site web ou encore un logiciel ? DevoNation vous met en relation avec des développeurs prêts à vous aider à concrétiser votre projet.
            Inscrivez vous dès maintenant pour rencontrer votre future équipe.
        </p>
    </div>
</div>
<div class="row">
    <div class="content inscription col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
    <h3>
        <a href="inscription.php">
            Inscrivez vous dès maintenant !
        </a>
    </h3>

    </div>
</div>




    <?php
}
require('includes/footer.html');
