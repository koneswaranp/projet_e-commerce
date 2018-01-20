<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/header.css">
    <link rel="stylesheet" href="./profil.css">

    <title>Profil</title>
</head>
<body>

<?php
session_start();
require ('../includes/init.php');
?>
<nav class="navbar">
    <div class="link col-xs-9 col-sm-9 col-md-10 col-lg-10">
        <ul>
            <li><a href="../index.php">Accueil</a></li>
            <li>
                <?php
                if (isset($_SESSION['id'])) {
                    ?>
                    <a href="../page_membre.php">Mon Compte</a>
                    <?php
                } else {
                    ?>
                    <a href="../inscription.php">S'inscrire</a>
                    <?php
                }
                ?>
            </li>
            <li>
                <?php
                if (isset($_SESSION['id'])) {
                    ?>
                    <a href="../deconnexion.php">Se déconnecter</a>
                    <?php
                } else {
                    ?>
                    <a href="../connexion.php">Se connecter</a>
                    <?php
                }
                ?>
            </li>
        </ul>
    </div>
    <div class="title col-xs-3 col-sm-3 col-md-2 col-lg-2">
        <h3>DEVONATION</h3>
    </div>
</nav>
<?php
$id = $_GET['id_user'];
$req = $db->query("SELECT * FROM user WHERE id_user = $id");
$user = $req->fetch();
?>

<div class="vide">

</div>
<div class="cover">
    <div id="pdp" class="col-xs-2 col-xs-offset-5 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-5">
    <?php
        if($user['profile_photo']) {
            ?>
            <img src="../<?php echo $user['profile_photo']; ?>" alt="photo_profil" height="150">
        <?php
        }
        else {
            ?>
            <img src="../img/anonyme.jpeg" alt="anonyme">
        <?php
        }
    ?>
    </div>
    <div class="cvr" src="./img/darkness.png" alt="Photo de couverture"></div>
    <h1>
        <?php echo $user['username']; ?>
    </h1>
</div>

<!--
  <p>
        <img class="pdp" width: 10px, height: 10px;
src=" <?php //echo $pdp; ?>" title="Photo de Profil" <? //echo $nom; ?> />
        <!--    <img class="flottant_droite" src=" <? // echo img.urlencode($pdp); ?>" title="Photo de Profil" <? //echo $nom; ?> /> -->

<!-- <span class="label_profil">Adresse email :
        <? //echo htmlspecialchars($email);  <br/> ?> </span>

        <span class="pseudo"><? // echo htmlspecialchars($nom); ?> </span>
    </p>
-->
<br> <br><br><br>
<div class="desc">
    <br>
    <div class="web">
        <h3>Suivez moi !</h3>
        <br>
        <p><b>Github</b> :
            <?php if ($user['github']) {
                ?><a href="<?php echo $user['github']; ?> "><?php echo $user['github']; ?> </a>
                <?php
            } else {
                echo "Non renseigné";
            } ?>
        </p>
        <p><b>Linkedin</b> :
            <?php if ($user['linkedin']) {
                ?><a href="<?php echo $user['linkedin']; ?> "><?php echo $user['linkedin']; ?> </a>
                <?php
            } else {
                echo "Non renseigné";
            } ?>
        </p>
        <p><b>Site personnel </b>:
            <?php if ($user['perso']) {
                ?><a href="<?php echo $user['perso']; ?> "><?php echo $user['perso']; ?> </a>
                <?php
            } else {
                echo "Non renseigné";
            } ?>
        </p>

    </div>
    <div class="description"><h4>Qui suis-je ?</h4>
        <?php if ($user['description']) {
            echo $user['description'];
        } else {
            echo "L'utilisateur n'a pas encore rempli cette section.";
        } ?>
    </div>
</div>
