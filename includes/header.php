<?php
session_start();
require ('includes/init.php');
?>
<nav class="navbar">
    <div class="link col-xs-9 col-sm-9 col-md-10 col-lg-10">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li>
                <?php
                if (isset($_SESSION['id'])) {
                    ?>
                    <a href="page_membre.php">Mon Compte</a>
                    <?php
                } else {
                    ?>
                    <a href="inscription.php">S'inscrire</a>
                    <?php
                }
                ?>
            </li>
            <li>
                <?php
                if (isset($_SESSION['id'])) {
                    ?>
                    <a href="deconnexion.php">Se déconnecter</a>
                    <?php
                } else {
                    ?>
                    <a href="connexion.php">Se connecter</a>
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