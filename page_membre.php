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
    <title>Page Membre</title>
</head>
<body>
<?php require('includes/header.php');


$id = $_SESSION['id'];
$req = $db->query("SELECT * FROM user WHERE id_user = $id");
$user = $req->fetch();
?>
<div class="container">
    <div class="row">
        <div class="menu_membre col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <ul>
                <li><a href="modification.php">Modifier mon profil</a></li>
                <li><a href="./profil/profil_infos_utilisateur.php?id_user=<?php echo $id; ?>">Voir mon profil</a></li>
            </ul>
        </div>
        <div class="ads content_membre col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h1>Bienvenue dans votre espace membre,
                <?php
                echo $user['first_name'] . ".";
                ?>
            </h1>
            <br>
            <h3>Vos annonces</h3>

            <?php
            $req = $db->query("SELECT * FROM ad WHERE id_user = $id");
            $ads = $req->fetchAll();

            if (!empty($ads)) {
                ?>
                <table class="table table-striped table-hover">
                    <tr>
                        <td><b>Numéro de l'annonce</b></td>
                        <td><b>Titre de l'annonce</b></td>
                        <td><b>Deadline</b></td>
                        <td><b>Description</b></td>
                    </tr>
                    <?php
                    foreach ($ads as $ad) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $ad['id_ad']; ?>
                            </td>
                            <td>
                                <?php echo $ad['title']; ?>
                            </td>
                            <td>
                                <?php
                                if (isset($ad['deadline'])) {
                                    echo $ad['deadline'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $ad['description']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                ?>
                <tr>
                    <i>Cette section est vide.</i>
                </tr>
                <?php
            }

            ?>

            <br>
            <HR size=2 align=center width="100%">
            <br>
            <h3>Réponses à vos annonces</h3>

            <?php

            $req = $db->query("SELECT * FROM response WHERE id_client = $id");
            $res = $req->fetchAll();
            if (!empty($res)) {
                ?>
                <table class="table table-striped table-hover">
                    <tr>
                        <td><b>Numéro de l'annonce</b></td>
                        <td><b>Date</b></td>
                        <td><b>Pseudo</b></td>
                        <td><b>Description</b></td>
                        <td><b>Répondre</b></td>
                    </tr>
                    <?php
                    foreach ($res as $re) {
                        $id_dev = $re['id_dev'];
                        $req = $db->query("SELECT * FROM user WHERE id_user = $id_dev");
                        $user = $req->fetch();
                        ?>

                        <tr>
                            <td>
                                <?php echo $re['id_ad']; ?>
                            </td>
                            <td>
                                <?php
                                $array = explode(" ", $re['date_response']);
                                $date = explode("-",$array[0]);
                                $new_date = "$date[2]-$date[1]-$date[0]";
                                echo $new_date;
                                ?>
                            </td>
                            <td>
                                <a href="Profil/profil_infos_utilisateur.php?id_user=<?php echo $ad['id_user']?>" class="dark_link">
                                    <?php echo $user['username']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $re['response']; ?>
                            </td>
                            <td>
                                <?php
                                if (!$re['accepted']) {
                                    $_SESSION['id_ad'] = $re['id_ad'];
                                    ?>
                                    <a href="form_accept.php">Répondre</a>
                                    <?php
                                } elseif ($re['accepted'] == 'true') {
                                    echo "<b>Nom de votre correspondant : </b>" . $user['first_name'] . " " . $user['last_name'] . "<br>";
                                    echo "<b>Numéro de téléphone : </b>" . $user['phone'] . "<br>";
                                    echo "<b>Adresse mail :</b> " . $user['mail'];
                                } else {
                                    echo "Vous avez refusé cette proposition";
                                }
                                ?>

                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                ?>
                <i>Cette section est vide.</i>
                <?php
            }
            ?>
            <br>
            <HR size=2 align=center width="100%">
            <br>
            <h3>Annonces auxquels vous avez répondu</h3>

            <?php

            $req = $db->query("SELECT * FROM response WHERE id_dev = $id");
            $res = $req->fetchAll();
            if (!empty($res)) {
                ?>

                <table class="table table-striped table-hover">
                    <tr>
                        <td><b>Numéro de l'annonce</b></td>
                        <td><b>Date</b></td>
                        <td><b>Pseudo</b></td>
                        <td><b>Description</b></td>
                        <td><b>Réponse</b></td>
                    </tr>
                    <?php
                    foreach ($res as $re) {
                        $id_client = $re['id_client'];
                        $req = $db->query("SELECT * FROM user WHERE id_user = $id_client");
                        $user = $req->fetch();
                        ?>

                        <tr>
                            <td>
                                <?php echo $re['id_ad']; ?>
                            </td>
                            <td>
                                <?php
                                $array = explode(" ", $re['date_response']);
                                $date = explode("-",$array[0]);
                                $new_date = "$date[2]-$date[1]-$date[0]";
                                echo $new_date;
                                ?>
                            </td>
                            <td>
                                <a href="Profil/profil_infos_utilisateur.php?id_user=<?php echo $ad['id_user']?>" class="dark_link">
                                    <?php echo $user['username']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $re['response']; ?>
                            </td>
                            <td>
                                <?php
                                if ($re['accepted'] == 'true') {
                                    echo "Offre acceptée" . "<br>";
                                    echo "<b>Nom de votre correspondant : </b>" . $user['first_name'] . " " . $user['last_name'] . "<br>";
                                    echo "<b>Numéro de téléphone : </b>" . $user['phone'] . "<br>";
                                    echo "<b>Adresse mail :</b> " . $user['mail'];
                                } elseif ($re['accepted'] == 'false') {
                                    echo "Offre refusée" . "<br>";
                                    if ($re['comments']) {
                                        echo $re['comments'];
                                    } else {
                                        echo "Pas de commentaire";
                                    }
                                } else {
                                    echo "Offre en attente";
                                }
                                ?>

                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                ?>
                <i>Cette section est vide.</i>
                <?php
            }

            ?>

            <br>
            <HR size=2 align=center width="100%">
            <br>
            <h3>Vos enregistrements</h3>

            <?php

            $req = $db->query("SELECT * FROM save WHERE id_user = $id");
            $res = $req->fetchAll();
            if (!empty($res)) {
                ?>

                <table class="table table-striped table-hover">

                    <tr class="entete">
                        <td><b>Numéro de l'annonce</b></td>
                        <td><b>Utilisateur</b></td>
                        <td><b>Titre de l'annonce</b></td>
                        <td><b>Date de mise en ligne</b></td>
                    </tr>

                    <?php

                    $req = $db->query("SELECT * FROM save WHERE id_user = $id");
                    $saves = $req->fetchAll();
                    foreach ($saves as $save) {
                        $id_ad = $save['id_ad'];
                        $req = $db->query("SELECT * FROM ad WHERE id_ad = $id_ad");
                        $ad = $req->fetch();

                        $id_user = $ad['id_user'];
                        $req2 = $db->query("SELECT * FROM user WHERE id_user = $id_user");
                        $user = $req2->fetch();

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
                <?php
            } else {
                ?>
                <i>Cette section est vide.</i>
                <?php
            }

            ?>
        </div>
    </div>
</div>

<?php
require('includes/footer.html');



