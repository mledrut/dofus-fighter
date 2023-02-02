<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dofuuuuuus</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto&display=swap" rel="stylesheet">
</head>

<?php

    $jsonClasses = file_get_contents('characters.json');
    $classes = json_decode($jsonClasses,true);
    $jsonCartes = file_get_contents('maps.json');
    $cartes = json_decode($jsonCartes,true);

    session_start();

    if(!isset($_SESSION["fight"])) {

        // CREATION

        // Création du perso, de l'enemy et de la carte
        $dataMe = $classes[$_GET["me"]];
            // Generation Aléatoire d'enemy
        $randomEnemy = random_int(1, count($classes));
        $dataEnemy = $classes[$randomEnemy - 1];
            // Carte Aléatoire
        $randomCarte = random_int(1, count($cartes));
        $dataCarte = $cartes[$randomCarte - 1];

        $historique = [];

        //Structure de la session dans une variable
        $newSession = [
            "me" => $dataMe,
            "enemy" => $dataEnemy,
            "carte" => $dataCarte,
            "tour" => 1,
            "mLife" => 100,
            "eLife" => 100,
            "historique" => $historique
        ];

        //Application de la variable sur la session
        $_SESSION["fight"] = $newSession;

        //Application des variable sur la page
        $tour = $newSession["tour"];
        $mLife = $newSession["mLife"];
        $eLife = $newSession["eLife"];
        $historique = $newSession["historique"];

    } else {
        // COMBAT EN COURS

        $session = $_SESSION["fight"];
        $dataMe = $session["me"];
        $dataEnemy = $session["enemy"];
        $dataCarte = $session["carte"];

        $tour = $session["tour"];

        $mLife = $session["mLife"];
        $eLife = $session["eLife"];

        $historique = $session["historique"];


        if (isset($_GET["s"])) {
            foreach ($dataMe["attacks"] as $spell) { 
                if ($spell["id"] == $_GET["s"]) {
                    $activeSort = $spell;
                    // var_dump($activeSort);
                }
            }

            //Application du sort allié
            $newELife = $eLife - $activeSort["damage"];
            $eLife = $newELife;

            // Random du sort enemy
            $tableSortsEnemy = $dataEnemy["attacks"];
            $sEnemy = random_int(0, count($tableSortsEnemy) - 1);
            $eSort = $tableSortsEnemy[$sEnemy];

            $newMLife = $mLife - $eSort["damage"];
            $mLife = $newMLife;




            
            $moveDescription = "Tour {$tour} : {$dataMe["name"]} a infligé {$activeSort["damage"]} à {$dataEnemy["name"]} et {$dataEnemy["name"]} a infligé {$eSort["damage"]} à {$dataMe["name"]}";
            $tour++;

            array_push($historique, $moveDescription);

            // var_dump($historique);

            
            // Actualisation de la Session
            $sessionUpdateTour = [ "tour" => $tour];
            $sessionUpdateDescription = [ "historique" => $historique];
            $sessionUpdateElife = [ "eLife" => $newELife];
            $sessionUpdateMLife = [ "mLife" => $newMLife];

            var_dump($sessionUpdateMLife);

            $_SESSION["fight"]=array_merge($session,
                $sessionUpdateDescription,
                $sessionUpdateElife,
                $sessionUpdateMLife,
                $sessionUpdateTour
            );


            // Victoire ou defaite
            if ($eLife <= 0) {
                $url = "fin.php?f=v";
                header( "Location: $url" );
            } else if ($mLife <= 0){
                $url = "fin.php?f=d";
                header( "Location: $url" );
            }




        }
        
    }

   

    
?>

<body>
    <div class="bg-carte">
        <img src="img/cartes/<?= $dataCarte["picture"] ?>.png" alt="">
    </div>



    <div class="container fight">
        <div class="fight-zone">
            <div class="me fight-column">
                <div class="perso-box">
                    <div class="infos">
                        <div class="life">
                            <div class="progress-bar" style="width:<?= $mLife ?>%">
                                <span><?= $mLife ?></span>
                            </div>
                        </div>
                    </div>
                    <img src="img/classes/<?= $dataMe["picture"] ?>.jpeg" alt="">
                </div>
                <div class="sorts">
                    <?php foreach($dataMe["attacks"] as $sort) { ?>
                            <a href="combat.php?s=<?= $sort["id"]?>">
                                <img src="img/sorts/<?= $sort["id"] ?>.png" alt="">
                                <div class="sort-details">
                                    <p class="sort-nom"><?= $sort["name"]?></p>
                                    <span class="sort-nom"><?= $sort["type"]?></span>
                                </div>
                            </a>
                    <?php } ?>
                </div>
            </div>



            <div class="var fight-column">
                <div class="infos-combat">
                    <h3><?= $dataCarte["name"] ?></h3>
                    <p><?= $dataCarte["description"] ?></p>
                    <h5>Tour <?= $tour?></h5>
                </div>
                <div class="historique">
                    <ul>
                        <?php foreach($historique as $action) { ?>
                            <li>
                                <p><?= $action ?></p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="middle-footer">
                    <a href="index.php">Abandonner</a>
                </div>
            </div>



            <div class="enemy fight-column">
                <div class="perso-box">
                    <div class="infos">
                        <div class="life enemy">
                            <div class="progress-bar" style="width:<?= $eLife ?>%">
                                <span><?= $eLife ?></span>
                            </div>
                        </div>
                    </div>
                    <img src="img/classes/<?= $dataEnemy["picture"] ?>.jpeg" alt="">
                </div>
                <div class="sorts enemy">
                    <?php foreach($dataEnemy["attacks"] as $sort) { ?>
                        <div class="enemy-sort">
                            <img src="img/sorts/<?= $sort["id"] ?>.png" alt="">
                            <div class="sort-details">
                                <p class="sort-nom"><?= $sort["name"]?></p>
                                <span class="sort-nom"><?= $sort["type"]?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>