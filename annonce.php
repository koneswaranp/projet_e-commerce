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
    <title>Annonce</title>
</head>
<body>
<?php require('includes/header.php');


if (isset($_SESSION['id'])) {
?>
<div class="row">
    <div class="form col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">

        <h3>Annonce :</h3>
        <?php
        $id_ad = $_GET['id_ad'];
        $req = $db->query("SELECT * FROM ad WHERE id_ad = $id_ad");
        $ad = $req->fetch();

        $id_user = $ad['id_user'];
        $req = $db->query("SELECT * FROM user WHERE id_user = $id_user");
        $user = $req->fetch();
        ?>
        <h4><b>Titre de l'annonce :</b>
            <?php
            echo $ad['title'];
            ?>
        </h4>
        <h5>
            <i>Date limite :

                <?php
                echo $ad['ad_date'];
                ?>
            </i>
        </h5>
        <p>
            <a href="Profil/profil_infos_utilisateur.php?id_user=<?php echo $ad['id_user'] ?>" class="dark_link">
                <?php echo $user['username']; ?>
            </a>
        </p>
        <p>
            <b>Description :</b>

            <?php
            echo $ad['description'];
            ?>
        </p>
        <HR size=2 align=center width="100%">
        <?php
        if ($_SESSION['id'] != $ad['id_user']) {
            ?>
            <ul>
            <li>
                <?php
                $id = $_SESSION['id'];
                $id_ad = $ad['id_ad'];
                $req = $db->query("SELECT * FROM response WHERE id_dev = $id AND id_ad = $id_ad");
                $res = $req->fetchAll();
                if (($id != $id_user) && (empty($res))) {
                    ?>

                    <a href="form_response.php?id=<?php echo $ad['id_ad']?>" class="dark_link">Répondre à cette annonce</a>

                    <?php
                }
                elseif(!empty($res)) {
                    echo "Vous avez déjà répondu à cette annonce.";
                }
                ?>
            </li>

            <?php
            $id_ad = $ad['id_ad'];
            $id_user = $_SESSION['id'];
            $req = $db->query("SELECT * FROM save WHERE id_ad = $id_ad AND id_user = $id_user");
            $save = $req->fetchAll();

            if (empty($save)) {
                ?>
                <li>
                    <form action="" method="post">
                        <input type="submit" name="save" id="save" value="Enregistrer cette annonce">
                    </form>
                </li>
                </ul>
                <?php
                if (isset($_POST['save'])) {
                    $id_save = $_GET['id_ad'];
                    $req = $db->prepare("INSERT INTO save VALUES (:id_user, :id_ad)");
                    $req->execute([
                        ':id_user' => $_SESSION['id'],
                        ':id_ad' => $id_save
                    ]);
                    echo "Annonce enregistrée";
                }
            } else {
                echo "Vous avez déjà enregistré cette annonce";
            }
        }
        }
    ?>
    </div>
</div>

<?php
require('includes/footer.html');

?>
